<?php


//Fontello icons array
if (!function_exists('kleo_icons_array')) {
	function kleo_icons_array() {

		$icons= array('');

		$icons_json = file_get_contents( trailingslashit(K_ELEM_PLUGIN_DIR) . 'compat/plugin-js-composer/font-icons.json');
		if ($icons_json) {
			$arr = json_decode($icons_json, true);
			foreach($arr['glyphs'] as $icon) 
			{
				$icons[$icon['css']] = $icon['css'];
				asort($icons);
			}
		}

		return $icons;
	}
}


if (!function_exists('kleo_has_shortcode')) {
	function kleo_has_shortcode( $shortcode = '', $post_id = null ) {

		if ( ! $post_id ) {
			if ( ! is_singular() ) {
				return false;
			}
			$post_id = get_the_ID();
		}
		if (is_page() || is_single()) {
			$current_post = get_post( $post_id );
			$post_content  = $current_post->post_content;
			$found         = false;

			if ( ! $shortcode ) {
				return $found;
			}

			if ( stripos( $post_content, '[' . $shortcode ) !== false ) {
				$found = true;
			}

			return $found;
		} else {
			return false;
		}
	}
}


function find_shortcode_template($shortcode) {
	if (file_exists(trailingslashit( get_stylesheet_directory() ) . 'k_elements/' . $shortcode . '.php')) {
		return trailingslashit( get_stylesheet_directory() ) . 'k_elements/' . $shortcode . '.php';
	}
	elseif ( file_exists( trailingslashit( get_template_directory() ) . 'k_elements/' . $shortcode . '.php' ) ) {
		return trailingslashit( get_template_directory() ) . 'k_elements/' . $shortcode . '.php';
	} else {
		return trailingslashit( K_ELEM_PLUGIN_DIR ) . 'shortcodes/templates/' . $shortcode . '.php';
	}
}

function kleo_shortcode_not_found() {
	return "!! Shortcode template not found !!";
}


/* Buddypress */


/* Get User online */
if (!function_exists('kleo_is_user_online')): 
	/**
	 * Check if a Buddypress member is online or not
	 * @global object $wpdb
	 * @param integer $user_id
	 * @param integer $time
	 * @return boolean
	 */
	function kleo_is_user_online($user_id, $time=5)
	{
		global $wpdb;
		$sql = $wpdb->prepare( "
			SELECT u.user_login FROM $wpdb->users u JOIN $wpdb->usermeta um ON um.user_id = u.ID
			WHERE u.ID = %d
			AND um.meta_key = 'last_activity'
			AND DATE_ADD( um.meta_value, INTERVAL %d MINUTE ) >= UTC_TIMESTAMP()", $user_id, $time);
		$user_login = $wpdb->get_var( $sql );
		if(isset($user_login) && $user_login !=""){
			return true;
		}
		else {return false;}
	}
endif;


if (!function_exists('kleo_get_online_status')):
	function kleo_get_online_status($user_id) {
		$output = '';
		if (kleo_is_user_online($user_id)) {
			$output .= '<span class="kleo-online-status high-bg"></span>';
		} else {
			$output .= '<span class="kleo-online-status"></span>';
		}
		return $output;
	}
endif;


/**
 * Render the html to show if a user is online or not
 */
if( !function_exists('kleo_online_status') ) :
	function kleo_online_status($user_id) {
		echo kleo_get_online_status($user_id);
	}
endif;



if (!function_exists('kleo_bp_member_stats')):
	function kleo_bp_member_stats($field=false,$value=false, $online=false)
	{
		global $wpdb;

		if (!$field || !$value) {
			return;
		}

		$where = " WHERE name = '".$field."' AND value = '".esc_sql($value)."'";
		$sql = "SELECT ".$wpdb->base_prefix."bp_xprofile_data.user_id FROM ".$wpdb->base_prefix."bp_xprofile_data 
				JOIN ".$wpdb->base_prefix."bp_xprofile_fields ON ".$wpdb->base_prefix."bp_xprofile_data.field_id = ".$wpdb->base_prefix."bp_xprofile_fields.id 
				$where";

		$match_ids = $wpdb->get_col($sql);
		if ( !$online ) {
			return count($match_ids);
		}

		if ( !$match_ids ) {	
			$match_ids = array(0);
		}

		if( !empty($match_ids) )
		{
			$include_members = '&include='.join(",",$match_ids);
		}
		else
		{
			$include_members = '';
		}

		$i = 0;
		if ( bp_has_members( 'user_id=0&type=online&per_page=999999999&populate_extras=0'.$include_members ) ) :
			while ( bp_members() ) : bp_the_member();
				$i++;
			endwhile;
		endif;

		return apply_filters('kleo_bp_member_stats',$i, $value);
	}
endif;



if (!function_exists('get_profile_id_by_name')) :
	/**
	 * Return profile field ID by profile name
	 * @global object $wpdb
	 * @param string $name
	 * @return integer
	 */
	function get_profile_id_by_name($name)
	{
		global $wpdb;
		if (!isset($name))
				return false;

		$sql = "SELECT id FROM ".$wpdb->base_prefix."bp_xprofile_fields WHERE name = '".$name."'";
		return $wpdb->get_var($sql);
	}
endif;


if(!function_exists('get_group_id_by_name')) :
	function get_group_id_by_name($name)
	{
		global $wpdb;
		if (!isset($name))
				return false;

		$sql = "SELECT id FROM ".$wpdb->base_prefix."bp_xprofile_groups WHERE name = '".$name."'";
		return $wpdb->get_var($sql);
	}
endif;


/*
 * Retrive custom field
 */
if( !function_exists( 'get_cfield' ) ):
	
	function get_cfield($meta = NULL, $id = NULL) {
		if($meta === NULL) {
			return false;
		}

		if ($id === NULL) {
			$id = get_the_ID();
		}

		return get_post_meta( $id, '_kleo_'.$meta, true );
	}
endif;

/*
 * Echo the custom field
 */
if(!function_exists('the_cfield')):
	function the_cfield($meta=NULL, $id=NULL) 
	{
		if($meta === NULL)
				echo '';

		if ($id === NULL)
				$id = get_the_ID();

		echo get_post_meta( $id, '_kleo_'.$meta, true );
	}
endif;