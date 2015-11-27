<?php

if ( !isset($_REQUEST['action']) ) {
    die(0);
}
if ( $_REQUEST['action'] !== 'vote' && $_REQUEST['action'] !== 'fv_is_subscribed' ) {
    die(00);
}


//make sure we skip most of the loading which we might not need
//http://core.trac.wordpress.org/browser/branches/3.4/wp-settings.php#L99
define('SHORTINIT', true);

//mimic the actuall admin-ajax
define('DOING_AJAX', true);

// This include gives us all the WordPress functionality
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/
//Typical headers
header('Content-Type: text/html');
send_nosniff_header();

//Disable caching
header('Cache-Control: no-cache');
header('Pragma: no-cache');

//Include only the files and function we need
require( ABSPATH . WPINC . '/formatting.php' );
require( ABSPATH . WPINC . '/capabilities.php' );
//require( ABSPATH . WPINC . '/query.php' );
//require( ABSPATH . WPINC . '/date.php' );
require( ABSPATH . WPINC . '/user.php' );
require( ABSPATH . WPINC . '/session.php' );
require( ABSPATH . WPINC . '/meta.php' );
require( ABSPATH . WPINC . '/general-template.php' );
require( ABSPATH . WPINC . '/link-template.php' );
//require( ABSPATH . WPINC . '/post.php' );
require( ABSPATH . WPINC . '/kses.php' );
require( ABSPATH . WPINC . '/http.php' );
require( ABSPATH . WPINC . '/class-http.php' );

require( ABSPATH . WPINC . '/l10n.php' );

// Define constants
wp_plugin_directory_constants();
wp_cookie_constants();

require( ABSPATH . WPINC . '/pluggable.php' );

wp_register_plugin_realpath( WP_PLUGIN_DIR . '/wp-foto-vote/wp-foto-vote.php' );

//and do your stuff
require( 'wp-foto-vote.php' );

if ( !FvFunctions::ss('fast-ajax', true) ) {
    die('hehe');
}

if ( $_REQUEST['action'] == 'vote' ) {
    do_action('wp_ajax_nopriv_vote');
} elseif( $_REQUEST['action'] == 'fv_is_subscribed' ) {
    do_action('wp_ajax_nopriv_fv_is_subscribed');
}

