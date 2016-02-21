<?php

defined('ABSPATH') or die('No direct access permitted');

    // add settings link on plugin page
    function ssbl_settings_link($links)
    {
        // add to plugins links
        array_unshift($links, '<a href="admin.php?page=simple-share-buttons-light">Settings</a>');

        // return all links
        return $links;
    }

    // include js files and upload script
    function ssbl_admin_scripts()
    {
        wp_enqueue_media();

        // ready available with wp
        wp_enqueue_script('jquery-ui');
        wp_enqueue_script('jquery-ui-sortable');

        // bootstrap
        wp_register_script('ssblBootstrap', plugins_url('js/admin/ssbl_bootstrap.js', SSBL_FILE));
        wp_enqueue_script('ssblBootstrap');

        // bootstrap switch
        wp_register_script('ssblSwitch', plugins_url('js/admin/ssbl_switch.js', SSBL_FILE));
        wp_enqueue_script('ssblSwitch');

        // bootstrap colorpicker
        wp_register_script('ssblColorPicker', plugins_url('js/admin/ssbl_colorpicker.js', SSBL_FILE));
        wp_enqueue_script('ssblColorPicker');

        // if viewing the styling page
        if ($_GET['page'] == 'simple-share-buttons-styling') {
            // include custom css file
            add_action('admin_head', 'ssbl_style_head');
        }

        // finish with ssbl admin
        wp_register_script('ssbl-js', plugins_url('js/admin/ssbl_admin.js', SSBL_FILE));
        wp_enqueue_script('ssbl-js');
    }

    // include styles for the ssbl admin panel
    function ssbl_admin_styles()
    {
        // admin styles
        wp_register_style('ssbl-colorpicker', plugins_url('css/colorpicker.css', SSBL_FILE));
        wp_enqueue_style('ssbl-colorpicker');
        wp_register_style('ssbl-bootstrap-style', plugins_url('css/readable.css', SSBL_FILE));
        wp_enqueue_style('ssbl-bootstrap-style');
        wp_register_style('ssbl-admin-theme', plugins_url('sharebuttons/assets/css/ssbp-all.css', SSBL_FILE));
        wp_enqueue_style('ssbl-admin-theme');
        wp_register_style('ssbl-switch-styles', plugins_url('css/ssbl_switch.css', SSBL_FILE));
        wp_enqueue_style('ssbl-switch-styles');
        wp_register_style('ssbl-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
        wp_enqueue_style('ssbl-font-awesome');

        // this one last to overwrite any CSS it needs to
        wp_register_style('ssbl-admin-style', plugins_url('css/style.css', SSBL_FILE));
        wp_enqueue_style('ssbl-admin-style');
    }

    // menu settings
    function ssbl_menu()
    {
        // add menu page
        add_options_page( 'Simple Share Buttons Light', 'Share Buttons', 'manage_options', 'simple-share-buttons-light', 'ssbl_settings');
    }
