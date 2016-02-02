<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2015 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
 Name:      ajdg_grpwidgets
 Purpose:   Group adverts
 Since:		3.19
-------------------------------------------------------------*/
class ajdg_grpwidgets extends WP_Widget {

	/*-------------------------------------------------------------
	 Purpose:   Construct the widget
	-------------------------------------------------------------*/
	function ajdg_grpwidgets() {

        parent::__construct(false, 'AdRotate Group', array('description' => "Show a group of adverts in any widget area."));	

	}

	/*-------------------------------------------------------------
	 Purpose:   Display the widget
	-------------------------------------------------------------*/
	function widget($args, $instance) {
		global $adrotate_config, $post, $blog_id;

		extract($args);
		if(empty($instance['groupid'])) $instance['groupid'] = 0;
		if(empty($instance['siteid'])) $instance['siteid'] = $blog_id;
		if(empty($instance['title'])) $instance['title'] = '';
		if(empty($instance['categories'])) $instance['categories'] = '';
		if(empty($instance['pages'])) $instance['pages'] = '';

		// Determine post injection
		if($instance['categories'] != '' OR $instance['pages'] != '') {
			$show = false;
			
			$categories = explode(",", $instance['categories']);
			$pages = explode(",", $instance['pages']);

			if(is_page($pages) OR is_category($categories) OR in_category($categories)) {
				$show = true;
			}
		} else {
			$show = true;
		}
		
		if($show) {
			echo $before_widget;

			$title = apply_filters('widget_title', $instance['title']);
			if($title) {
				echo $before_title . $title . $after_title;
			}
			
			if($adrotate_config['widgetalign'] == 'Y') echo '<ul><li>';

			if($adrotate_config['w3caching'] == 'Y') {
				echo '<!-- mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
				echo 'echo adrotate_group('.$instance['groupid'].', 0, 0, '.$instance['siteid'].');';
				echo '<!-- /mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
			} else {
				echo adrotate_group($instance['groupid'], 0, 0, $instance['siteid']);
			}
					
			if($adrotate_config['widgetalign'] == 'Y') echo '</li></ul>';
			
			echo $after_widget;
		}
	}

	/*-------------------------------------------------------------
	 Purpose:   Save the widget options per instance
	-------------------------------------------------------------*/
	function update($new_instance, $old_instance) {
		global $wpdb;

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['groupid'] = strip_tags($new_instance['groupid']);
		$new_instance['siteid'] = strip_tags($new_instance['siteid']);
		

		$group = $wpdb->get_row("SELECT `cat`, `cat_loc`, `page`, `page_loc` FROM `{$wpdb->prefix}adrotate_groups` WHERE `id` = {$new_instance['groupid']};");

		// Post injection
		$new_instance['categories'] = ($group->cat_loc == 5) ? $group->cat : '';
		
		// Page injection
		$new_instance['pages'] = ($group->page_loc == 5) ? $group->page : '';

		$instance = wp_parse_args($new_instance, $old_instance);

		return $instance;
	}

	/*-------------------------------------------------------------
	 Purpose:   Display the widget options for admins
	-------------------------------------------------------------*/
	function form($instance) {
		global $wpdb, $blog_id;

		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		$license = get_option('adrotate_activate');
		
		$title = $groupid = $siteid = $categories = $pages = '';
		extract($instance);
		$title = esc_attr($title);
		$groupid = esc_attr($groupid);
		$siteid = esc_attr($siteid);
		$categories = esc_attr($categories);
		$pages = esc_attr($pages);
		
		$groups	= $wpdb->get_results("SELECT `id`, `name` FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '' ORDER BY `id` ASC;"); 

?>
		<?php if($categories != '' OR $pages != '') { ?>
		<p><?php _e('NOTE: This widget has Post Injection enabled!', 'adrotate-pro'); ?></p>
		<?php } ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'adrotate-pro'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			<br />
			<small><?php _e('HTML will be stripped out.', 'adrotate-pro'); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('groupid'); ?>"><?php _e('Group:', 'adrotate-pro'); ?></label><br />
			<select id="<?php echo $this->get_field_id('groupid'); ?>" name="<?php echo $this->get_field_name('groupid'); ?>">
		        <option value="0"><?php _e('--', 'adrotate-pro'); ?></option>
			<?php if($groups) { ?>
				<?php foreach($groups as $group) { ?>
			        <option value="<?php echo $group->id;?>" <?php if($groupid == $group->id) { echo 'selected'; } ?>><?php echo $group->id;?> - <?php echo $group->name;?></option>
	 			<?php } ?>
			<?php } ?>
			</select>
		</p>

		<?php if(adrotate_is_networked() AND ($license['l'] != 'Network' OR $license['l'] != 'Developer')) { ?>
		<p>
			<label for="<?php echo $this->get_field_id('siteid'); ?>"><?php _e('Site ID:', 'adrotate-pro'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('siteid'); ?>" name="<?php echo $this->get_field_name('siteid'); ?>" type="text" value="<?php echo $siteid; ?>" />
			<br />
			<small><?php _e(sprintf('The site ID from a site in the network! Leave empty or %s to use current site.', $blog_id), 'adrotate-pro'); ?></small>
		</p>
		<?php } else { ?>
		<input id="<?php echo $this->get_field_id('siteid'); ?>" name="<?php echo $this->get_field_name('siteid'); ?>" type="hidden" value="0" />
		<?php } ?>
<?php
	}

}
?>