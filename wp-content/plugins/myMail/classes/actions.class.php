<?php if(!defined('ABSPATH')) die('not allowed');

class mymail_actions {
	
	//							  1 	  2   	  3 		  4 		  5			  6			  7
	private $types = array('', 'sent', 'open', 'click', 'unsubscribe', 'bounce', 'hardbounce', 'error');

	public function __construct() {
		
		add_action('plugins_loaded', array( &$this, 'init' ), 1 );

	}

	public function init() {

		add_action('mymail_send', array( &$this, 'send'), 10 , 2);
		add_action('mymail_open', array( &$this, 'open'), 10 , 3);
		add_action('mymail_click', array( &$this, 'click'), 10 , 4);
		add_action('mymail_unsubscribe', array( &$this, 'unsubscribe'), 10 , 2);
		add_action('mymail_bounce', array( &$this, 'bounce'), 10 , 3);
		add_action('mymail_subscriber_error', array( &$this, 'error'), 10 , 3);

		add_action('mymail_cron', array( &$this, 'cleanup'));
		
	}
	
	
	public function get_fields($fields = NULL, $where = NULL) {

		global $wpdb;

		$fields = esc_sql(is_null($fields) ? '*' : (is_array($fields) ? implode(', ', $fields) : $fields));
		
		$sql = "SELECT $fields FROM {$wpdb->prefix}mymail_actions WHERE 1=1";
		if(is_array($where)){
			foreach($where as $key => $value){
				$sql .= ", ".esc_sql($key)." = '".esc_sql($value)."'";
			}
		}

		return $wpdb->get_results($sql);



	}
	
	
	public function send($subscriber_id, $campaign_id) {

		return $this->add_action(array(
			'subscriber_id' => $subscriber_id,
			'campaign_id' => $campaign_id,
			'type' => 1,
		), true);

	}

	public function open($subscriber_id, $campaign_id, $explicit = true) {

		return $this->add_subscriber_action(array(
			'subscriber_id' => $subscriber_id,
			'campaign_id' => $campaign_id,
			'type' => 2,
		), $explicit);

	}

	public function click($subscriber_id, $campaign_id, $link, $index = 0, $explicit = true) {

		$this->open($subscriber_id, $campaign_id, false);

		$link_id = $this->get_link_id($link, $index);

		return $this->add_subscriber_action(array(
			'subscriber_id' => $subscriber_id,
			'campaign_id' => $campaign_id,
			'type' => 3,
			'link_id' => $link_id,
		), $explicit);

	}

	public function unsubscribe($subscriber_id, $campaign_id) {

		return $this->add_action(array(
			'subscriber_id' => $subscriber_id,
			'campaign_id' => $campaign_id,
			'type' => 4,
		));

	}
	
	public function bounce($subscriber_id, $campaign_id, $hard = false) {

		return $this->add_action(array(
			'subscriber_id' => $subscriber_id,
			'campaign_id' => $campaign_id,
			'type' => $hard ? 6 : 5,
			'count' => 1,
		));

	}

	public function error($subscriber_id, $campaign_id, $error = '') {

		mymail('subscribers')->update_meta($subscriber_id, $campaign_id, 'error', $error);
		
		return $this->add_action(array(
			'subscriber_id' => $subscriber_id,
			'campaign_id' => $campaign_id,
			'type' => 7,
		));

	}
	
	private function add_subscriber_action($args, $explicit = true) {
		
		$user_meta = array(
			'lang' => mymail_get_lang(),
			'ip' => mymail_get_ip(),
		);

		if('unknown' !== ($geo = mymail_ip2City())){
			
			$user_meta['geo'] = $geo->country_code.'|'.$geo->city;
			if($geo->city){
				$user_meta['coords'] = floatval($geo->latitude).','.floatval($geo->longitude);
				$user_meta['timeoffset'] = intval($geo->timeoffset);
			}

		}

		//only explicitly opened
		if($args['type'] == 2 && $explicit){

			if($client = mymail_get_user_client()){

				if($client->client == 'Gmail'){
					//remove meta info if client is Gmail (Gmail Image Proxy)
					$user_meta = array();
				}

				$user_meta['client'] = $client->client;
				$user_meta['clientversion'] = $client->version;
				$user_meta['clienttype'] = $client->type;
			}

		}

		mymail('subscribers')->update_meta($args['subscriber_id'], $args['campaign_id'], $user_meta);

		$this->add($args, $explicit);

	}
	private function add_action($args, $explicit = true) {

		$this->add($args, $explicit);
	}
	
	private function add($args, $explicit = true) {

		global $wpdb;

		$now = time();

		$args = wp_parse_args( $args, array(
			'timestamp' => $now,
			'count' => 1
		));

		$sql = "INSERT INTO {$wpdb->prefix}mymail_actions (".implode(', ', array_keys($args)).")";
		
		$sql .= " VALUES ('".implode("','", array_values($args))."') ON DUPLICATE KEY UPDATE";

		$sql .= ($explicit) ? " timestamp = timestamp, count = count+1" : " count = values(count)";

		return !!$wpdb->query($sql);
		
	}

	
	//clear queue with all susbcirbers in $campaign_id but NOT in subscribers
	public function clear($campaign_id, $subscribers) {
		
		global $wpdb;

		$campaign_id = intval($campaign_id);
		$subscribers = array_filter($subscribers, 'is_numeric');

		if(empty($subscribers)) return true;

		$chunks = array_chunk($subscribers, 200);
		
		$success = true;
		
		foreach($chunks as $subscriber_chunk){

			$sql = "DELETE a FROM {$wpdb->prefix}mymail_queue AS a WHERE a.campaign_id = $campaign_id AND a.sent = 0 AND a.subscriber_id NOT IN (".implode(',', $subscriber_chunk).")";

			$success = $success && $wpdb->query($sql);

		}

		return $success;


	}

	public function cleanup(){

		global $wpdb;

		//delete all softbounces where a harbounce exists
		$wpdb->query("DELETE b FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->prefix}mymail_actions AS b ON a.campaign_id = b.campaign_id AND a.subscriber_id = b.subscriber_id AND a.link_id = b.link_id WHERE a.type = 5 AND b.type = 4");

	}

	public function get_by_campaign($campaign_id = NULL, $action = NULL, $strict = false){

		global $wpdb;

		//load one meta
		if(is_numeric($campaign_id)){
			
			$cache_key = 'action_counts_by_campaign_'.$campaign_id;

			if(false !== ($action_counts = wp_cache_get( $cache_key, 'mymail' ))){

				if(is_null($action)) return $action_counts;

				return isset($action_counts[$action]) ? $action_counts[$action] : NULL;

			}
		
			$campaign_ids = array($campaign_id);
		//load array
		}elseif(is_array($campaign_id)){
			
			sort($campaign_id);
			$campaign_ids = $campaign_id;
			$cache_key = 'action_counts_by_campaign_array';
		
		//load all
		}else{
		
			$cache_key = 'action_counts_by_campaign';
		}


		if(false === ($action_counts = wp_cache_get( $cache_key, 'mymail' ))){
		
			$default = array(
				'sent' => 0,
				'sent_total' => 0,
				'opens' => 0,
				'opens_total' => 0,
				'clicks' => 0,
				'clicks_total' => 0,
				'unsubscribes' => 0,
				'softbounces' => 0,
				'bounces' => 0,
				'errors' => 0,
				'errors_total' => 0,
			);

			$action_counts = array();
			
			// $sql = "SELECT a.campaign_id AS ID, type, COUNT(DISTINCT a.campaign_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a GROUP BY a.type, a.campaign_id";
			
			// $sql = "SELECT a.campaign_id AS ID, type, COUNT(DISTINCT a.campaign_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a GROUP BY a.type, a.campaign_id UNION SELECT b.campaign_id AS ID, type, COUNT(DISTINCT b.campaign_id) AS count, SUM(b.count) AS total FROM {$wpdb->prefix}mymail_subscriber_actions AS b GROUP BY b.type, b.campaign_id";
			
			// $sql = "SELECT a.campaign_id AS ID, type, COUNT(a.campaign_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a GROUP BY a.type, a.campaign_id";

			//$sql = "SELECT a.campaign_id AS ID, b.parent_id, type, COUNT(a.campaign_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->prefix}mymail_campaigns AS b ON a.campaign_id = b.campaign_id GROUP BY a.type, a.campaign_id";
			
			//$sql = "SELECT a.campaign_id AS ID, b.meta_value AS parent_id, type, COUNT(DISTINCT a.subscriber_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->postmeta} AS b ON a.campaign_id = b.post_id AND b.meta_key = '_mymail_parent_id' GROUP BY a.type, a.campaign_id";

			$sql = "SELECT a.post_id AS ID, a.meta_value AS parent_id FROM {$wpdb->postmeta} AS a WHERE a.meta_key = '_mymail_parent_id'";
			
			if(isset($campaign_ids)) $sql .= " AND a.meta_value IN (".implode(',', $campaign_ids).")";
			
			$parent_ids = array();
			$parents = $wpdb->get_results($sql);
			foreach($parents as $parent){
				$parent_ids[$parent->ID] = $parent->parent_id;
			}

			$sql = "SELECT a.campaign_id AS ID, type, COUNT(DISTINCT a.subscriber_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a";

			if(isset($campaign_ids)) $sql .= " WHERE a.campaign_id IN (".implode(',', $campaign_ids).")";
			if(!empty($parent_ids)) $sql .= " OR a.campaign_id IN (".implode(',', array_keys($parent_ids)).")";
			
			$sql .= " GROUP BY a.type, a.campaign_id";

			$result = $wpdb->get_results($sql);

			foreach($result as $row){
				
				if(!isset($action_counts[$row->ID])) $action_counts[$row->ID] = $default;
				
				if(($hasparent = isset($parent_ids[$row->ID])) && !isset($action_counts[$parent_ids[$row->ID]]))
					$action_counts[$parent_ids[$row->ID]] = $default;

				//sent
				if($row->type == 1){
					$action_counts[$row->ID]['sent'] = intval($row->count);
					$action_counts[$row->ID]['sent_total'] = intval($row->total);
					if($hasparent){
						$action_counts[$parent_ids[$row->ID]]['sent'] += intval($row->count);
						$action_counts[$parent_ids[$row->ID]]['sent_total'] += intval($row->total);
					}
				}
				//opens
				else if($row->type == 2){
					$action_counts[$row->ID]['opens'] = intval($row->count);
					$action_counts[$row->ID]['opens_total'] = intval($row->total);
					if($hasparent){
						$action_counts[$parent_ids[$row->ID]]['opens'] += intval($row->count);
						$action_counts[$parent_ids[$row->ID]]['opens_total'] += intval($row->total);
					}
				}
				//clicks
				else if($row->type == 3){
					$action_counts[$row->ID]['clicks'] = intval($row->count);
					$action_counts[$row->ID]['clicks_total'] = intval($row->total);
					if($hasparent){
						$action_counts[$parent_ids[$row->ID]]['clicks'] += intval($row->count);
						$action_counts[$parent_ids[$row->ID]]['clicks_total'] += intval($row->total);
					}
				}
				//unsubscribes
				else if($row->type == 4){
					$action_counts[$row->ID]['unsubscribes'] = intval($row->count);
					if($hasparent){
						$action_counts[$parent_ids[$row->ID]]['unsubscribes'] += intval($row->count);
					}
				}
				//softbounces
				else if($row->type == 5){
					$action_counts[$row->ID]['softbounces'] = intval($row->count);
					if($hasparent){
						$action_counts[$parent_ids[$row->ID]]['softbounces'] += intval($row->count);
					}
				}
				//bounces
				else if($row->type == 6){
					$action_counts[$row->ID]['bounces'] = intval($row->count);
					$action_counts[$row->ID]['sent'] -= intval($row->count);
					if($hasparent){
						$action_counts[$parent_ids[$row->ID]]['bounces'] += intval($row->count);
						$action_counts[$parent_ids[$row->ID]]['sent'] -= intval($row->count);
					}
				}
				//error
				else if($row->type == 7){
					$action_counts[$row->ID]['errors'] = floor($row->count);
					$action_counts[$row->ID]['errors_total'] = floor($row->total);
					if($hasparent){
						$action_counts[$parent_ids[$row->ID]]['errors'] += intval($row->count);
						$action_counts[$parent_ids[$row->ID]]['errors_total'] += intval($row->total);
					}
				}
			}

			if(isset($campaign_ids)){
				foreach($campaign_ids as $id){
					wp_cache_add( 'action_counts_by_campaign_'.$id, (isset($action_counts[$id]) ? $action_counts[$id] : $default), 'mymail' );
				}
			}
			wp_cache_add( $cache_key, $action_counts, 'mymail' );

		}

		if(is_null($campaign_id) && is_null($action)) return $action_counts;

		if(is_array($campaign_id) && is_null($action)) return $action_counts;
		
		if(is_null($action)) return isset($action_counts[$campaign_id]) ? $action_counts[$campaign_id] : $default;

		return isset($action_counts[$campaign_id]) && isset($action_counts[$campaign_id][$action]) ? $action_counts[$campaign_id][$action] : 0;

	}


	public function get_by_subscriber($subscriber_id = NULL, $action = NULL, $strict = false){

		global $wpdb;

		//load one meta
		if(is_numeric($subscriber_id)){
			
			$cache_key = 'action_counts_by_subscriber_'.$subscriber_id;

			if(false !== ($action_counts = wp_cache_get( $cache_key, 'mymail' ))){

				if(is_null($action)) return $action_counts;

				return isset($action_counts[$action]) ? $action_counts[$action] : NULL;

			}
		
			$subscriber_ids = array($subscriber_id);
		//load array
		}elseif(is_array($subscriber_id)){
			
			sort($subscriber_id);
			$subscriber_ids = $subscriber_id;
			$cache_key = 'action_counts_by_subscriber_array';
		
		//load all
		}else{
		
			$cache_key = 'action_counts_by_subscriber';
		}

		if(false === ($action_counts = wp_cache_get( $cache_key, 'mymail' ))){
			
			$default = array(
				'sent' => 0,
				'sent_total' => 0,
				'opens' => 0,
				'opens_total' => 0,
				'clicks' => 0,
				'clicks_total' => 0,
				'unsubscribes' => 0,
				'softbounces' => 0,
				'bounces' => 0,
				'errors' => 0,
				'errors_total' => 0,
			);

			$action_counts = array();
			
			$sql = "SELECT a.campaign_id, a.subscriber_id AS ID, type, COUNT(DISTINCT a.subscriber_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a";

			if(isset($subscriber_ids)) $sql .= " WHERE a.subscriber_id IN (".implode(',', $subscriber_ids).")";
			//if($strict) $sql .= " WHERE subscriber_id = ".intval($subscriber_id);
			
			$sql .= " GROUP BY a.type, a.subscriber_id, a.campaign_id";

			//$sql = "SELECT a.campaign_id, a.subscriber_id AS ID, type, COUNT(DISTINCT a.subscriber_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a GROUP BY a.type, a.subscriber_id, a.campaign_id UNION SELECT b.campaign_id, b.subscriber_id AS ID, type, COUNT(DISTINCT b.subscriber_id) AS count, SUM(b.count) AS total FROM {$wpdb->prefix}mymail_subscriber_actions AS b GROUP BY b.type, b.subscriber_id, b.campaign_id";

			$result = $wpdb->get_results($sql);


			foreach($result as $row){
				
				if(!isset($action_counts[$row->ID]))  $action_counts[$row->ID] = $default;

				//sent
				if($row->type == 1){
					$action_counts[$row->ID]['sent'] += intval($row->count);
					$action_counts[$row->ID]['sent_total'] += intval($row->total);
				}
				//opens
				else if($row->type == 2){
					$action_counts[$row->ID]['opens'] += intval($row->count);
					$action_counts[$row->ID]['opens_total'] += intval($row->total);
				}
				//clicks
				else if($row->type == 3){
					$action_counts[$row->ID]['clicks'] += intval($row->count);
					$action_counts[$row->ID]['clicks_total'] += intval($row->total);
				}
				//unsubscribes
				else if($row->type == 4){
					$action_counts[$row->ID]['unsubscribes'] += intval($row->count);
				}
				//softbounces
				else if($row->type == 5){
					$action_counts[$row->ID]['softbounces'] += intval($row->count);
				}
				//bounces
				else if($row->type == 6){
					$action_counts[$row->ID]['bounces'] += intval($row->count);
				}
				//error
				else if($row->type == 7){
					$action_counts[$row->ID]['errors'] += floor($row->count);
					$action_counts[$row->ID]['errors_total'] += floor($row->total);
				}
			}

			if(isset($subscriber_ids)){
				foreach($subscriber_ids as $id){
					wp_cache_add( 'action_counts_by_subscriber_'.$id, (isset($action_counts[$id]) ? $action_counts[$id] : $default), 'mymail' );
				}
			}
			wp_cache_add( $cache_key, $action_counts, 'mymail' );

		}

		if(is_null($subscriber_id) && is_null($action)) return $action_counts;

		if(is_array($subscriber_id) && is_null($action)) return $action_counts;
		
		if(is_null($action)) return isset($action_counts[$subscriber_id]) ? $action_counts[$subscriber_id] : $default;

		return isset($action_counts[$subscriber_id]) && isset($action_counts[$subscriber_id][$action]) ? $action_counts[$subscriber_id][$action] : 0;

	}


	public function get_by_list($list_id = NULL, $action = NULL, $strict = false){

		global $wpdb;

		$key = 'action_counts_by_list_'.($strict ? $list_id : '');

		if(false === ($action_counts = wp_cache_get( $key, 'mymail' ))){
			
			$default = array(
				'sent' => 0,
				'sent_total' => 0,
				'opens' => 0,
				'opens_total' => 0,
				'clicks' => 0,
				'clicks_total' => 0,
				'unsubscribes' => 0,
				'softbounces' => 0,
				'bounces' => 0,
				'errors' => 0,
				'errors_total' => 0,
			);

			$action_counts = array();
			
			$sql = "SELECT b.list_id AS ID, type, COUNT(DISTINCT a.subscriber_id) AS count, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a";

			$sql .= " LEFT JOIN {$wpdb->prefix}mymail_lists_subscribers AS b ON a.subscriber_id = b.subscriber_id WHERE a.campaign_id != 0";

			if($strict) $sql .= " AND b.list_id = ".intval($list_id);
			
			$sql .= " GROUP BY b.list_id, a.type, a.campaign_id";

			$result = $wpdb->get_results($sql);

			foreach($result as $row){
				
				if(!isset($action_counts[$row->ID]))  $action_counts[$row->ID] = $default;

				//sent
				if($row->type == 1){
					$action_counts[$row->ID]['sent'] += intval($row->count);
					$action_counts[$row->ID]['sent_total'] += intval($row->total);
				}
				//opens
				else if($row->type == 2){
					$action_counts[$row->ID]['opens'] += intval($row->count);
					$action_counts[$row->ID]['opens_total'] += intval($row->total);
				}
				//clicks
				else if($row->type == 3){
					$action_counts[$row->ID]['clicks'] += intval($row->count);
					$action_counts[$row->ID]['clicks_total'] += intval($row->total);
				}
				//unsubscribes
				else if($row->type == 4){
					$action_counts[$row->ID]['unsubscribes'] += intval($row->count);
				}
				//softbounces
				else if($row->type == 5){
					$action_counts[$row->ID]['softbounces'] += intval($row->count);
				}
				//bounces
				else if($row->type == 6){
					$action_counts[$row->ID]['bounces'] += intval($row->count);
				}
				//error
				else if($row->type == 7){
					$action_counts[$row->ID]['errors'] += floor($row->count);
					$action_counts[$row->ID]['errors_total'] += floor($row->total);
				}
			}

			wp_cache_add( $key, $action_counts, 'mymail' );

		}

		if(is_null($list_id) && is_null($action)) return $action_counts;

		if(is_null($action)) return isset($action_counts[$list_id]) ? $action_counts[$list_id] : $default;

		return isset($action_counts[$list_id]) && isset($action_counts[$list_id][$action]) ? $action_counts[$list_id][$action] : 0;

	}


	public function get_chronological_actions($scale = 'days', $since = NULL, $desc = true){

		global $wpdb;

		$timestring = array(
			'days' => '%Y-%m-%d',
			'hours' => '%Y-%m-%d %h:00:00',
			'minutes' => '%Y-%m-%d %h:%s:00'
		);
		$times = array(
			'days' => 86400,
			'hours' => 3600,
			'minutes' => 60
		);

		if(!isset($timestring[$scale])) $scale = 'days';
		if(is_null($since))	$since = strtotime('-1 '.$scale);

		if(false === ($actions = wp_cache_get( 'chronological_actions_'.$scale.$since.$desc, 'mymail' ))){
			
			$timeoffset = get_option('gmt_offset')*3600;
			$default = array(
				'sent' => 0,
				'opens' => 0,
				'clicks' => 0,
				'unsubscribes' => 0,
				'softbounces' => 0,
				'bounces' => 0,
				'errors' => 0,
				'signups' => 0,
			);

			$actions = array();

			$sql = "SELECT FROM_UNIXTIME(a.timestamp+$timeoffset, '".$timestring[$scale]."') AS date, COUNT(FROM_UNIXTIME(a.timestamp+$timeoffset, '".$timestring[$scale]."')) AS count, a.type FROM {$wpdb->prefix}mymail_actions AS a";

			$sql .= $wpdb->prepare(" WHERE a.timestamp > %d", $since+$timeoffset);

			$sql .= " GROUP BY FROM_UNIXTIME(a.timestamp+$timeoffset, '".$timestring[$scale]."'), a.type ORDER BY a.timestamp";

			$result = $wpdb->get_results($sql);

			$start = strtotime('00:00', $since);

			$timeframe = ceil((time()-$since)/$times[$scale]);

			for ($i=1; $i <= $timeframe; $i++) {
				$s = $start+($times[$scale]*$i);
				$actions[$s] = $default;
			}

			foreach($result as $row){

				$timestr = strtotime($row->date);

				if(!isset($actions[$timestr])) continue;
				
				//sent
				if($row->type == 1){
					$actions[$timestr]['sent'] = intval($row->count);
				}
				//opens
				else if($row->type == 2){
					$actions[$timestr]['opens'] = intval($row->count);
				}
				//clicks
				else if($row->type == 3){
					$actions[$timestr]['clicks'] = intval($row->count);
				}
				//unsubscribes
				else if($row->type == 4){
					$actions[$timestr]['unsubscribes'] = intval($row->count);
				}
				//softbounces
				else if($row->type == 5){
					$actions[$timestr]['softbounces'] = intval($row->count);
				}
				//bounces
				else if($row->type == 6){
					$actions[$timestr]['bounces'] = intval($row->count);
				}
				//error
				else if($row->type == 7){
					$actions[$timestr]['errors'] = floor($row->count);
				}
			}

			$sql = "SELECT FROM_UNIXTIME(a.signup+$timeoffset, '".$timestring[$scale]."') AS date, COUNT(FROM_UNIXTIME(a.signup+$timeoffset, '".$timestring[$scale]."')) AS count FROM {$wpdb->prefix}mymail_subscribers AS a";

			$sql .= $wpdb->prepare(" WHERE a.signup > %d AND a.status != 0", $since+$timeoffset);

			$sql .= " GROUP BY FROM_UNIXTIME(a.signup+$timeoffset, '".$timestring[$scale]."') ORDER BY a.signup";

			$result = $wpdb->get_results($sql);
			foreach($result as $row){

				$timestr = strtotime($row->date);
				if(!isset($actions[$timestr])) continue;
				$actions[$timestr]['signups'] = intval($row->count);
			}

			if(!$desc) krsort($actions);

			wp_cache_add( 'chronological_actions_'.$scale.$since.$desc, $actions, 'mymail' );

		}

		return $actions;

	}


	public function get_campaign_actions($campaign_id, $subscriber_id = NULL, $action = NULL, $cache = true){

		global $wpdb;

		if(false === ($actions = wp_cache_get( 'campaign_actions', 'mymail' ))){
			
			$default = array(
				'sent' => 0,
				'sent_total' => 0,
				'opens' => 0,
				'opens_total' => 0,
				'clicks' => array(),
				'clicks_total' => 0,
				'unsubscribes' => 0,
				'softbounces' => 0,
				'softbounces_total' => 0,
				'bounces' => 0,
				'errors' => 0,
				'errors_total' => 0,
			);

			$actions = array();
			
			$sql = "SELECT a.subscriber_id AS ID, type, COUNT(DISTINCT a.subscriber_id) AS count, SUM(a.count) AS total, a.timestamp, a.link_id, b.link FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->prefix}mymail_links AS b ON b.ID = a.link_id WHERE a.campaign_id = %d";

			//if not cached just get from the current user
			if(!$cache && $subscriber_id) $sql .= " AND a.subscriber_id = ".intval($subscriber_id);
			
			$sql .= " GROUP BY a.type, a.link_id, a.subscriber_id, a.campaign_id";

			$result = $wpdb->get_results($wpdb->prepare($sql, $campaign_id));

			foreach($result as $row){
				
				if(!isset($actions[$row->ID]))  $actions[$row->ID] = $default;

				//sent
				if($row->type == 1){
					$actions[$row->ID]['sent'] = intval($row->timestamp);
					$actions[$row->ID]['sent_total'] = intval($row->total);
				}
				//opens
				else if($row->type == 2){
					$actions[$row->ID]['opens'] = intval($row->timestamp);
					$actions[$row->ID]['opens_total'] = intval($row->total);
				}
				//clicks
				else if($row->type == 3){
					$actions[$row->ID]['clicks'][$row->link] = intval($row->total);
					$actions[$row->ID]['clicks_total'] += intval($row->total);
				}
				//unsubscribes
				else if($row->type == 4){
					$actions[$row->ID]['unsubscribes'] = intval($row->timestamp);
				}
				//softbounces
				else if($row->type == 5){
					$actions[$row->ID]['softbounces'] = intval($row->timestamp);
					$actions[$row->ID]['softbounces_total'] += intval($row->total);
				}
				//bounces
				else if($row->type == 6){
					$actions[$row->ID]['bounces'] = intval($row->timestamp);
				}
				//error
				else if($row->type == 7){
					$actions[$row->ID]['errors'] = floor($row->timestamp);
					$actions[$row->ID]['errors_total'] = floor($row->total);
				}
			}

			if($cache) wp_cache_add( 'campaign_actions', $actions, 'mymail' );

		}

		if(is_null($subscriber_id) && is_null($action)) return $actions;

		if(is_null($action)) return isset($actions[$subscriber_id]) ? $actions[$subscriber_id] : $default;

		return isset($actions[$subscriber_id]) && isset($actions[$subscriber_id][$action]) ? $actions[$subscriber_id][$action] : false;

	}
	
	public function get_clicked_links($campaign_id){

		global $wpdb;

		if(false === ($clicked_links = wp_cache_get( 'clicked_links_'.$campaign_id, 'mymail' ))){

			$sql = "SELECT c.link, c.i, COUNT(*) AS clicks, SUM(a.count) AS total FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->postmeta} AS b ON b.meta_key = '_mymail_parent_id' AND b.post_id = a.campaign_id LEFT JOIN {$wpdb->prefix}mymail_links AS c ON c.ID = a.link_id WHERE (a.campaign_id = %d OR b.meta_value = %d) AND a.type = 3 GROUP BY a.campaign_id, a.link_id ORDER BY c.i ASC, total DESC, clicks DESC";

			$result = $wpdb->get_results($wpdb->prepare($sql, $campaign_id, $campaign_id));

			$clicked_links = array();
			
			foreach($result as $row){
				$clicked_links[$row->link][$row->i] = array(
					'clicks' => $row->clicks,
					'total' => $row->total,
				);
			}

			wp_cache_add( 'clicked_links_'.$campaign_id, $clicked_links, 'mymail' );

		}

		return $clicked_links;

	}

	public function get_clients($campaign_id){

		global $wpdb;

		if(false === ($clients = wp_cache_get( 'clients_'.$campaign_id, 'mymail' ))){

			$sql = "SELECT COUNT(DISTINCT a.subscriber_id) AS count, a.meta_value AS name, b.meta_value AS type, c.meta_value AS version FROM {$wpdb->prefix}mymail_subscriber_meta AS a LEFT JOIN {$wpdb->prefix}mymail_subscriber_meta AS b ON a.subscriber_id = b.subscriber_id AND a.campaign_id = b.campaign_id LEFT JOIN {$wpdb->prefix}mymail_subscriber_meta AS c ON a.subscriber_id = c.subscriber_id AND a.campaign_id = c.campaign_id WHERE a.meta_key = 'client' AND b.meta_key = 'clienttype' AND c.meta_key = 'clientversion' AND a.campaign_id = %d GROUP BY a.meta_value, c.meta_value ORDER BY count DESC";

			$result = $wpdb->get_results($wpdb->prepare($sql, $campaign_id));

			$total = !empty($result) ? array_sum(wp_list_pluck($result, 'count' )) : 0;

			$clients = array();
			
			foreach($result as $row){
				$clients[] = array(
					'name' => $row->name,
					'type' => $row->type,
					'version' => $row->version,
					'count' => $row->count,
					'percentage' => $row->count/$total,
				);
			}

			wp_cache_add( 'clients_'.$campaign_id, $clients, 'mymail' );

		}

		return $clients;

	}

	public function get_environment($campaign_id){

		global $wpdb;

		if(false === ($environment = wp_cache_get( 'environment_'.$campaign_id, 'mymail' ))){

			$sql = "SELECT COUNT(DISTINCT a.subscriber_id) AS count, a.meta_value AS type FROM {$wpdb->prefix}mymail_subscriber_meta AS a LEFT JOIN {$wpdb->prefix}mymail_actions AS b ON a.subscriber_id = b.subscriber_id AND a.campaign_id = b.campaign_id WHERE a.meta_key = 'clienttype' AND a.campaign_id = %d AND b.type = 2 GROUP BY a.meta_value ORDER BY count DESC";

			$result = $wpdb->get_results($wpdb->prepare($sql, $campaign_id));

			$total = !empty($result) ? array_sum(wp_list_pluck($result, 'count' )) : 0;

			$environment = array();
			
			foreach($result as $row){
				$environment[$row->type] = array(
					'count' => $row->count,
					'percentage' => $row->count/$total,
				);
			}

			wp_cache_add( 'environment_'.$campaign_id, $environment, 'mymail' );

		}

		return $environment;

	}

	public function get_error_list($campaign_id){

		global $wpdb;

		if(false === ($error_list = wp_cache_get( 'error_list_'.$campaign_id, 'mymail' ))){

			$sql = "SELECT s.ID, s.email, a.timestamp, a.count, b.meta_value AS errormsg FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->prefix}mymail_subscriber_meta AS b ON a.subscriber_id = b.subscriber_id AND a.campaign_id = b.campaign_id LEFT JOIN {$wpdb->prefix}mymail_subscribers AS s ON s.ID = a.subscriber_id WHERE a.campaign_id = %d AND a.type = 7 AND b.meta_key = 'error' ORDER BY a.timestamp DESC";

			$error_list = $wpdb->get_results($wpdb->prepare($sql, $campaign_id));

			wp_cache_add( 'error_list_'.$campaign_id, $error_list, 'mymail' );

		}

		return $error_list;

	}

	public function get_activity($campaign_id = NULL, $subscriber_id = NULL, $limit = NULL, $exclude = NULL) {

		global $wpdb;

		$exclude = (!is_null($exclude) && !is_array($exclude) ? array($exclude) : $exclude);

		$sql = "SELECT p.post_title AS campaign_title, p.post_status AS campaign_status, a.*, b.link, error.meta_value AS error FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->prefix}mymail_links AS b ON b.ID = a.link_id LEFT JOIN {$wpdb->prefix}mymail_subscriber_meta AS error ON error.subscriber_id = a.subscriber_id AND error.campaign_id = a.campaign_id AND error.meta_key = 'error' LEFT JOIN {$wpdb->posts} AS p ON p.ID = a.campaign_id WHERE 1";

		if(!is_null($campaign_id)) $sql .= " AND a.campaign_id = ".intval($campaign_id);
		if(!is_null($subscriber_id)) $sql .= " AND a.subscriber_id = ".intval($subscriber_id);
		if(!is_null($exclude)) $sql .= " AND a.type NOT IN (".implode(',', array_filter($exclude, 'is_numeric')).")";

		$sql .= " ORDER BY a.timestamp DESC, a.type DESC";
		
		if(!is_null($limit)) $sql .= " LIMIT ".intval($limit);

		$actions = $wpdb->get_results($sql);

		return $actions;

	}

	public function get_list_activity($list_id = NULL, $limit = NULL, $exclude = NULL) {

		global $wpdb;

		$exclude = (!is_null($exclude) && !is_array($exclude) ? array($exclude) : $exclude);

		$sql = "SELECT p.post_title AS campaign_title, a.*, b.link FROM {$wpdb->prefix}mymail_actions AS a INNER JOIN (SELECT min(timestamp) as max_ts, type FROM {$wpdb->prefix}mymail_actions AS a LEFT JOIN {$wpdb->prefix}mymail_lists_subscribers AS ab ON a.subscriber_id = ab.subscriber_id WHERE 1";
		
		if(!is_null($list_id)) $sql .= " AND ab.list_id = ".intval($list_id);


		$sql .= " GROUP BY type, link_id) AS a2 ON a.timestamp = a2.max_ts and a.type = a2.type LEFT JOIN {$wpdb->prefix}mymail_links AS b ON b.ID = a.link_id LEFT JOIN {$wpdb->posts} AS p ON p.ID = a.campaign_id LEFT JOIN {$wpdb->prefix}mymail_lists_subscribers AS ab ON a.subscriber_id = ab.subscriber_id WHERE 1";
		
		if(!is_null($list_id)) $sql .= " AND ab.list_id = ".intval($list_id);
		if(!is_null($exclude)) $sql .= " AND a.type NOT IN (".implode(',', array_filter($exclude, 'is_numeric')).")";

		$sql .= " GROUP BY a.type, a.link_id ORDER BY a.timestamp DESC, a.type DESC";
		
		if(!is_null($limit)) $sql .= " LIMIT ".intval($limit);

		$actions = $wpdb->get_results($sql);

		return $actions;

	}

	public function get_link_id($link, $index = 0){

		global $wpdb;

		if($id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->prefix}mymail_links WHERE `link` = %s AND `i` = %d LIMIT 1", $link, intval($index)))){

			return intval($id);
		
		}else if($wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}mymail_links (`link`, `i`) VALUES (%s, %d)", $link, $index))){

			return intval($wpdb->insert_id);

		}
		
		return NULL;

	}
	
	
}
?>