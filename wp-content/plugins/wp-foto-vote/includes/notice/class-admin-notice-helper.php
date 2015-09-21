<?php

/*
Name:        Admin Notice Helper
URI:         https://github.com/iandunn/admin-notice-helper
Version:     0.2
Author:      Ian Dunn
Author URI:  http://iandunn.name
License:     GPLv2
*/

/*  
 * Copyright 2014 Ian Dunn (email : ian@iandunn.name)
 * 
 * Notices are saved in SESSION (in original it saves in database, but i this it not needed)
 */

if (!defined('ABSPATH')) {
        die('Access denied.');
}

if (!class_exists('WSS_Admin_Notice_Helper')) {

        class WSS_Admin_Notice_Helper
        {
                // Declare variables and constants
                protected static $instance;
                protected $notices, $notices_were_updated;

                /**
                 * Constructor
                 */
                protected function __construct()
                {
                        //add_action( 'init',          array( $this, 'init' ), 9 );         // needs to run before other plugin's init callbacks so that they can enqueue messages in their init callbacks
                    if (session_id() == '') {
                        session_start();
                    }
                    add_action( 'admin_notices', array( $this, 'print_notices' ) );
                        add_action( 'fv_admin_notices', array( $this, 'print_notices' ) );
                        add_action( 'shutdown', array($this, 'shutdown') );
                }

                /**
                 * Provides access to a single instances of the class using the singleton pattern
                 *
                 * @mvc    Controller
                 * @author Ian Dunn <ian@iandunn.name>
                 * @return object
                 */
                public static function get_singleton()
                {
                        if (!isset(self::$instance)) {
                                self::$instance = new WSS_Admin_Notice_Helper();

                                if (!isset($_SESSION['user_notices'])) {
                                        $_SESSION['user_notices'] = array();
                                }
                                self::$instance->notices = $_SESSION['user_notices'];

                                self::$instance->notices_were_updated = false;
                        }

                        return self::$instance;
                }

                /**
                 * Initializes variables
                 */
                public function init()
                {
                        //$default_notices             = array( 'default' => array(), 'error' => array() );
                }

                /**
                 * Queues up a message to be displayed to the user
                 *
                 * @param string $message The text to show the user
                 * @param string $type 'update' for a success or notification message, or 'error' for an error message
                 */
                public function enqueue($message, $type = 'default')
                {
                        /*
                        if ( isset( $this->notices[ $type ] ) &&  in_array( $message, array_values( $this->notices[ $type ] ) ) ) {
                            return;
                        }
                        */

                        $this->notices[$type][] = (string)apply_filters('anh_enqueue_message', $message);
                        $this->notices_were_updated = true;
                }

                /**
                 * Displays updates and errors
                 */
                public function print_notices()
                {

                        foreach (array('default', 'info', 'danger', 'success', 'primary', 'warning') as $type) {
                                if (isset($this->notices[$type]) && count($this->notices[$type])) {

                                        require('views/admin-notice.php');

                                        $this->notices[$type] = array();
                                        $this->notices_were_updated = true;
                                }
                        }
                }

                /**
                 * Writes notices to the database
                 */
                public function shutdown()
                {

                        //var_dump( $this->notices_were_updated );
                        if ($this->notices_were_updated) {
                                $_SESSION['user_notices'] = $this->notices;
                                //update_option( 'anh_notices', $this->notices );
                        }
                }
        } // end Admin_Notice_Helper

        WSS_Admin_Notice_Helper::get_singleton(); // Create the instance immediately to make sure hook callbacks are registered in time

        if (!function_exists('wp_add_notice')) {
                function wp_add_notice($message, $type = 'default')
                {
                        WSS_Admin_Notice_Helper::get_singleton()->enqueue($message, $type);
                }
        }
}