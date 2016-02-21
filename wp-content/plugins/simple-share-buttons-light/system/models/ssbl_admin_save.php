<?php
defined('ABSPATH') or die('No direct access permitted');

    // main dashboard
    function ssbl_dashboard()
    {
        // check if user has the rights to manage options
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        // --------- ADMIN DASHBOARD ------------ //
        ssbl_admin_dashboard();
    }

    // main settings
    function ssbl_settings()
    {
        // check if user has the rights to manage options
        if (! current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        // if a post has been made
        if (isset($_POST['ssblData'])) {
            // get posted data
            $ssblPost = $_POST['ssblData'];
            parse_str($ssblPost, $ssblPost);

            // if the nonce doesn't check out...
            if (!isset($ssblPost['ssbl_save_nonce']) || !wp_verify_nonce($ssblPost['ssbl_save_nonce'], 'ssbl_save_settings')) {
                die('There was no nonce provided, or the one provided did not verify.');
            }

            // prepare array to save
            $arrOptions = array(
                        'pages'             => (isset($ssblPost['pages'])               ? stripslashes_deep($ssblPost['pages']) : null),
                        'posts'             => (isset($ssblPost['posts'])               ? stripslashes_deep($ssblPost['posts']) : null),
                        'share_text'        => (isset($ssblPost['share_text'])          ? stripslashes_deep($ssblPost['share_text']) : null),
                        'image_set'         => (isset($ssblPost['image_set'])           ? stripslashes_deep($ssblPost['image_set']) : null),
                        'selected_buttons'  => (isset($ssblPost['selected_buttons'])    ? stripslashes_deep($ssblPost['selected_buttons']) : null),
                    );

            // save the settings
            ssbl_update_options($arrOptions);

            return true;
        }

        // include required admin view
        include_once SSBL_ROOT.'/system/views/ssbl_admin_panel.php';

        // get ssbl settings
        $ssbl_settings = get_ssbl_settings();

        // --------- ADMIN PANEL ------------ //
        ssbl_admin_panel($ssbl_settings);
    }
