<?php

class UM_Reviews_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_top_rated', array(&$this, 'ultimatemember_top_rated'), 1);
		add_shortcode('ultimatemember_user_position', array(&$this, 'ultimatemember_user_position'), 1);
		add_shortcode('ultimatemember_top_50', array(&$this, 'ultimatemember_top_50'), 1);
		add_shortcode('ultimatemember_most_rated', array(&$this, 'ultimatemember_most_rated'), 1);
		add_shortcode('ultimatemember_lowest_rated', array(&$this, 'ultimatemember_lowest_rated'), 1);
		
	}
	

	/***
	***	@Shortcode
	***/
	function ultimatemember_user_position( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 9999
		);

		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_total',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);
		
		$query_args['meta_query'][] = array(
			'key' => 'role',
			'value' => 'concursante-portada-mayo-2015',
			'compare' => '='
		);

		$users = new WP_User_Query( $query_args );

		?>

		<?php 
		$i=0;
		foreach( $users->results as $user_id ) {
			$i += 1;
			$current_user_id = get_current_user_id();

			if ($user_id == $current_user_id) {
				$position_user = $i;
				$count = round($um_reviews->api->get_rating( $user_id ));
		?>
				<h4>Tu posición en el concurso:</h4>
				<ul class="um-reviews-widget top-rated own-ranking top-rated-user">
					<li>
						<div class="um-reviews-widget-pic">
							<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 100 ); ?></a>
						</div>
						
						<div class="um-reviews-widget-user">
							<div class="phasionate-position"><?php echo $position_user; ?></div>
							<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
							<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $count; ?>"><span><?php if($count==1){ echo "LLevas ".$count." voto."; }else{ echo "LLevas ".$count." votos."; }; ?></span></div>
					
						</div><div class="um-clear"></div>
					</li>
				</ul>
		<?php
				break;
			}
		}	

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_top_50( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 99999
		);

		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();

		if (isset($_GET['members_page'])){
			$page_number = $_GET['members_page'];
		}else{
			$page_number = 1;
		}

		$total_participants_show_basic = 19;
		if($page_number>1){
			$total_participants_show = $total_participants_show_basic  + 1;
			$offset_query = (($page_number-1)*$total_participants_show)-1;
		}else{
			$total_participants_show = $total_participants_show_basic;
			$offset_query = ($page_number-1)*$total_participants_show;
		}
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_total',
			'orderby' => 'meta_value',
			'order' => 'desc',
			'offset' => $offset_query
		);
		$query_args['meta_query'][] = array(
			'key' => 'role',
			'value' => 'concursante-portada-mayo-2015',
			'compare' => '='
		);


		$users = new WP_User_Query( $query_args );

		$total_participants = count($users->results) + $offset_query;
		$n_pages = ceil($total_participants/$total_participants_show_basic);
		?>

		<?php
			global $ultimatemember;
		?>

		
		<div class="selectBox selectBoxup">
			<span> Muestra página: </span>
			<select onChange="window.location.href=this.value" class="um-s1" style="width: 100px">
				<?php
				for( $g=1; $g<=$n_pages; $g++ ){
					if ($g != $page_number){
				?>
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>"><?php echo $g; ?></option>
				<?php	
					}else{
				?>		
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>" selected><?php echo $g; ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>

		<ul class="um-reviews-widget top-rated top_portada_mayo <?php if($page_number == 1){ echo "first_page_ranking_list"; }?>">
		
			<?php 
			$i = $offset_query+1;
			$current_user_id = get_current_user_id();
			foreach( $users->results as $user_id ) {
				$count = round($um_reviews->api->get_rating( $user_id ));
				get_avatar( $user_id, 100 );
			?>
			
					<li class="<?php if ($user_id == $current_user_id){ ?> current-user-in-top-list <?php } ?>">

						<div class="um-reviews-widget-pic">
							<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 100 ); ?></a>
						</div>
						
						<div class="um-reviews-widget-user">
							<div class="phasionate-position"><?php echo $i?></div>
							<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>

							
							
							<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $count; ?>"><span><?php echo "LLeva <span id='phasionate-score".$user_id."'>".$count."</span> "; if($count==1){ echo "voto."; }else{ echo "votos."; } ?></span></span></div>
					
							<?php
							if (!$um_reviews->api->already_reviewed($user_id)){
							?>
							<div class="review-form">
								<form class="um-reviews-form" action="" method="post">	
									<span class="um-reviews-rate" data-key="rating" data-number="1" data-score="0" style="display: none !important;"></span>

									<span class="um-reviews-title"><input type="text" name="title" placeholder="<?php _e('Enter subject...','um-reviews'); ?>" style="display: none !important;" /></span>
									
									<span class="um-reviews-meta" style="display: none !important;" ><?php printf(__('by <a href="%s">%s</a>, %s','um-reviews'), um_user_profile_url(), um_user('display_name'), current_time('F d, Y') ); ?></span>

									<span class="um-reviews-content" style="display: none !important;" ><textarea name="content" placeholder="<?php _e('Enter your review...','um-reviews'); ?>" style="display: none !important;"></textarea></span>

									<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
									<input type="hidden" name="reviewer_id" id="reviewer_id" value="<?php echo get_current_user_id(); ?>" />
									<input type="hidden" name="reviewer_publish" id="reviewer_publish" value="<?php echo um_user('can_publish_review'); ?>" />
									<input type="hidden" name="action" id="action" value="um_review_add" />
									
									<div class="um-field-error" style="display:none"></div>
									
									<span class="um-reviews-send">
										<input type="submit" value="<?php _e('¡Vótame!','um-reviews'); ?>" class="um-button" />
									</span>
								</form>
							</div>
							<div id="ya-votado-<?php echo $user_id ?>" class="ya-votado" style="display: none;"><span>¡Vuelve a votarle mañana!</span></div>
							<div id="spinner-place-<?php echo $user_id ?>" class="spinner-place"></div>
							<?php
							}elseif ($user_id == get_current_user_id()){
								?><div id="ya-votado-<?php echo $user_id ;?>"><span></span></div><?php
							}else{
								?><div id="ya-votado-<?php echo $user_id ;?>" class="ya-votado"><span>¡Vuelve a votarle mañana!</span></div><?php
							}?>

						</div><div class="um-clear"></div>
						
					</li>
			
			<?php   
				$i += 1;
				if ( $i-$offset_query>$total_participants_show ){
					break;
				}
			}
			?>
			
		</ul>
		
		<div class="selectBox selectBoxdown">
			<span> Muestra página: </span>
			<select onChange="window.location.href=this.value" class="um-s1" style="width: 100px">
				<?php
				for( $g=1; $g<=$n_pages; $g++ ){
					if ($g != $page_number){
				?>
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>"><?php echo $g; ?></option>
				<?php	
					}else{
				?>		
						<option value="<?php echo $ultimatemember->permalinks->add_query( 'members_page', $g ); ?>" selected><?php echo $g; ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>

		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/***
	***	@Shortcode
	***/
	function ultimatemember_most_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_total',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);

		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"><span id="phasionate-score"><?php echo $count; ?></span></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le ha votado %s phasionista','um-reviews'), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le han votado %s phasionistas','um-reviews'), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}





	/***
	***	@Shortcode
	***/
	function ultimatemember_top_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_avg',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);
		
		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"><span id="phasionate-score"><?php echo $count; ?></span></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le ha votado %s phasionista','um-reviews'), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le han votado %s phasionistas','um-reviews'), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_lowest_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_avg',
			'orderby' => 'meta_value',
			'order' => 'asc'
		);
		
		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="1" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"><span id="phasionate-score"><?php echo $count; ?></span></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le ha votado %s phasionista','um-reviews'), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('Le han votado %s phasionistas','um-reviews'), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}
