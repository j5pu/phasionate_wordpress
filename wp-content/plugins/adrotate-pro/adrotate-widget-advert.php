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
 Name:      ajdg_grp_widgets
 Purpose:   Group adverts
 Since:		3.19
-------------------------------------------------------------*/
class ajdg_bnnrwidgets extends WP_Widget {

	/*-------------------------------------------------------------
	 Purpose:   Construct the widget
	-------------------------------------------------------------*/
	function ajdg_bnnrwidgets() {

        parent::__construct(false, 'AdRotate Advert', array('description' => "Show a single advert in any widget area."));	

	}

	/*-------------------------------------------------------------
	 Purpose:   Display the widget
	-------------------------------------------------------------*/
	function widget($args, $instance) {
		global $adrotate_config, $blog_id;

		extract($args);
		if(empty($instance['type'])) $instance['type'] = 'group';
		if(empty($instance['adid'])) $instance['adid'] = 0;
		if(empty($instance['siteid'])) $instance['siteid'] = $blog_id;
		if(empty($instance['title'])) $instance['title'] = '';

        $title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;
		if($title) {
			echo $before_title . $title . $after_title;
		}
		
		if($adrotate_config['widgetalign'] == 'Y') echo '<ul><li>';

		if($adrotate_config['w3caching'] == 'Y') {
			echo '<!-- mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
			echo 'echo adrotate_ad('.$instance['adid'].', true, 0, 0, '.$instance['siteid'].');';
			echo '<!-- /mfunc '.W3TC_DYNAMIC_SECURITY.' -->';
		} else {
			echo adrotate_ad($instance['adid'], true, 0, 0, $instance['siteid']);
		}
		
		if($adrotate_config['widgetalign'] == 'Y') echo '</li></ul>';
		
		echo $after_widget;

	}

	/*-------------------------------------------------------------
	 Purpose:   Save the widget options per instance
	-------------------------------------------------------------*/
	function update($new_instance, $old_instance) {
		global $wpdb;

		$new_instance['title'] = strip_tags($new_instance['title']);
		$new_instance['adid'] = strip_tags($new_instance['adid']);
		$new_instance['siteid'] = strip_tags($new_instance['siteid']);

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
		
		$title = $adid = $siteid = '';
		extract($instance);
		$title = esc_attr( $title );
		$adid = esc_attr( $adid );
		$siteid = esc_attr( $siteid );
		
		$ads = $wpdb->get_results("SELECT `id`, `title` FROM `{$wpdb->prefix}adrotate` WHERE (`type` = 'active' OR `type` = '2days' OR `type` = '7days') ORDER BY `id` ASC;");

?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'adrotate-pro'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			<br />
			<small><?php _e('HTML will be stripped out.', 'adrotate-pro'); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('adid'); ?>"><?php _e('Advert:', 'adrotate-pro'); ?></label><br />
			<select id="<?php echo $this->get_field_id('adid'); ?>" name="<?php echo $this->get_field_name('adid'); ?>">
		        <option value="0"><?php _e('--', 'adrotate-pro'); ?></option>
			<?php if($ads) { ?>
				<?php foreach($ads as $ad) { ?>
			        <option value="<?php echo $ad->id;?>" <?php if($adid == $ad->id) { echo 'selected'; } ?>><?php echo $ad->id;?> - <?php echo $ad->title;?></option>
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