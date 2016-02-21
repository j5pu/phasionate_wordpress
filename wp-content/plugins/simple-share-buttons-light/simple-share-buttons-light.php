<?php
/*
Plugin Name: Simple Share Buttons Light
Plugin URI: https://simplesharebuttons.com/light/
Description: One of the fastest WordPress share button plugins available.
Version: 0.0.2
Author: Simple Share Buttons
Author URI: https://simplesharebuttons.com
License: GPLv2

Copyright 2015 Simple Share Buttons admin@simplesharebuttons.com

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
      _                    _           _   _
  ___| |__   __ _ _ __ ___| |__  _   _| |_| |_ ___  _ __  ___
 / __| '_ \ / _` | '__/ _ \ '_ \| | | | __| __/ _ \| '_ \/ __|
 \__ \ | | | (_| | | |  __/ |_) | |_| | |_| || (_) | | | \__ \
 |___/_| |_|\__,_|_|  \___|_.__/ \__,_|\__|\__\___/|_| |_|___/

*/

//======================================================================
// 		CONSTANTS
//======================================================================

    // set constants
    define('SSBL_FILE', __FILE__);
    define('SSBL_ROOT', dirname(__FILE__));
    define('SSBL_VERSION', '0.0.2');

//======================================================================
// 		 SSBL SETTINGS
//======================================================================

    // get ssbl settings
    $ssbl_settings = get_ssbl_settings();

//======================================================================
// 		INCLUDES
//======================================================================

    // db includes in case needed
    include_once SSBL_ROOT.'/system/models/ssbl_database.php';

    // frontend side functions
    include_once SSBL_ROOT.'/system/controllers/ssbl_buttons.php';

//======================================================================
// 		ADMIN ONLY
//======================================================================

    // register/deactivate/uninstall
    register_activation_hook(__FILE__, 'ssbl_activate');
    //register_deactivation_hook( __FILE__, 'ssbl_deactivate' );
    register_uninstall_hook(__FILE__, 'ssbl_uninstall');

    // ssbl admin area hook
    add_action('plugins_loaded', 'ssbl_admin_area');

    // ssbl admin area
    function ssbl_admin_area()
    {
        // if in admin area
        if (is_admin()) {
            // can manage plugin options
            if (current_user_can('manage_options')) {
                // include the admin panel
                include_once SSBL_ROOT.'/system/views/ssbl_admin_panel.php';

                // include core admin requirements
                include_once plugin_dir_path(__FILE__).'/system/controllers/ssbl_admin_bits.php';

                // add menu to dashboard
                add_action('admin_menu', 'ssbl_menu');

                // lower than current version
                if (get_option('ssbl_version') < SSBL_VERSION) {
                    // run upgrade script
                    upgrade_ssbl(get_option('ssbl_version'));
                }

                // if viewing an ssbl admin page
                if (isset($_GET['page']) && $_GET['page'] == 'simple-share-buttons-light') {
                    // admin and ssbl admin pages only includes
                    include_once plugin_dir_path(__FILE__).'/system/models/ssbl_admin_save.php';
                    include_once plugin_dir_path(__FILE__).'/system/helpers/ssbl_forms.php';

                    // add the admin styles
                    add_action('admin_print_styles', 'ssbl_admin_styles');

                    // also include js
                    add_action('admin_print_scripts', 'ssbl_admin_scripts');
                }
            }
        }
    }

//======================================================================
// 		ADMIN HOOKS
//======================================================================

    // add filter hook for plugin action links
    add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'ssbl_settings_link');

//======================================================================
// 		SHORTCODES
//======================================================================

    // register shortcode [ssbl]
    add_shortcode('ssbl', 'ssbl_buttons');

//======================================================================
// 		FRONTEND HOOKS
//======================================================================

    // add share buttons to content and/or excerpts
    add_filter('the_content', 'ssbl_show_share_buttons');

    // hook into head to add css
    add_action('wp_head','hook_css');

    // add ssbl css
    function hook_css()
    {
    	$output="<style>.ssbl-wrap .ssbl-container .ssbl-img{width:50px;height:50px;padding:5px;border:0;box-shadow:0;display:inline}.ssbl-wrap .ssbl-container a{border:0}</style>";

    	echo $output;

    }

//======================================================================
// 		GET SSBL SETTINGS
//======================================================================

    // return ssbl settings
    function get_ssbl_settings()
    {
        // get json array settings from DB
        $jsonSettings = get_option('ssbl_settings');

        // decode and return settings
        return json_decode($jsonSettings, true);
    }

//======================================================================
// 		UPDATE SSBL SETTINGS
//======================================================================

    // update an array of options
    function ssbl_update_options($arrOptions)
    {
        // if not given an array
        if (! is_array($arrOptions)) {
            die('Value parsed not an array');
        }

        // get ssbl settings
        $jsonSettings = get_option('ssbl_settings');

        // decode the settings
        $ssbl_settings = json_decode($jsonSettings, true);

        // loop through array given
        foreach ($arrOptions as $name => $value) {
            // update/add the option in the array
            $ssbl_settings[$name] = $value;
        }

        // encode the options ready to save back
        $jsonSettings = json_encode($ssbl_settings);

        // update the option in the db
        update_option('ssbl_settings', $jsonSettings);
    }
