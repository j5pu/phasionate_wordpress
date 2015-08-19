<?php 
/*
Plugin Name: WP Missed Schedule
Plugin URI: //slangji.wordpress.com/wp-missed-schedule/
Description: WordPress plugin WP <code>Missed Schedule</code> Fix <code>Scheduled</code> <code>Failed Future Posts</code> <code>Virtual Cron Job</code>: find only items that match this problem, and republish them correctly 10 items each session, every 10 minutes. All others will be solved on next sessions, to no waste resources, until no longer exist: 10 items every 10 minutes, 60 items every hour, 1 session every 10 minutes, 6 sessions every hour - Free (UNIX STYLE) Stable Branche 2014 - Version 2014.1231 - Revision 1 - Build 2015-08-18 - <a title="Try New Stable Beta Version Branche 2015" href="//slangji.wordpress.com/wp-missed-schedule-beta/">Beta Branche 2015</a> - Cron link requires plugin WP Crontrol activated and WordPress 2.7+ or later
Version: 2014.1231.1
Requires at least: 2.1
KeyTag: 7f71ee70ea1ce6795c69c81df4ea13ac5cf230b4
Author: sLa NGjI's
Author URI: //slangji.wordpress.com/
Network: true
Text Domain: wpmissedscheduled
Domain Path: /languages/
License: GPLv2 or later
License URI: //www.gnu.org/licenses/gpl-2.0.html
Indentation: GNU style coding standard
Indentation URI: //www.gnu.org/prep/standards/standards.html
Humans: We are the humans behind
Humans URI: //humanstxt.org/Standard.html
 *
 * ALPHA DEVELOPMENT Release is available only on [GitHub](//github.com/slangji)
 *
 * BETA Release: Version 2015 Build 0228 Revision 3
 *
 * REQUIREMENTS
 *
 * To run this plugin on your WordPress host just needs a couple of things:
 *
 *   PHP version 5.2+ or greater (recommended:   PHP 5.3+ or greater)
 * MySQL version 5.0+ or greater (recommended: MySQL 5.5+ or greater)
 *
 * We recommend Apache or Nginx as the most robust and featureful server for running WordPress,
 * but any server that supports PHP and MySQL will do.
 *
 * Work also with PHP 4+ and MySQL 4+ or greater (depending of your hosting features and WordPress version installed)
 *
 * LICENSING (license.txt)
 *
 * [WP Missed Schedule](//wordpress.org/plugins/wp-missed-schedule/)
 *
 * Fix Scheduled Failed Future Posts
 *
 * This plugin patched an important big problem unfixed since WordPress 2.5+ to date.
 *
 * Copyright (C) 2007-2015 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlegmail [dot] com>))
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the [GNU General Public License](//wordpress.org/about/gpl/)
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * on an "AS IS", but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see [GNU General Public Licenses](//www.gnu.org/licenses/),
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * DISCLAIMER
 *
 * This program is distributed "AS IS" in the hope that it will be useful, but:
 * without any warranty of function, without any warranty of merchantability,
 * without any fitness for a particular or specific purpose, without any type
 * of future assistance from your own author or other authors.
 *
 * The license under which the WordPress software is released is the GPLv2 (or later) from the
 * Free Software Foundation. A copy of the license is included with every copy of WordPress.
 *
 * Part of this license outlines requirements for derivative works, such as plugins or themes.
 * Derivatives of WordPress code inherit the GPL license.
 *
 * There is some legal grey area regarding what is considered a derivative work, but we feel
 * strongly that plugins and themes are derivative work and thus inherit the GPL license.
 *
 * The license for this software can be found on [Free Software Foundation](//www.gnu.org/licenses/gpl-2.0.html)
 * and as license.txt into this plugin package.
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * THERMS
 *
 * This uses (or it parts) code derived from:
 *
 * wp-header-footer-login-log.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2009 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * according to the terms of the GNU General Public License version 2 (or later)
 *
 * This wp-header-footer-login-log.php uses (or it parts) code derived from
 *
 * wp-header-log.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2008 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-footer-log.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2007 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * according to the terms of the GNU General Public License version 2 (or later)
 *
 * According to the Terms of the GNU General Public License version 2 (or later) part of Copyright belongs to your own author
 * and part belongs to their respective others authors:
 *
 * Copyright (C) 2007-2009 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * VIOLATIONS
 *
 * [Violations of the GNU Licenses](//www.gnu.org/licenses/gpl-violation.en.html)
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * GUIDELINES
 *
 * This software meet [Detailed Plugin Guidelines](//wordpress.org/plugins/about/guidelines/)
 * paragraphs 1,4,10,12,13,16,17 quality requirements.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * CODING
 *
 * This software implement [GNU style](//www.gnu.org/prep/standards/standards.html) coding standard indentation.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * VALIDATION
 *
 * This readme.txt rocks. Seriously. Flying colors. It meet the specifications according to
 * WordPress [Readme Validator](//wordpress.org/plugins/about/validator/) directives.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * HUMANS (humans.txt)
 *
 * We are the Humans behind this project [humanstxt.org](//humanstxt.org/Standard.html)
 *
 * This software meet detailed humans rights belongs to your own author and to their respective other authors.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * THANKS
 *
 * [nicokaiser](//wordpress.org/support/topic/plugin-uses-post_date_gmt-which-is-not-indexed)
 * Jack Hayhurst <jhayhurst [at] liquidweb [dot] com> MySQL Queries with Server Load Optimization and Index Suggestion.
 * [Arkadiusz Rzadkowolski](//profiles.wordpress.org/fliespl/) HyperDB table_name from query broken in select query.
 * [milewis1](//profiles.wordpress.org/milewis1/) WordPress blog's timezone implementation instead of the MySQL time.
 *
 * CHANGELOG
 *
 * [to-do list and changelog](//wordpress.org/plugins/wp-missed-schedule/changelog/)
 *
 * TODOLIST
 *
 * Extend Cron Action Link to Legacy WordPress Builds.
 * On fact plugin WP Crontrol is limited with older versions prior 2.7+
 * Add support for my fork plugin WP Cron Control Lite that work with all releases.
 *
 * NOTES
 *
 * [Missed Schedule Cron Info](//trinity777.wordpress.com/2008/10/28/wordpress-26-the-issue-of-wp-cronphp/)
 * [Timezone Correct Settings](//php.net/manual/it/function.time.php) only for WordPress 2.9+ or later
 * [Current Time Function Reference](//codex.wordpress.org/Function_Reference/current_time)
 */

	/**
	 * @package WP Missed Schedule
	 * @subpackage WordPress PlugIn
	 * @description Fix Scheduled Missed Schedule Failed Future Posts Virtual Cron Job Items
	 * @noted  This plugin patched an important big problem unfixed since WordPress 2.5+ to date
	 * @install The configuration of this Plugin is Automatic
	 * @requirements Not need other actions except activate deactivate or delete it
	 * @started  Project Started on 2007 unofficial 2006
	 * @author   slangjis
	 * @status   STABLE (tags) release
	 * @requires 2.1+
	 * @since    2.5+
	 * @tested   2.6+
	 * @branche  2014
	 * @build    2015-08-18
	 * @version  2014.1231.1
	 * @license  GPLv2 or later
	 * @indentation GNU style coding standard
	 * @satisfaction 04 Jan 2014 3:57 100.000 Downloads
	 * @satisfaction 26 Jan 2015 8:23 150.000 Downloads
	 * @satisfaction 26 Feb 2015 9:00 160.000 Downloads
	 * @satisfaction 01 Mar 2015 8:33 170.000 Downloads
	 * @satisfaction 01 May 2015 9:33 180.000 Downloads
	 * @satisfaction 01 Jul 2015 9:33 190.000 Downloads
	 * @satisfaction 28 Feb 2015 0:00 60.000+ Active Installs
	 * @keybit eLCQM540z78BbFMtmFXj3lC62b79H8651411574J4YQCb3g46FsK338kT29FPANa8
	 * @keysum FBE04369B6316C2D32562B10398C60D7461AEC7B
	 * @keytag 7f71ee70ea1ce6795c69c81df4ea13ac5cf230b4
	 */

	defined( 'ABSPATH' ) or exit;

	defined( 'WPINC' ) or exit;

	if ( !function_exists( 'add_action' ) )
		{
			header( 'HTTP/0.9 403 Forbidden' );
			header( 'HTTP/1.0 403 Forbidden' );
			header( 'HTTP/1.1 403 Forbidden' );
			header( 'Status: 403 Forbidden' );
			header( 'Connection: Close' );
				exit();
		}

	global $wp_version;

	if ( $wp_version < 2.1 )
		{
			wp_die( __( 'This Plugin Requires WordPress 2.1+ or Greater: Activation Stopped.', 'wpmissedscheduled' ) );
		}

	function wpms_1st()
		{
			if ( !current_user_can( 'activate_plugins' ) )
				return;

			$wp_path_to_this_file = preg_replace( '/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . "/$2", __FILE__ );
			$this_plugin          = plugin_basename( trim( $wp_path_to_this_file ) );
			$active_plugins       = get_option( 'active_plugins' );
			$this_plugin_key      = array_search( $this_plugin, $active_plugins );

			if ( $this_plugin_key )
				{
					array_splice( $active_plugins, $this_plugin_key, 1 );
					array_unshift( $active_plugins, $this_plugin );
					update_option( 'active_plugins', $active_plugins );
				}
		}
	add_action( 'activated_plugin', 'wpms_1st', 0 );

	function wpms_activation()
		{
			if ( !current_user_can( 'activate_plugins' ) )
				return;

			delete_option( 'byrev_fixshedule_next_verify' );
			delete_option( 'missed_schedule' );
			delete_option( 'scheduled_post_guardian_next_run' );
			delete_option( 'simpul_missed_schedule' );
			delete_option( 'wpt_scheduled_check' );

			delete_option( 'wp_missed_schedule' );
			delete_option( 'wp_missed_schedule_beta' );
			delete_option( 'wp_missed_schedule_dev' );
			delete_option( 'wp_missed_schedule_pro' );

			delete_option( 'wp_scheduled_missed' );
			delete_option( 'wp_scheduled_missed_beta' );
			delete_option( 'wp_scheduled_missed_dev' );
			delete_option( 'wp_scheduled_missed_pro' );

			global $wp_version;

			if ( $wp_version >= 2.8 )
				{
					delete_transient( 'wp_scheduled_missed' );
					delete_transient( 'timeout_wp_scheduled_missed' );
				}

			wp_clear_scheduled_hook( 'missed_schedule_cron' );

			wp_clear_scheduled_hook( 'wp_missed_schedule' );
			wp_clear_scheduled_hook( 'wp_scheduled_missed' );
		}
	register_activation_hook( __FILE__, 'wpms_activation', 0 );

	define( 'WPMS_OPTION', 'wp_scheduled_missed' );

	function wpms_init()
		{
			global $wp_version;

			if ( $wp_version < 2.8 )
				{
					$wp_scheduled_missed = get_option( WPMS_OPTION, false );

					if ( ( $wp_scheduled_missed !== false ) && ( $wp_scheduled_missed > ( time() - ( 600 ) ) ) )
						return;
				}

			if ( $wp_version >= 2.8 )
				{
					$wp_scheduled_missed = get_option( WPMS_OPTION, false );

					get_transient( 'wp_scheduled_missed', $wp_scheduled_missed, 600 );

					if ( ( $wp_scheduled_missed !== false ) && ( $wp_scheduled_missed > ( time() - ( 600 ) ) ) )
						return;

					set_transient( 'wp_scheduled_missed', $wp_scheduled_missed, 600 );
				}

			update_option( WPMS_OPTION, time() );

			if ( $wp_version >= 2.3 )
				{
					global $wpdb;

			$qry = <<<SQL
 SELECT ID FROM {$wpdb->posts} WHERE ( ( post_date > 0 && post_date <= %s ) ) AND post_status = 'future' LIMIT 0,10 
SQL;

					$sql = $wpdb->prepare( $qry, current_time( 'mysql', 0 ) );

					$scheduledIDs = $wpdb->get_col( $sql );
				}

			if ( $wp_version < 2.3 )
				{
					global $wpdb;

					$scheduledIDs = $wpdb->get_col( "SELECT`ID`FROM`{$wpdb->posts}`" . "WHERE(" . "((`post_date`>0)&&(`post_date`<=CURRENT_TIMESTAMP()))OR" . "((`post_date_gmt`>0)&&(`post_date_gmt`<=UTC_TIMESTAMP()))" . ")AND`post_status`='future'LIMIT 0,10" );
				}

			if ( !count( $scheduledIDs ) )
				return;

			foreach ( $scheduledIDs as $scheduledID )
				{
					if ( !$scheduledID )
						continue;

					wp_publish_post( $scheduledID );
				}
		}
	add_action( 'init', 'wpms_init', 0 );

	if ( $wp_version < 2.8 )
		{
			function wpms_asal( $links, $file )
				{
					if ( $file == plugin_basename( __FILE__ ) )
						{
							global $wp_version;

							if ( ( $wp_version >= 2.7 ) and ( $wp_version < 2.8 ) )
								{
									$wpms_settings_action_links_1 = "<a title='View Your Missed Scheduled Failed Future Posts' href='edit.php?post_status=future&post_type=post'>Missed</a>";
									$wpms_settings_action_links_2 = "<a title='Requires WP Crontrol Plugin Activated' href='tools.php?page=crontrol_admin_manage_page'>Cron</a>";
								}

							if ( ( $wp_version >= 2.7 ) and ( $wp_version < 2.8 ) )
								{
									array_unshift( $links, $wpms_settings_action_links_1 );
									array_unshift( $links, $wpms_settings_action_links_2 );
								}

							if ( ( $wp_version >= 2.5 ) and ( $wp_version < 2.7 ) )
								{
									$wpms_settings_action_links_1 = "<a title='View Your Missed Scheduled Failed Future Posts' href='edit.php?post_status=future&post_type=post'>Missed</a>";
								}

							if ( ( $wp_version >= 2.5 ) and ( $wp_version < 2.7 ) )
								{
									array_unshift( $links, $wpms_settings_action_links_1 );
								}
						}
					return $links;
				}
			add_filter( 'plugin_action_links', 'wpms_asal', null, 2 );
		}

	if ( $wp_version >= 2.8 )
		{
			function wpms_pral( $links )
				{
					$links[] = "<a title='Requires WP Crontrol Plugin Activated' href='tools.php?page=crontrol_admin_manage_page'>Cron</a>";
					$links[] = "<a title='View Your Missed Scheduled Failed Future Posts' href='edit.php?post_status=future&post_type=post'>Missed</a>";
						return $links;
				}
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wpms_pral', 10, 1 );
		}

	if ( $wp_version >= 2.8 )
		{
			function wpms_prml( $links, $file )
				{
					if ( $file == plugin_basename( __FILE__ ) )
						{
							$links[] = '<a title="Offer a Beer to sLa" href="//slangji.wordpress.com/donate/">Donate</a>';
							$links[] = '<a title="Bugfix and Suggestions" href="//slangji.wordpress.com/contact/">Contact</a>';

							global $wp_version;

							if ( ( $wp_version >= 2.8 ) and ( $wp_version < 3.8 ) )
								{
									$links[] = '<a title="Visit other author plugins" href="//slangji.wordpress.com/plugins/">Other Author Plugins</a>';
								}

							if ( $wp_version >= 3.8 )
								{
									$links[] = '<a title="Visit other author plugins" href="//slangji.wordpress.com/plugins/">Other</a>';
								}

							$links[] = '<a title="Try New Stable Beta Version Branche 2015" href="//slangji.wordpress.com/wp-missed-schedule-beta/">Beta</a>';
						}
					return $links;
				}
			add_filter( 'plugin_row_meta', 'wpms_prml', 10, 2 );
		}

	function wpms_shfl()
		{
			if ( !is_home() && !is_front_page() )
				return;
			{
				echo "\r\n<!--Plugin WP Missed Schedule Active - Secured with Genuine Authenticity KeyTag-->\r\n";
				echo "\r\n<!-- This site is patched against a big problem not solved since WordPress 2.5 -->\r\n\r\n";
			}
		}
	add_action( 'wp_head', 'wpms_shfl', 0 );
	add_action( 'wp_footer', 'wpms_shfl', 0 );

	function wpms_shfl_authag()
		{
			if ( !current_user_can( 'administrator' ) )
				return;
			{
				echo "\r\n<!--Secured AuthTag - ".sha1(sha1("eLCQM540z78BbFMtmFXj3lC62b79H8651411574J4YQCb3g46FsK338kT29FPANa8"."FBE04369B6316C2D32562B10398C60D7461AEC7B"))."-->\r\n";
				echo "\r\n<!--Verified KeyTag - 7f71ee70ea1ce6795c69c81df4ea13ac5cf230b4-->\r\n";
				echo "\r\n<!-- Your copy of Plugin WP Missed Schedule (free) is Genuine -->\r\n";
			}
		}
	add_action( 'admin_head', 'wpms_shfl_authag', 0 );
	add_action( 'admin_footer', 'wpms_shfl_authag', 0 );

	function wpms_clnp()
		{
			if ( !current_user_can( 'activate_plugins' ) )
				return;

			delete_option( 'byrev_fixshedule_next_verify' );
			delete_option( 'missed_schedule' );
			delete_option( 'scheduled_post_guardian_next_run' );
			delete_option( 'simpul_missed_schedule' );
			delete_option( 'wpt_scheduled_check' );

			delete_option( 'wp_missed_schedule' );
			delete_option( 'wp_missed_schedule_beta' );
			delete_option( 'wp_missed_schedule_dev' );
			delete_option( 'wp_missed_schedule_pro' );

			delete_option( 'wp_scheduled_missed' );
			delete_option( 'wp_scheduled_missed_beta' );
			delete_option( 'wp_scheduled_missed_dev' );
			delete_option( 'wp_scheduled_missed_pro' );

			global $wp_version;

			if ( $wp_version >= 2.8 )
				{
					delete_transient( 'wp_scheduled_missed' );
					delete_transient( 'timeout_wp_scheduled_missed' );
				}

			wp_clear_scheduled_hook( 'missed_schedule_cron' );

			wp_clear_scheduled_hook( 'wp_missed_schedule' );
			wp_clear_scheduled_hook( 'wp_scheduled_missed' );
		}
	register_deactivation_hook( __FILE__, 'wpms_clnp', 0 );
?>