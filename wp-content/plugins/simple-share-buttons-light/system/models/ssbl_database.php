<?php

defined('ABSPATH') or die('No direct access permitted');

    // activate ssbl function
    function ssbl_activate()
    {
        // likely a reactivation, return doing nothing
        if (get_option('ssbl_version') !== false) {
            return;
        }

        // array ready with defaults
        $ssbl_settings = array(
            'pages'             => '',
            'posts'             => '',
            'image_set'         => 'circle',
            'share_text'        => '',
            'selected_buttons'  => 'facebook,google,twitter,linkedin',
        );

        // json encode
        $jsonSettings = json_encode($ssbl_settings);

        // insert default options for ssbl
        add_option('ssbl_settings', $jsonSettings);

        // save settings to json file
        ssbl_update_options($ssbl_settings);

        // button helper array
        ssbl_button_helper_array();

        // add ssbl version as a separate option
        add_option('ssbl_version', SSBL_VERSION);
    }

    // uninstall ssbl function
    function ssbl_uninstall()
    {
        //if uninstall not called from WordPress exit
        if (defined('WP_UNINSTALL_PLUGIN')) {
            exit();
        }

        // delete ssbl options
        delete_option('ssbl_version');
        delete_option('ssbl_settings');
        delete_option('ssbl_buttons');
    }

    // the upgrade function
    function upgrade_ssbl($ssblVersion)
    {
        // initial installation, do not proceed with upgrade script
        if ($ssblVersion === false) {
            return;
        }

// planning ahead
/*
        // lower than 0.0.2
        if ($ssblVersion < '0.0.2') {
            // added in 0.0.2
            $new = array(
                '' => '',
            );
        }

        // save the new options
        ssbl_update_options($new);

        // button helper array
        ssbl_button_helper_array();

        // set new version number
        update_option('ssbl_version', SSBL_VERSION);
*/
    }

    // button helper option
    function ssbl_button_helper_array()
    {
        // helper array for ssbl
        update_option('ssbl_buttons', json_encode(array(
            'buffer' => array(
                'full_name'    => 'Buffer',
            ),
            'diggit' => array(
                'full_name'    => 'Diggit',
            ),
            'email' => array(
                'full_name'    => 'Email',
            ),
            'facebook' => array(
                'full_name'    => 'Facebook',
            ),
            'google' => array(
                'full_name'    => 'Google+',
            ),
            'linkedin' => array(
                'full_name'    => 'LinkedIn',
            ),
            'pinterest' => array(
                'full_name'    => 'Pinterest',
            ),
            'print' => array(
                'full_name'    => 'Print',
            ),
            'reddit' => array(
                'full_name'    => 'Reddit',
            ),
            'stumbleupon' => array(
                'full_name'    => 'StumbleUpon',
            ),
            'tumblr' => array(
                'full_name'    => 'Tumblr',
            ),
            'twitter' => array(
                'full_name'    => 'Twitter',
            ),
            'vk' => array(
                'full_name'    => 'VK',
            ),
            'yummly' => array(
                'full_name'    => 'Yummly',
            ),
        )));
    }
