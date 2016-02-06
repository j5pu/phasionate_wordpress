<?php
/**
 * Disable Plugins
 * 
 * One of WordPress' biggest bottlenecks is that it loads every single plugin 
 * that is active on your WordPress installation on every single post/page no
 * matter whether they are needed for that post/page or not. This plugin will
 * allow you to create simple rewrite rules to exclude a plugin or plugins from
 * any URI pattern match. This is a great way to reduce the memory footprint,
 * SQL queries run at page load, load times, and improve site response speed.
 * 
 * Create a /wp-content/mu-plugins/disable-plugins-rules directory if the plugin
 * has not created one for you already. Create a rules file for each site your
 * WordPress installation is running, naming the file after the host name for
 * the site followed by a .rules extension. For example mywordpresssite.com.rules
 * would be a rules set for mywordpresssite.com.
 * 
 * Populate your rules using regular expression pattern matches and plugin base
 * names on each line of your rules file. For example, to exclude the "Hello Dolly"
 * and "Akisment" plugins from being loaded on your home page, you would write 
 * a rules file that looks like:
 * 
 * # Prevent the Hello Dolly plugin from loading on the home page
 * ^\/$ hello
 * # Prevent the Akisment plugin from loading on the home page
 * ^\/$ akismet
 * 
 * You will need to write a rule for each plugin that will be excluded for each
 * pattern that you wish to exclude that plugin from. C style comments are 
 * allowed in your rules file to document your rules.
 */
/*
Plugin Name: Disable Plugins
Plugin URI: http://www.hellobar.com/
Description: Manage which plugins load on what page with simple regular expression pattern matches similar to an Apache .htaccess file
Version: 1.0.0
Author: digital-telepathy
Author URI: http://www.dtelepathy.com
License: GPL2

Copyright 2010 digital-telepathy  (email : support@digital-telepathy.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class DisablePlugins {
    var $namespace = "disable-plugins";
    var $version = '1.0.0';
    
    /**
     * Instantiation construction
     * 
     * @uses add_filter()
     */
    function __construct() {
        // Directory path to this plugin's files
        $this->dirname = dirname( __FILE__ );
        // Rules configurations directory
        $this->rules_dirname = $this->dirname . '/' . $this->namespace . '-rules';
        
        $this->siteurl = get_option( 'siteurl' );
        $siteurl_http_host = parse_url( $this->siteurl );
        $this->siteurl_http_host = $siteurl_http_host['host'];
        
        add_filter( 'option_active_plugins', array( &$this, 'option_active_plugins' ), 1000, 1 );
    }
    
    /**
     * Initialization function to hook into the WordPress init action
     * 
     * Instantiates the class on a global variable and sets the class, actions
     * etc. up for use.
     */
    function instance() {
        global $DisablePlugins;
        
        $DisablePlugins = new DisablePlugins();
    }
    
    /**
     * Load rules to parse which plugins load where
     */
    private function load_rules() {
        $rules = array();
        
        // Check fo the existence of the rules configuration directory
        if( !is_dir( $this->rules_dirname ) ) {
            // Check if we can create the rules directory if it doesn't exist yet
            if( is_writeable( dirname( $this->rules_dirname ) ) ) {
                // Create the rules configuration directory for use
                mkdir( $this->rules_dirname );
            } else {
                return false;
            }
        }
        
        $siteurl_rules_file = $this->rules_dirname . '/' . $this->siteurl_http_host . '.rules';
        if( !file_exists( $siteurl_rules_file ) ) {
            if( is_writeable( $this->rules_dirname ) ) {
                file_put_contents( $siteurl_rules_file, "# Start writing plugin exception rules below\n\n" );
            }
        }
        
        // Grab all the rules from the configuration directory and build a keyed array based off the hostname portion of the file name
        $rules_files = glob( $this->rules_dirname . '/*.rules' );
        foreach( (array) $rules_files as $rules_file ) {
            $key = preg_replace( "/\.rules$/", "", basename( $rules_file ) );
            $rules[$key] = file_get_contents( $rules_file );
        }
        
        return $rules;
    }
    
    /**
     * Hook into WordPress option_$option filter
     * 
     * Get processed array of active plugins being loaded for a view to allow filtering
     * based off of a user's preferences
     */
    function option_active_plugins( $plugins ) {
        $rules = $this->load_rules();
        $uri = $_SERVER['REQUEST_URI'];

        // If there are no rules, end the filter process and return the $plugins untouched
        if( !array_key_exists( $this->siteurl_http_host, $rules ) ) {
            return $plugins;
        }
        
        // Create an array from the loaded rules string, split on new lines
        $site_rules = explode( "\n", $rules[$this->siteurl_http_host] );
        
        // Array of indexes to loop through and unset from $plugins
        $filtered_indexes = array();
        
        // Loop through each rule and check for matches based on URI regex and plugin basename
        foreach( $site_rules as $site_rule ) {
            // If this is a comment line, skip row processing
            if( preg_match( "/^\#/", $site_rule ) || empty( $site_rule ) ) {
                continue;
            }
            
            // Break up rule line on white space, regex pattern first, plugin basename second
            $pattern_plugin = preg_split( "/\s|\t/", $site_rule );
            $pattern = "/{$pattern_plugin[0]}/";
            $plugin_basename_filter = $pattern_plugin[1];
            
            // Loop through each plugin to see if the plugin to remove is activated
            for( $i = 0; $i < count( $plugins ); $i++ ) {
                $plugin = $plugins[$i];
                
                // Determine the basename of the plugin based on its directory name
                $plugin_basename = dirname( $plugin );
                // If the plugin was not in a sub-directory, use the file name as the basename
                if( empty( $plugin_basename ) ) {
                    $plugin_basename = preg_replace( "/\.php$/", "", basename( $plugin ) );
                }
                
                // If the regex pattern matches the current URI and the plugin to filter is active, log its array index in $plugins for removal
                if( preg_match( $pattern, $uri ) && $plugin_basename == $plugin_basename_filter ) {
                    $filtered_indexes[] = $i;
                }
            }
        }
        
        // Loop through the $plugins array and remove all plugins to be filtered off this page
        foreach( $filtered_indexes as $filtered_index ) {
            unset( $plugins[$filtered_index] );
        }
        
        return $plugins;
    }
}

// Initiate the DisablePlugins class
DisablePlugins::instance();
