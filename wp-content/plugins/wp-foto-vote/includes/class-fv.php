<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @since      2.2.073
 *
 * @package    FV
 * @subpackage FV/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.2.073
 * @package    FV
 * @subpackage FV/includes
 * @author     Maxim K <wp-vote@hotmail.com>
 */
class FV
{

        /**
         * The current version of the plugin.
         *
         * @since    2.2.073
         * @access   public
         * @var      const VERSION The current version of the plugin.
         */
        const VERSION = '2.2.110';

        const NAME = 'fv';
        const PREFIX = 'fv_';
        const SLUG = 'wp-foto-vote';
        public static $DEBUG_MODE;

        const ADDONS_OPT_NAME = 'fv_addons_settings';

        public static $ADDONS_URL;
        public static $ADDONS_ROOT;

        public static $ASSETS_URL;
        public static $THEMES_ROOT;
        public static $THEMES_ROOT_URL;
        public static $ADMIN_ROOT;
        public static $ADMIN_URL;
        public static $ADMIN_PARTIALS_ROOT;
        public static $INCLUDES_ROOT;

        public static $PUBLIC_ROOT;

        public static $ADDONS;

        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         *
         * @since    2.2.073
         * @access   protected
         * @var      FV_Loader $loader Maintains and registers all hooks for the plugin.
         */
        protected $loader;

        /**
         * The unique identifier of this plugin.
         *
         * @since    2.2.073
         * @access   protected
         * @var      string $FV The string used to uniquely identify this plugin.
         */
        protected $NAME;


        /**
         * The unique identifier of this plugin.
         *
         * @since    2.2.073
         * @access   protected
         * @var      string $FV The string used to uniquely identify this plugin.
         */
        protected $file;


        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin name and the plugin version that can be used throughout the plugin.
         * Load the dependencies, define the locale, and set the hooks for the Dashboard and
         * the public-facing side of the site.
         *
         * @since    2.2.073
         */
        public function __construct($file, $plugin_dir)
        {

                $this->file = $file;
                //$this->NAME = 'wsds';

                self::$ADDONS_URL = plugins_url(self::SLUG . "/addons/");
                self::$ADDONS_ROOT = $plugin_dir . "/addons/";

                self::$ASSETS_URL = plugins_url(self::SLUG . "/assets/");
                self::$THEMES_ROOT = $plugin_dir . "/themes/";
                self::$THEMES_ROOT_URL = plugins_url(self::SLUG . "/themes/");
                self::$ADMIN_URL = plugins_url(self::SLUG . "/admin/");
                self::$ADMIN_ROOT = $plugin_dir . "/admin/";
                self::$ADMIN_PARTIALS_ROOT = $plugin_dir . "/admin/partials/";
                self::$INCLUDES_ROOT = $plugin_dir . "/includes/";

                self::$PUBLIC_ROOT = $plugin_dir . "/public/";

                $this->load_dependencies();

                // Init DEBUG Levels
                FvDebug::init_lvl();

                $this->load_plugin_textdomain();
                $this->define_admin_hooks();
                $this->define_public_hooks();
        }

        /**
         * Load the required dependencies for this plugin.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    2.2.073
         * @access   private
         */
        private function load_dependencies()
        {

                /**
                 * The class responsible for orchestrating the actions and filters of the
                 * core plugin.
                 */
                require_once self::$INCLUDES_ROOT . 'class-fv-loader.php';

                /**
                 * The classes for logging and debug
                 */
                require_once self::$INCLUDES_ROOT . 'libs/class-fv-logger.php';
                require_once self::$INCLUDES_ROOT . 'libs/class-fv-debug.php';

                if ( !defined('DOING_AJAX') || DOING_AJAX == FALSE ) {
                    if ( is_admin() )
                    {
                        /**
                         * Tables lists
                         */
                        require_once self::$INCLUDES_ROOT . 'libs/class-wp-list-table.php';
                        require_once self::$INCLUDES_ROOT . 'list-tables/class_contests_list.php';
                        require_once self::$INCLUDES_ROOT . 'list-tables/class_votes_log_list.php';

                        // Updates
                        require_once self::$INCLUDES_ROOT . 'plugin-updates/plugin-update-checker.php';
                    }

                    // Widgets
                    require_once self::$INCLUDES_ROOT . 'widget-list/class-widget.php';
                    require_once self::$INCLUDES_ROOT . 'widget-gallery/class-widget.php';
                }

                /**
                 * Functions and other
                 */
                require_once self::$INCLUDES_ROOT . 'class-fv-functions.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-translations.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-contest.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-lightbox-evolution.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-image-lightbox.php';
                require_once self::$INCLUDES_ROOT . 'libs/class_empty_unit.php';
                require_once self::$INCLUDES_ROOT . 'notice/class-admin-notice-helper.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-theme-base.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-addon-base.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-form-helper.php';
                require_once self::$ADDONS_ROOT . 'class-fv-addons-loader.php';

                /**
                 * The class responsible for working with db
                 */
                require self::$INCLUDES_ROOT . 'db/class-query.php';
                require_once self::$INCLUDES_ROOT . 'class-fv-db.php';

                /**
                 * The class responsible for defining all actions that occur in the Dashboard.
                 */
                require_once self::$ADMIN_ROOT . 'class-fv-admin.php';
                require_once self::$ADMIN_ROOT . 'class-fv-admin_pages.php';
                if ( is_admin() )
                {
                    require_once self::$ADMIN_ROOT . 'class-fv-admin_ajax.php';
                    require_once self::$ADMIN_ROOT . 'class-fv-admin_export.php';
                }

                /**
                 * The class responsible for defining all actions that occur in the public-facing
                 * side of the site.
                 */
                require_once self::$PUBLIC_ROOT . '/class-fv-public.php';
                require_once self::$PUBLIC_ROOT . '/class-fv-public-ajax.php';
                require_once self::$PUBLIC_ROOT . '/class-fv-public-vote.php';

                /**
                 * Redux options framework
                 */
                if ( FvFunctions::ss('disable-addons-support', false) == false ) {
                    require_once self::$INCLUDES_ROOT . 'redux/admin-init.php';
                }

                require_once self::$INCLUDES_ROOT . 'libs/BFI_Thumb.php';


                /*if (get_option('fotov-image-width', 0) > 50 && get_option('fotov-image-height', 0) > 50) {
                        add_image_size( 'fv-thumb', get_option('fotov-image-width', 0), get_option('fotov-image-height', 0), get_option('fotov-image-hardcrop', true) );
                }*/

                $this->loader = new FV_Loader();

        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the FV_i18n class in order to set the domain and to register the hook
         * with WordPress.
         *
         * @since    2.2.073
         * @access   private
         */
        private function load_plugin_textdomain()
        {
                //$plugin_i18n = new FV_i18n();
                //$plugin_i18n->set_domain($this->get_NAME());
                //$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

                load_plugin_textdomain(
                    FV::NAME, false, FV::SLUG . '/languages/'
                );
        }

        /**
         * Register all of the hooks related to the dashboard functionality
         * of the plugin.
         *
         * @since    2.2.073
         * @access   private
         */
        private function define_admin_hooks()
        {
                $plugin_admin = new FV_Admin($this->get_NAME(), $this->get_version());
                //$plugin_admin_pages = new FV_Admin_Pages($this->get_NAME());

                //$this->loader->add_action('init', $this, 'wp_init' );
                $this->loader->add_action('admin_init', $plugin_admin, 'process_admin_actions' );
                $this->loader->add_action('admin_init', $plugin_admin, 'register_fv_settings' );

                if ( is_admin() ) {
                    $this->loader->add_action('admin_menu', $plugin_admin, 'admin_pages');

                    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
                    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

                    $this->loader->add_action('wp_ajax_fv_clear_contest_stats', 'FV_Contest', 'clear_contest_stats');
                    $this->loader->add_action('wp_ajax_fv_reset_contest_votes', 'FV_Contest', 'reset_contest_votes');

                    $this->loader->add_action('wp_ajax_fv_form_contestant', 'FV_Contest', 'form_contestant');
                    $this->loader->add_action('wp_ajax_fv_save_contestant', 'FV_Contest', 'save_contestant');
                    $this->loader->add_action('wp_ajax_fv_approve_constestant', 'FV_Contest', 'approve_constestant');
                    $this->loader->add_action('wp_ajax_fv_delete_constestant', 'FV_Contest', 'delete_constestant');

                    $this->loader->add_action('wp_ajax_fv_rotate_image', 'FV_Admin_Ajax', 'rotate_image');
                    $this->loader->add_action('wp_ajax_fv_form_contestants', 'FV_Admin_Ajax', 'form_contestants');

                    $this->loader->add_action('wp_ajax_fv_export', 'FV_Admin_Export', 'run');

                    $this->loader->add_action('wp_ajax_fv_save_form_structure', 'FvFormHelper', 'AJAX_save_form_structure');
                    $this->loader->add_action('wp_ajax_fv_reset_form_structure', 'FvFormHelper', 'AJAX_reset_form_structure');

                    $this->loader->add_action('activated_plugin', 'FV_Functions','check_activation_error', 10, 2);

                    // Add settings link to plugins page
                    $this->loader->add_filter('plugin_action_links_' . $this->file, 'FV_Admin', 'add_settings_link');

                    // Upadting
                    $hook = "in_plugin_update_message-" . $this->file;
                    //FvLogger::addLog( $hook );
                    add_action($hook, 'fv_add_update_message', 10, 2);
                }

                //add_action('wp_ajax_fv_form_contestant', array('FV_Contest', 'form_contestant') );        
                //add_action('wp_ajax_fv_save_contestant', array('FV_Contest', 'save_contestant') );        
                //add_action('wp_ajax_fv_approve_constestant', array('FV_Contest', 'approve_constestant') );

                $this->loader->add_action('plugins_loaded', $this, 'plugins_loaded' );
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    2.2.073
         * @access   private
         */
        private function define_public_hooks()
        {
                $plugin_public = new FV_Public($this->get_NAME(), $this->get_version());

                $this->loader->add_shortcode("foto_vote", $plugin_public, "shortcode");
                $this->loader->add_shortcode("fv", $plugin_public, "shortcode");
                $this->loader->add_shortcode("fv_upload_form", $plugin_public, "shortcode_upload_form");
                $this->loader->add_shortcode("fv_contests_list", $plugin_public, "shortcode_show_contests_list");
                $this->loader->add_shortcode("fv_countdown", $plugin_public, "shortcode_countdown");
                $this->loader->add_shortcode("fv_leaders", $plugin_public, "shortcode_leaders");


                $this->loader->add_action('wp_ajax_vote', 'FvPublicVote', 'vote');
                $this->loader->add_action('wp_ajax_nopriv_vote', 'FvPublicVote', 'vote');

                $this->loader->add_action('wp_ajax_fv_is_subscribed', 'FvPublicVote', 'is_subscribed');
                $this->loader->add_action('wp_ajax_nopriv_fv_is_subscribed', 'FvPublicVote', 'is_subscribed');

                $this->loader->add_action('wp_ajax_fv_soc_login', 'FvPublicVote', 'soc_login');
                $this->loader->add_action('wp_ajax_nopriv_fv_soc_login', 'FvPublicVote', 'soc_login');

                $this->loader->add_action('wp_ajax_fv_upload', 'FvPublicAjax', 'upload_photo');
                $this->loader->add_action('wp_ajax_nopriv_fv_upload', 'FvPublicAjax', 'upload_photo');

                $this->loader->add_action('wp_ajax_fv_email_share', 'FvPublicAjax', 'email_share');
                $this->loader->add_action('wp_ajax_nopriv_fv_email_share', 'FvPublicAjax', 'email_share');

                $this->loader->add_action('wp_ajax_fv_ajax_get_votes', 'FvPublicAjax', 'ajax_get_votes_counts');
                $this->loader->add_action('wp_ajax_nopriv_fv_ajax_get_votes', 'FvPublicAjax', 'ajax_get_votes_counts');

                $this->loader->add_action('wp_ajax_fv_ajax_go_to_page', 'FvPublicAjax', 'ajax_go_to_page');
                $this->loader->add_action('wp_ajax_nopriv_fv_ajax_go_to_page', 'FvPublicAjax', 'ajax_go_to_page');

                // add action for lightbox
                $this->loader->add_action(FvLightboxEvolution::getActionName(), 'FvLightboxEvolution', 'assets');
                $this->loader->add_filter(FV::PREFIX . 'lightbox_list_array', 'FvLightboxEvolution', 'initListThemes');

                $this->loader->add_action(FvImageLightbox::getActionName(), 'FvImageLightbox', 'assets');
                $this->loader->add_filter(FV::PREFIX . 'lightbox_list_array', 'FvImageLightbox', 'initListThemes');


                $this->loader->add_action('send_headers', $plugin_public, 'set_upload_cookie');

                add_filter('wp_footer', 'fv_custom_css');

                // if selected load FB SDK in head loads it with wp_enqueue_scripts
                // else it's no urgent, and loads it if we really needed it
                if ( get_option('fv-fb-assets-position', 'footer') == 'head' ) {
                    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'fb_assets_and_init', 1 );
                } else {
                    $this->loader->add_action( 'fv_after_contest_list', $plugin_public, 'fb_assets_and_init' );
                    $this->loader->add_action( 'fv_after_contest_item', $plugin_public, 'fb_assets_and_init' );
                }

                global $contest_id;
                add_action('admin_bar_menu', 'fv_add_toolbar_items', 100);

                /*if ( isset($_GET["contest_id"]) ) {
                        # Remove WordPress' canonical links
                        remove_action('wp_head', 'rel_canonical');
                }*/


                FV_Addons_Loader::load();
        }


        // Check db version on plugin loads
        function plugins_loaded()
        {
                if ( defined('DOING_AJAX') && DOING_AJAX == TRUE ) {
                    return;
                }

                $current_db_version = get_option('fv_db_version');
                if ($current_db_version !== FV_DB_VERSION) {
                        $my_db = new FV_DB;
                        // upgrade tables
                        $my_db->install();
                }

                // init Addons
                //self::$ADDONS = apply_filters( 'fv/addons/list', array() );
                /*foreach (self::$ADDONS as $addon) {
                    $addon->init();
                }*/
        }

         // Runs when wp inited
        function wp_init()
        {
        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    2.2.073
         */
        public function run()
        {
                $this->loader->run();
        }

        /**
         * The name of the plugin used to uniquely identify it within the context of
         * WordPress and to define internationalization functionality.
         *
         * @since     2.2.073
         * @return    string    The name of the plugin.
         */
        public function get_NAME()
        {
                return self::NAME;
        }

        /**
         * The reference to the class that orchestrates the hooks with the plugin.
         *
         * @since     2.2.073
         * @return    FV_Loader    Orchestrates the hooks of the plugin.
         */
        public function get_loader()
        {
                return $this->loader;
        }

        /**
         * Retrieve the version number of the plugin.
         *
         * @since     2.2.073
         * @return    string    The version number of the plugin.
         */
        public function get_version()
        {
                return FV::VERSION;
        }

}
