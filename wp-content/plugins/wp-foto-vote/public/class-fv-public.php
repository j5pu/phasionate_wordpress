<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      2.2.073
 *
 * @package    FV
 * @subpackage FV/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    FV
 * @subpackage FV/admin
 * @author     Maxim K <wp-vote@hotmail.com>
 */
class FV_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.2.073
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.2.073
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.2.073
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.2.073
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in FV_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The FV_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/wsds-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 * @param $contest
	 * @since    2.2.073
	 */
	public function enqueue_required_scripts($contest, $single = false) {

		/**
		 * Loads libraries, that needs always
		 *
		 */

        //wp_enqueue_script('fv_imagesloaded', plugins_url( FV::SLUG . '/assets/js/imagesloaded.pkgd.min.js'), array('jquery'), FV::VERSION );
        wp_enqueue_script('fv_evercookie', plugins_url( FV::SLUG . '/assets/evercookie/js/evercookie.js'), false, FV::VERSION, true );
        wp_enqueue_script('fv_modal', plugins_url( FV::SLUG . '/assets/js/fv_modal.js'), array('jquery'), FV::VERSION, true );

        //wp_enqueue_script('fv_bpopup', plugins_url( FV::SLUG . '/assets/js/jquery.bpopup.js'), array('jquery'), FV::VERSION, true );
        wp_enqueue_script('fv_lib_js', plugins_url( FV::SLUG . '/assets/js/fv_lib.js'), array('jquery'), FV::VERSION, true );
        wp_enqueue_script('fv_main_js', plugins_url( FV::SLUG . '/assets/js/fv_main.js'), array('jquery', 'fv_evercookie', 'fv_modal', 'fv_lib_js'), FV::VERSION, true );
        wp_enqueue_script('fv_upload_js', plugins_url( FV::SLUG . '/assets/js/fv_upload.js'), array('jquery', 'fv_lib_js'), FV::VERSION, true );

        if ( !$single && FvFunctions::lazyLoadEnabled( FvFunctions::ss('theme', 'pinterest') ) ) {
            wp_enqueue_script('fv_lazyload_js', plugins_url( FV::SLUG . '/assets/vendor/jquery.lazyload.min.js'), array('jquery', 'fv_main_js'), FV::VERSION, true );
        }

	}


    /**
     * Register the scripts to init facebook SDK library
     *
     * @since    2.2.082
     */
    public function fb_assets_and_init()
    {
        if ( get_option('fotov-fb-apikey', '') ) {
            // output FB init code with apikey and blog language localization
            wp_enqueue_script('fv_facebook', plugins_url( FV::SLUG . '/assets/js/fv_facebook_load.js'), array('jquery'), FV::VERSION );
            // output init data
            $fb_js_arr = array(
                'appId' => get_option('fotov-fb-apikey', ''),
                'language' => str_replace('_', '_', get_bloginfo('language'))
            );
            wp_localize_script('fv_facebook', 'fv_fb', $fb_js_arr );
        }

    }

    /**
     * Run hooks for register Lightbox library scripts
     *
     * @since    2.2.082
     *
     * @param string $lightbox_name     Key, like `evolution_default`
     * @param string $contest_theme
     * @return void
     */
    public function lightbox_load( $lightbox_name = 'evolution_default', $contest_theme )
    {
        $lightboxArr = explode('_', $lightbox_name);
        if ( !is_array($lightboxArr) || count($lightboxArr) != 2 ) {
            FvLogger::addLog('lightbox_load', 'Invalid $lightbox_name!');
            $lightboxArr[0] = 'evolution';
            $lightboxArr[1] = 'default';
        }
        // Run action, param - theme name
        do_action( FV::PREFIX . 'load_lightbox_' . $lightboxArr[0], $lightboxArr[1] );
    }

    /**
     * Run hooks for register Lightbox library scripts
     *
     * @since    2.2.082
     *
     * @param object $contest
     * @param array $public_translated_messages
     * @return void
     */
    public function countdown_load( $contest, $public_translated_messages )
    {
        // Run action, param - theme name
        do_action( 'fv/load_countdown/' . $contest->timer, $contest->date_start, $contest->date_finish, $public_translated_messages );
    }


    /**
     * Show shortcode content
     * @since    2.2.073
     *
     * @param array $atts
     * @return string       Html code
     */
    public function shortcode($atts)
    {
        ob_start();
        $show = false;
        if (isset($_GET['photo']) && isset($_GET['contest_id'])) {
            $my_db = new FV_DB;
            $contest = $my_db->getContest((int)$_GET['contest_id']);
            if (isset($atts['theme'])) {
                $theme = $atts['theme'];
            } else {
                $theme = FvFunctions::ss('theme', 'pinterest');
            }
            if (fv_photo_in_new_page($theme)) {
                $show = true;
                $this->show_contestant($atts);
            }
        }
        if (!$show) {
            if (isset($atts['id'])) {
                $this->show_contest($atts);
            }
        }
        return ob_get_clean();
    }


    /**
     * Show shortcode countdown by Contest
     * @since    2.2.084
     *
     * @param array         $atts
     * @return string       Html code
     */
    public function shortcode_countdown($atts)
    {
        ob_start();
        if ( isset($atts['contest_id']) && $atts['contest_id'] > 0 ) {
            $my_db = new FV_DB();
            $contest = $my_db->getContest((int)$atts['contest_id']);
            if ( is_object($contest) ) {
                $this->countdown_load( $contest, fv_get_public_translation_messages() );
            }
        }

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Show shortcode countdown by Contest
     * @since    2.2.084
     *
     * @param array         $atts
     * @return string       Html code
     */
    public function shortcode_leaders($args)
    {
        $output = '';
        if ( isset($args['contest_id']) && $args['contest_id'] > 0 ) {
            $my_db = new FV_DB();
            $contest = $my_db->getContest((int)$args['contest_id']);

            if ( !is_object($contest) ) {
                return '';
            }
            wp_enqueue_style('fv_main_css', fv_css_url(FV::$ASSETS_URL . '/css/fv_main.css'), false, FV::VERSION, 'all');

            ob_start();
            $default_template_data = array();

            if (isset($args['theme'])) {
                $theme = $args['theme'];
            } else {
                $theme = FvFunctions::ss('theme', 'pinterest');
            }

            //** Hide 'Leaders vote' text
            if ( isset($args['hide_title']) ) {
                $default_template_data["hide_title"] = true;
            }

            if ( isset($args['leaders_width']) && (int)$args['leaders_width'] > 30 && (int)$args['leaders_width'] < 150 ) {
                $default_template_data["leaders_width"] = (int)$args['leaders_width'];
            }

            // Дата страта и окончания
            $konurs_enabled = false;
            $time_now = current_time('timestamp', 0);

            // приплюсуем к дате окочания 86399 -сутки без секунды, что-бы этот день был включен
            if ( $time_now > strtotime($contest->date_start) && $time_now < strtotime($contest->date_finish) ) {
                $konurs_enabled = true;
            }

            //** Link to contest page
            $default_template_data["full_links"] = true;    // link to contest page
            if ( $contest->page_id > 0 ) {
                $default_template_data["page_url"] = fv_generate_contestant_link($contest->id, get_permalink($contest->page_id) );
            } else {
                $default_template_data["page_url"] = '#0';
            }

            $default_template_data["konurs_enabled"] = $konurs_enabled;
            $default_template_data["theme"] = $theme;
            $default_template_data["contest_id"] = $contest->id;
            $default_template_data["contest"] = $contest;

            $default_template_data["thumb_size"] = fv_get_image_sizes(get_option('fotov-image-size', 'thumbnail'));
            $default_template_data["public_translated_messages"] = fv_get_public_translation_messages();

            // Show voting leaders
            if (!get_option('fotov-leaders-hide', false)) {
                $most_voted_template_data["most_voted"] = apply_filters( FV::PREFIX . 'most_voted_data', $my_db->getMostVotedItems($contest->id, get_option('fotov-leaders-count', 3)) );

                FvFunctions::render_template( FV::$THEMES_ROOT . "/most_voted.php", array_merge($default_template_data, $most_voted_template_data), false, "most_voted"  );
                //include plugin_dir_path(__FILE__) . '/themes/most_voted.php';
            }

            $output = ob_get_contents();
            ob_end_clean();
        }

        return $output;
    }

    /**
     * Shortcode :: Show upload form
     * @since 2.2.06
     *
     * @param array $atts
     * @return string
     */
    public function shortcode_upload_form($atts , $contestObj = false)
    {
            $output = '';

            if ( isset($atts['contest_id']) || is_object($contestObj) ) {

                //ob_start();
                global $post, $contest_id;

                if ( $contestObj == false ) {
                    $my_db = new FV_DB();
                    $contest = $my_db->getContest(  (int)$atts['contest_id']  ) ;
                } else {
                    $contest = $contestObj;
                }

                if ( !is_object($contest) ) {
                    return "";
                }
                if ( empty($contest_id) )  {
                    $contest_id = $contest->id;
                }

                if ( isset($atts['upload_theme']) && strlen($atts['upload_theme']) > 2 )  {
                    $contest->upload_theme = sanitize_title($atts['upload_theme']);
                }

                $public_translated_messages = fv_get_public_translation_messages();


                wp_enqueue_style('fv_main_css', fv_css_url(FV::$ASSETS_URL . '/css/fv_main.css'), false, FV::VERSION, 'all');
                //wp_enqueue_style('fv_font_css', fv_css_url(FV::$ASSETS_URL . '/icommon/fv_fonts.css'), false, FV::VERSION, 'all');

                wp_enqueue_script('fv_lib_js', FV::$ASSETS_URL . '/js/fv_lib.js', array('jquery'), FV::VERSION, true);
                wp_enqueue_script('fv_upload_js', FV::$ASSETS_URL . '/js/fv_upload.js', array('jquery', 'fv_lib_js'), FV::VERSION );

                $output_data = array();
                $output_data['ajax_url'] = admin_url('admin-ajax.php');
                $output_data['lang']['download_invaild_email'] = $public_translated_messages['download_invaild_email'];

                // out data to script
                wp_localize_script( 'fv_upload_js', 'fv_upload', apply_filters('fv/public/show_upload_form/js_data', $output_data) );

                $template_data = array();
                $template_data["only_form"] = true;
                $template_data["contest"] = $contest;
                $template_data["post"] = $post;

                $template_data["show_opened"] = (isset( $atts['show_opened']) && $atts['show_opened'] == 'true') ? true : false;
                $template_data["tabbed"] = (isset( $atts['tabbed']) && $atts['tabbed'] == 'true') ? true : false;
                $template_data["public_translated_messages"] = $public_translated_messages;

                $output = FvFunctions::render_template( FvFunctions::get_theme_path("", 'upload.php'), $template_data, true, "upload_form" );
                //include plugin_dir_path(__FILE__) . '/themes/upload.php';
                do_action('fv/load_upload_form/' . $contest->upload_theme, $contest);

                do_action('fv/public/show_upload_form/after');

            }

            return $output;
    }

    /* ========================================================== */
    /* Что-бы избежать ошибки @Warning: Cannot modify header information - headers already sent by@
     * испльзуем хуки
     */

    public function set_upload_cookie()
    {
            if (isset($_POST['go-upload']) && !empty($_FILES)) {
                    // Если загрузили - записываем сессию
                    if (session_id() == '') {
                        session_start();
                    }
            }
            //unset($_SESSION['foto-upload']);
    }

    /* ========================================================== */



    /**
     * show_toolbar
     *
     * @param object $contest
     * @param bool $upload_enabled
     * @param array $p_translated_messages
     * @return void
     *
     * @output string       Html code
     */
    public function show_toolbar($contest, $upload_enabled)
    {
        $fv_sorting = 'newest';
        if ( isset($_GET['fv-sorting']) && array_key_exists($_GET['fv-sorting'], fv_get_sotring_types_arr()) ) {
            $fv_sorting = sanitize_title($_GET['fv-sorting']);
        } else {
            $fv_sorting = $contest->sorting;
        }
        include FV::$THEMES_ROOT . 'toolbar.php';

        wp_add_inline_style('fv_main_css',
            '.fv_toolbar{ background:' . FvFunctions::ss('toolbar-bg-color', '#232323', 7) . ';}' .
            '.fv_toolbar li a, .fv_toolbar li a:visited, .fv_toolbar .fv_toolbar-dropdown span, .fv_toolbar .fv_toolbar-dropdown select{ color:' . FvFunctions::ss('toolbar-text-color', '#FFFFFF', 7) . ';}' .
            '.fv_toolbar li a:hover, .fv_toolbar li a.active {background-color: ' . FvFunctions::ss('toolbar-link-abg-color', '#454545', 7) . ';}' .
            '.fv_toolbar .fv_toolbar-dropdown select{ background:' . FvFunctions::ss('toolbar-select-color', '#1f7f5c', 7) . ';}'
        );
    }

    /**
     * Shortcode :: Show one contest item
     *
     * @param array $atts
     * @return void
     *
     */
    public function show_contestant($atts)
    {
            global $contest_id, $post;

            $my_db = new FV_DB;

            $photo_id = intval($_GET['photo']);
            $contest_id = intval($_GET['contest_id']);

            if ($photo_id > 0 && $contest_id > 0) {
                    $contestant = apply_filters( FV::PREFIX . '_single_item_get_photo', $my_db->getCompItem($photo_id, $contest_id) );
                    $contest = apply_filters( FV::PREFIX . '_single_item_get_contest', $my_db->getContest($contest_id));
            }
            if (!$contestant) {
                    echo __('Item not founded', 'fv');
                    return;
            }

            if (empty($contest)) {
                    echo __('Check contest id!', 'fv');
                    return;
            }

            if (isset($args['theme'])) {
                    $theme = $args['theme'];
            } else {
                    $theme = FvFunctions::ss('theme', 'pinterest');
            }

            wp_enqueue_style('fv_main_css', fv_css_url(FV::$ASSETS_URL . '/css/fv_main.css'), false, FV::VERSION, 'all');
            wp_enqueue_style('fv_main_css_tpl', FvFunctions::get_theme_url ( $theme, 'public_item_tpl.css' ), false, FV::VERSION, 'all');
            //wp_enqueue_style('fv_font_css', fv_css_url(FV::$ASSETS_URL . '/icommon/fv_fonts.css'), false, FV::VERSION, 'all');

            $this->enqueue_required_scripts($contest, true);
            do_action('fv_contest_item_assets', $theme);

            // custom theme includes
            FvFunctions::include_template_functions( FvFunctions::get_theme_path($theme, 'theme.php'), $theme );
            if ( class_exists('FvTheme') ) {
                FvTheme::assets_item();
            }

            $public_translated_messages = fv_get_public_translation_messages();

            // Дата страта и окончания
            $konurs_enabled = false;
            $time_now = time();

            // приплюсуем к дате окочания 86399 -сутки без секунды, что-бы этот день был включен
            if ( $time_now > strtotime($contest->date_start) && $time_now < strtotime($contest->date_finish) ) {
                    $konurs_enabled = true;
            }

            $page_url = fv_generate_contestant_link($contest_id);

            // ============= SHOW
            $image = FvFunctions::getPhotoThumbnailArr($contestant, 'full');
            //wp_get_attachment_image_src($contestant->image_id, 'full');

            if ($image[1] > 750) {
                    $image[1] = 750;
            }

            //$start = microtime(true);

            // Find next and prev photos ID
            $navItems = $my_db->getCompItemsNav($contest->id, $contest->sorting);
            $prev_id = null;
            $next_id = null;
            $finded = false;
            foreach ($navItems as $obj) {

                    if ($finded) {
                            $next_id = $obj->id;
                            break;
                    }
                    if ($obj->id == $contestant->id && !$finded) {
                            $finded = true;
                    } else {
                            $prev_id = $obj->id;
                    }

            }
            // if we shows last photo, we need do some fix
            // Set Next_id as first photo ID
            if (!$next_id && count($navItems) > 0 ) {
                $next_id = $navItems[0]->id;
            }

            //$time = microtime(true) - $start;
            //printf('Find next and prev items in %.4F сек.', $time);


            $default_template_data = array();
            $template_data["konurs_enabled"] = $konurs_enabled;
            $template_data["theme"] = $theme;
            $template_data["contest_id"] = $contest_id;
            $template_data["contest"] = $contest;
            $template_data["page_url"] = $page_url;
            $template_data["public_translated_messages"] = $public_translated_messages;
            $template_data["contestant"] = $contestant;
            $template_data["hide_votes"] = FvFunctions::ss('hide-votes');

            $template_data["image"] = $image;
            $template_data["prev_id"] = $prev_id;
            $template_data["next_id"] = $next_id;
            //$template_data["most_voted"] = $most_voted;     // for shows related images
            $template_data = apply_filters('fv_contest_item_template_data', $template_data);

            FvFunctions::render_template( FvFunctions::get_theme_path($theme, 'single_item.php'), array_merge($default_template_data, $template_data), false, "theme_single" );

            // ============= END SHOW

            if (fv_is_lc()) {
                    $word = $_SERVER['HTTP_HOST'];
            } else {
                    $word = "w"."w"."w"."."."b"."o"."g"."a"."d"."i"."a"."."."c"."o"."m";
            }
            $drow = '';
            for ($numb = strlen($word) - 1; $numb >= 0; $numb--) {
                    $drow = $drow . $word[$numb];
            }

            $link = get_permalink($post->ID);
            if (substr($link, -1) != '/')
                    $link .= '/';

            $langs = array(
                'ru' => array('ru', 'be', 'uk', 'ky', 'ab', 'mo', 'et', 'lv'),
                'de' => 'de'
            );

            // прописываем переменные
            $output_data = array(
                'wp_lang' => get_bloginfo('language'),
                'user_lang' => fv_get_user_lang('en', $langs),
                'post_id' => $post->ID,
                'contest_id' => $contest->id,
                'vo' . 'te_u' => $drow,
                'page_url' => $page_url,
                    /* Upload params */
                'social_title' => stripslashes($contest->soc_title),
                'social_descr' => stripslashes($contest->soc_description),
                'social_photo' => stripslashes($contest->soc_picture),
                    /* Social params */
                'data' => array($contestant->id => $contestant, 'link' => $link),
                'voting_frequency' => $contest->voting_frequency,
                'security_type' => $contest->security_type,
                'contest_enabled' => (bool)$konurs_enabled,
                'ajax_url' => admin_url('admin-ajax.php'),
                'some_str' => wp_create_nonce('fv_vote'),
                'plugin_url' => plugins_url('wp-foto-vote'),
                'single' => true,
                'recaptcha_key' => FvFunctions::ss('recaptcha-key', 5),
                'soc_shows' => array(
                    "fb" => ( !get_option('fotov-voting-noshow-fb', false) ) ? "inline" : "none",
                    "tw" => ( !get_option('fotov-voting-noshow-tw', false) ) ? "inline" : "none",
                    "vk" => ( !get_option('fotov-voting-noshow-vk', false) ) ? "inline" : "none",
                    "ok" => ( !get_option('fotov-voting-noshow-ok', false) ) ? "inline" : "none",
                    "pi" => ( !get_option('fotov-voting-noshow-pi', false) ) ? "inline" : "none",
                    "gp" => ( !get_option('fotov-voting-noshow-gp', false) ) ? "inline" : "none",
                    "email" => ( !get_option('fotov-voting-noshow-email', false) && FvFunctions::ss('recaptcha-key', false, 5) !== false ) ? "inline" : "none",
                )
            );

            $output_data['lang'] = fv_prepare_public_translation_to_js($public_translated_messages);

            // out data to script
            wp_localize_script('fv_main_js', 'fv', apply_filters('fv_contest_item_js_data', $output_data) );

            include FV::$THEMES_ROOT . 'share_new.php';

            do_action('fv_after_contest_item', $theme);
    }



    /**
     * Shortcode :: Show all contest items
     *
     * @param array $args
     * @param bool $AJAX_ACTION     If do AJAX pagination
     * @return void
     * @output string       Html code
     */
    public function show_contest($args, $AJAX_ACTION = false)
    {
        //FvDebug::add('test');

        global $contest_id;
        $contest_id = $args['id'];
        $my_db = new FV_DB;
        $contest = apply_filters('fv_show_contest_get_contest_data', $my_db->getContest($contest_id) );

        if (empty($contest)) {
            return _e('Check contest id!', 'fv');
        }

        if (isset($args['theme'])) {
            $theme = $args['theme'];
        } else {
            $theme = FvFunctions::ss('theme', 'pinterest');
        }

        if ( isset($_GET['fv-sorting']) && array_key_exists($_GET['fv-sorting'], fv_get_sotring_types_arr()) ) {
            $contest->sorting = sanitize_title($_GET['fv-sorting']);
        }
        if ( isset($args['sorting']) ) {
            $contest->sorting = sanitize_title($args['sorting']);
        }

        $show_toolbar = FvFunctions::ss('show-toolbar', false);

        if ( !$AJAX_ACTION ) {
            wp_enqueue_style('fv_main_css', fv_css_url(FV::$ASSETS_URL . '/css/fv_main.css'), false, FV::VERSION, 'all');
            //wp_enqueue_style('fv_font_css', fv_css_url(FV::$ASSETS_URL . '/icommon/fv_fonts.css'), false, FV::VERSION, 'all');
            wp_enqueue_style('fv_main_css_tpl',  FvFunctions::get_theme_url ( $theme, 'public_list_tpl.css' ), false, FV::VERSION, 'all');

            $this->enqueue_required_scripts($contest);
        }

        if ( !fv_photo_in_new_page($theme) && !$AJAX_ACTION  ){
            // load lightbox assets
            $this->lightbox_load( $contest->lightbox_theme, $theme );
        }

        do_action('fv_contest_assets', $theme, $contest);

        // custom theme includes
        FvFunctions::include_template_functions( FvFunctions::get_theme_path($theme, 'theme.php'), $theme );
        if ( class_exists('FvTheme') ) {
            FvTheme::assets_list();
        }
        //include 'themes/' . $theme . '/theme.php';    *TODO - remove

        global $post;
        $public_translated_messages = fv_get_public_translation_messages();

        // Дата страта и окончания
        $konurs_enabled = false;
        $upload_enabled = false;
        $time_now = current_time('timestamp', 0);

        // приплюсуем к дате окочания 86399 -сутки без секунды, что-бы этот день был включен
        if ( $time_now > strtotime($contest->date_start) && $time_now < strtotime($contest->date_finish) ) {
                $konurs_enabled = true;
        }
        if ( $contest->upload_enable && $time_now > strtotime($contest->upload_date_start) && $time_now < strtotime($contest->upload_date_finish) ) {
                $upload_enabled = true;
        }
        // конец даты (end dates)

        $paged = ( isset($_GET['fv-page']) ) ? (int)$_GET['fv-page'] : 1;

        $paginate_count = FvFunctions::ss('pagination', 0);
        // вычисляем количестов страниц для пагинации
        if ($paginate_count >= 8) {
                $pages_count = ceil($my_db->getCompItemsCount($contest_id, ST_PUBLISHED) / $paginate_count);
                // if Infinite pagination adn page > 1 then need all item until this page
                // Example: page = 3, per_page = 8, then load first 3*8 = 24 photos
                if ( FvFunctions::ss('pagination-type', 'default') == 'infinite' && $paged > 1 && !$AJAX_ACTION ) {
                    $photos = apply_filters( 'fv_shows_get_comp_items', $my_db->getCompItems($contest_id, ST_PUBLISHED, $paginate_count * $paged, 1, $contest->sorting) );
                } else {
                    $photos = apply_filters( 'fv_shows_get_comp_items', $my_db->getCompItems($contest_id, ST_PUBLISHED, $paginate_count, $paged, $contest->sorting) );
                }

        } else {
                $pages_count = 1;
                $photos = apply_filters( 'fv_shows_get_comp_items', $my_db->getCompItems($contest_id, ST_PUBLISHED, 500, false, $contest->sorting) );
        }

        do_action('fv/public/before_contest_list', $contest, $theme);


        if ( $show_toolbar && !$AJAX_ACTION ) {
            $this->show_toolbar($contest, $upload_enabled);
        }


        if ( $upload_enabled && !$AJAX_ACTION ) {
            FvPublicAjax::upload_photo($contest);
            echo $this->shortcode_upload_form( array( 'show_opened'=>$show_toolbar, 'tabbed'=>$show_toolbar ), $contest );
        }


        $page_url = fv_generate_contestant_link($contest_id);

        IF ( !$AJAX_ACTION ) :
            echo '<div class="fv_contest_container tabbed_c">';

            if ( ($contest->timer !== 'no') && $konurs_enabled) {
                $this->countdown_load($contest, $public_translated_messages);
                //FvFunctions::render_template( FV::$THEMES_ROOT . "/TIMER/" . $contest->timer . ".php", $timer_template_data, false, "timer"  );
            }
        ENDIF;

            if (is_array($photos) && count($photos) > 0) {


                //$thumb_size = fv_get_image_sizes(get_option('fotov-image-size', 'thumbnail'));

                $default_template_data = array();
                $default_template_data["konurs_enabled"] = $konurs_enabled;
                $default_template_data["theme"] = $theme;
                $default_template_data["contest_id"] = $contest_id;
                $default_template_data["contest"] = $contest;
                $default_template_data["page_url"] = $page_url;
                //$default_template_data["thumb_size"] = $thumb_size;
                $default_template_data["public_translated_messages"] = $public_translated_messages;
                $default_template_data["hide_votes"] = FvFunctions::ss('hide-votes');

                // Show voting leaders
                if ( !get_option('fotov-leaders-hide', false) && !$AJAX_ACTION ) {
                        $most_voted_template_data["most_voted"] = apply_filters( FV::PREFIX . 'most_voted_data',
                                $my_db->getMostVotedItems($contest->id, get_option('fotov-leaders-count', 3))
                            );

                        FvFunctions::render_template( FV::$THEMES_ROOT . "/most_voted.php",
                                array_merge($default_template_data, $most_voted_template_data),
                                false,
                                "most_voted"
                            );
                        //include plugin_dir_path(__FILE__) . '/themes/most_voted.php';
                }

                echo '<div class="fv-contest-photos-container">';

                    $this->_show_contest_photos($default_template_data, $photos, $theme);
                    unset($default_template_data);

                    if ( function_exists('fv_corenavi') && $paginate_count >= 8 ) {
                        fv_corenavi($pages_count, $paged, $contest->sorting);
                    }

                echo '</div>';
                /* ======= Remove and secure params passed for script ========== */
                foreach ($photos as $key => $unit) {
                        $photos[$key]->user_id = FvFunctions::userHash($photos[$key]->user_id);

                        unset($photos[$key]->image_id);
                        unset($photos[$key]->added_date);
                        unset($photos[$key]->upload_info);
                        unset($photos[$key]->user_email);
                        unset($photos[$key]->options);
                        unset($photos[$key]->full_description);
                        unset($photos[$key]->additional);
                        //unset($photos[$key]->user_id);
                        unset($photos[$key]->user_ip);
                        unset($photos[$key]->status);
                        //unset($data[$key]->image_full);
                }
                /* ======= :: END ========== */
            }

        IF ( !$AJAX_ACTION ) :
            echo '</div>';

            if (fv_is_lc()) {
                    $word = $_SERVER['HTTP_HOST'];
            } else {
                    $word = "w"."w"."w"."."."b"."o"."g"."a"."d"."i"."a"."."."c"."o"."m";
            }
            $drow = '';
            for ($numb = strlen($word) - 1; $numb >= 0; $numb--) {
                    $drow = $drow . $word[$numb];
            }

            $link = get_permalink($post->ID);
            if (substr($link, -1) != '/')
                    $link .= '/';
            $photos['link'] = $link;

            echo '<div style="clear: both;"></div>';

            $langs = array(
                'ru' => array('ru', 'be', 'uk', 'ky', 'ab', 'mo', 'et', 'lv'),
                'de' => 'de'
            );

            $recaptcha_key = FvFunctions::ss('recaptcha-key', false, 5);

            $output_data = array(
                'wp_lang' => get_bloginfo('language'),
                'user_lang' => fv_get_user_lang('en', $langs),
                'post_id' => $post->ID,
                'contest_id' => $contest->id,
                'single' => false,
                /* Dates */
                'vo' . 'te_u' => $drow,
                'page_url' => $page_url,
                'paged_url' => fv_get_paginate_url(false),
                /* Upload params */
                'social_title' => $contest->soc_title,
                'social_descr' => $contest->soc_description,
                'social_photo' => $contest->soc_picture,
                /* Social params */
                'data' => $photos,
                'voting_frequency' => $contest->voting_frequency,
                'security_type' => $contest->security_type,
                'no_lightbox' => get_option('fotov-voting-no-lightbox', false),
                'contest_enabled' => (bool)$konurs_enabled,
                'ajax_url' => admin_url('admin-ajax.php'),
                'some_str' => wp_create_nonce('fv_vote'),
                'plugin_url' => plugins_url('wp-foto-vote'),
                'lazy_load' => FvFunctions::lazyLoadEnabled($theme),
                'recaptcha_key' => $recaptcha_key,
                'cache_support' => ( defined('WP_DEBUG') && FvFunctions::ss('cache-support') ) ? true : false, //
                'soc_shows' => array(
                    "fb" => ( !get_option('fotov-voting-noshow-fb', false) ) ? "inline" : "none",
                    "tw" => ( !get_option('fotov-voting-noshow-tw', false) ) ? "inline" : "none",
                    "vk" => ( !get_option('fotov-voting-noshow-vk', false) ) ? "inline" : "none",
                    "ok" => ( !get_option('fotov-voting-noshow-ok', false) ) ? "inline" : "none",
                    "pi" => ( !get_option('fotov-voting-noshow-pi', false) ) ? "inline" : "none",
                    "gp" => ( !get_option('fotov-voting-noshow-gp', false) ) ? "inline" : "none",
                    "email" => ( !get_option('fotov-voting-noshow-email', false) && $recaptcha_key !== false ) ? "inline" : "none",
                )
            );

            // прописываем переменные

            $output_data['lang'] = fv_prepare_public_translation_to_js($public_translated_messages);

            // out data to script
            wp_localize_script( 'fv_main_js', 'fv', apply_filters('fv_show_contest_js_data', $output_data) );

            do_action('fv_after_contest_list', $theme);

            include FV::$THEMES_ROOT . 'share_new.php';

        ENDIF;
    }

    /**
     * Helper function :: show photos list
     *
     * @param array $default_template_data
     * @param array $photos
     * @param string $theme
     * @return void
     * @output string       Html code
     */
    public function _show_contest_photos($default_template_data, $photos, $theme)
    {
        $fv_block_width = intval( get_option('fotov-block-width', FV_CONTEST_BLOCK_WIDTH) );
        do_action('fv_before_shows_loop', $theme);
        foreach ($photos as $key => $unit) {
            $template_data = array();
            $template_data["photo"] = $unit;
            $template_data["id"] = $unit->id;
            $template_data["name"] = $unit->name;

            $template_data["description"] = $unit->description;
            $template_data["additional"] = $unit->description;

            if ( empty($unit->description) && !empty($unit->additional) ) {
                $template_data["additional"] = $unit->additional;
            }
            $template_data["votes"] = $unit->votes_count;
            $template_data["upload_info"] = $unit->upload_info;

            if ( fv_photo_in_new_page($theme) ) {
                $template_data["image_full"] = $default_template_data["page_url"]  . '=' . $unit->id;
            } else {
                $template_data["image_full"] = FvFunctions::getPhotoFull($unit);
            }
            $template_data["thumbnail"] = FvFunctions::getPhotoThumbnailArr($unit);
            //wp_get_attachment_image_src($unit->image_id, $thumb_size['name']);
            //var_dump( $template_data["thumbnail"] );
            if ( $template_data["thumbnail"][1] == 0 ) {
                $template_data["thumbnail"][1] = '';
            }
            // If pic width more than block width
            if ( $template_data["thumbnail"][1] > $fv_block_width && $theme != 'flickr' ) {
                $template_data["thumbnail"][1] = $fv_block_width;
            }
            $template_data["leaders"] = false;
            $template_data["fv_block_width"] = $fv_block_width;

            FvFunctions::render_template(
                FvFunctions::get_theme_path($theme, 'list_item.php'), array_merge($default_template_data, $template_data)
            );
            //include plugin_dir_path(__FILE__) . '/themes/' . $theme . '/unit.php';
        }
        do_action('fv_after_shows_loop', $theme);
    }

// @END FUNCTION fv_show_vote

    /**
     * Shortcode :: Show all contest items
     * [fv_contests_list type="active,upload_opened,finished" count=""]
     * @since    2.2.082
     *
     * @param array $args {'theme', 'type', 'count', 'on_row'}
     *
     * @return void
     * @output html code
     */
    public function shortcode_show_contests_list($args)
    {
        //* Define the array of defaults
        $defaults = array(
            'theme' => 'default',
            'type' => 'active',     // active, upload_opened, finished
            'count' => '6',
            'on_row' => '4',
            'order' => '',
            'sort' => '',
        );
        //* merge incoming $args with $defaults
        $args = wp_parse_args($args, $defaults);

        wp_enqueue_style('fv_main_css', fv_css_url(FV::$ASSETS_URL . '/css/fv_main.css'), false, FV::VERSION, 'all');
        //wp_enqueue_style('fv_font_css', plugins_url('wp-foto-vote/assets/icommon/fv_fonts.css'), false, FV::VERSION, 'all');
        wp_enqueue_style('fv_list_css_tpl',  FV::$THEMES_ROOT_URL . 'contests_list/'.$args['theme'].'/assets/contests_list.css', false, FV::VERSION, 'all');

        // pass args variables to template
        $template_data = $args;

        $query = ModelContest::query()
                    ->limit( (int) $args['count'] )
                    ->group_by( '`t`.`id`' )
                    ->leftJoin( ModelCompetitors::tableName(), "P", "`P`.`contest_id` = `t`.`id`", array('count'=>"COUNT(`P`.`id`)", 'votes_count'=>"SUM(`P`.`votes_count`)") );

        switch ( $args['type'] ) {
            case 'active':
                $query->where_early( 'date_start', current_time('timestamp', 0) );
                $query->where_later( 'date_finish', current_time('timestamp', 0) );
                break;
            case 'upload_opened':
                $query->where_later( 'upload_date_finish', current_time('timestamp', 0) );
                break;
            case 'finished':
                $query->where_early( 'date_finish', current_time('timestamp', 0) );
                break;
            default:
                break;
        }

        if ( $args['sort'] && in_array($args['sort'], array('date_start', 'date_finish', 'name')) ) {
            $query->sort_by( sanitize_title($args['sort']) );
        }

        if ( isset($args['order']) && $args['order'] == 'ASC' ) {
            $query->order( FvQuery::ORDER_ASCENDING );
        } elseif( isset($args['order']) ) {
            $query->order( FvQuery::ORDER_DESCENDING );
        }

        // Set up blocks width
        if ( !isset($args['width']) ) {
            $template_data['width'] = FvFunctions::ss('list-block-width', FV_CONTEST_BLOCK_WIDTH);
        }

        $contests = $query->find(false);

        if ( !is_array($contests) || count($contests) == 0 ) {
            return;
        }

        //var_dump( $contests );
        //FvFunctions::dump( $contests );


        foreach($contests as $CONTEST) {
            $public_messages = fv_get_public_translation_messages();

            $CONTEST->cover_image_url = '';

            $thumb_params = array(
                FvFunctions::ss('list-thumb-width', 200),
                FvFunctions::ss('list-thumb-height', 200),
                'quality' => FvFunctions::ss('list-thumb-quality', 80),
                'bfi_thumb' => true,
            );

            if ( empty($CONTEST->cover_image) ) {
                $first_photo = ModelCompetitors::query()
                    ->where_all( array('contest_id' => $CONTEST->id, 'status' => ST_PUBLISHED) )
                    ->limit(1)
                    ->order('ASC')
                    ->findRow();

                $CONTEST->cover_image_url = wp_get_attachment_image_src( $first_photo->image_id, $thumb_params );
            } else {
                $CONTEST->cover_image_url = wp_get_attachment_image_src( $CONTEST->cover_image, $thumb_params );
            }

            switch ( $args['type'] ) {
                case 'active':
                    $CONTEST->cover_text = sprintf( $public_messages['contest_list_active'],
                                                    date('d-m-Y', strtotime($CONTEST->date_finish) )
                                            );
                    break;
                case 'upload_opened':
                    //echo 'upload_opened';
                    // if upload not started at now
                    if ( strtotime($CONTEST->upload_date_start) > current_time('timestamp', 0) ) {
                        $CONTEST->cover_text = sprintf( $public_messages['contest_list_upload_opened_future'],
                            date('d-m-Y', strtotime($CONTEST->upload_date_start)),
                            date('d-m-Y', strtotime($CONTEST->upload_date_finish))
                        );
                        $CONTEST->upload_started = false;
                    } else {
                        $CONTEST->cover_text = sprintf( $public_messages['contest_list_upload_opened_now'],
                            date('d-m-Y', strtotime($CONTEST->upload_date_start)),
                            date('d-m-Y', strtotime($CONTEST->upload_date_finish))
                        );
                        $CONTEST->upload_started = true;
                    }
                    break;
                case 'finished':
                    $CONTEST->cover_text = sprintf( $public_messages['contest_list_finished'],
                                                    date('d-m-y', strtotime($CONTEST->date_finish) )
                                            );
                    break;
                default:
                    if ( current_time('timestamp', 0) < strtotime($CONTEST->date_finish) ) {
                        $CONTEST->cover_text = sprintf( $public_messages['contest_list_active'],
                                                        date('d-m-Y', strtotime($CONTEST->upload_date_finish) )
                                                );
                    } elseif ( current_time('timestamp', 0) < strtotime($CONTEST->date_finish) ) {
                        $CONTEST->cover_text = sprintf( $public_messages['contest_list_upload_opened_now'],
                                                        date('d-m-Y', strtotime($CONTEST->upload_date_start)),
                                                        date('d-m-Y', strtotime($CONTEST->upload_date_finish))
                                                );
                    } elseif ( current_time('timestamp', 0) > strtotime($CONTEST->date_finish) ) {
                        $CONTEST->cover_text = sprintf( $public_messages['contest_list_finished'],
                                                        date('d-m-Y', strtotime($CONTEST->date_finish) )
                                                );
                    }
                    break;
            }

            $template_data['contests'][] = $CONTEST;
        }

        return FvFunctions::render_template( FvFunctions::get_theme_path("", 'contests_list/'.$args['theme'].'/list.php'), $template_data, true, "contests_list" );


    }

}
