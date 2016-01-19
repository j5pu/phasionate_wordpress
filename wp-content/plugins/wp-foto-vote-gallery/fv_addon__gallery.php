<?php

/*
  Plugin Name: WP Foto Vote - Gallery addon
  Plugin URI: http://wp-vote.net/
  Description: Add more than 1 image to photo
  Author: Maxim Kaminsky
  Author URI: http://www.maxim-kaminsky.com/
  Plugin support EMAIL: wp-vote@hotmail.com
  Version: 0.2

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!defined('FV_GALL_DIR')) {
    define('FV_GALL_DIR', plugin_dir_path(__FILE__));
}
if (!defined('FV_GALL_URL')) {
    define('FV_GALL_URL', plugin_dir_url(__FILE__));
}

// Init class early then Redux Framework, for add Addon options, else they are not added
add_action('plugins_loaded', 'FvAddon_GalleryRun', 3);

function FvAddon_GalleryRun() {
    if (!class_exists('FvAddonBase')) {
        return;
    }

    class FvAddon_Gallery extends FvAddonBase {

        /**
         * Addon version
         * @var float
         */
        CONST VER = 0.2;

        protected $IMG_COUNT;

        /**
         * Class instance.
         *
         * @since 2.2.083
         *
         * @var object
         */
        protected static $instance;

        /**
         * Constructor. Loads the class.
         *
         * @since 2.2.083 / 0.1
         */
        protected function __construct($name, $slug) {
            //** Dont remove this, else addon will not works
            parent::__construct($name, $slug, 'api_v2');
        }

        /**
         * Performs all the necessary actions	
         *
         * @since 2.2.083 / 0.1
         */
        public function init() {
            //** Dont remove this, else $this->addonsSettings will be EMPTY!
            parent::init();
            $count = $this->_get_opt('count');
            if ( $count && $count > 0) {
                $this->IMG_COUNT = $count;
            } else {
                $this->IMG_COUNT = 3;
            }

            //&& (get_current_user_id() > 0 || FvFunctions::curr_user_can()
            //if ( $this->_get_opt('enabled') ) {
                //add_action( 'fv/public/custom_upload/run', array($this, 'filter_fv_public_custom_upload_run'), 10, 2 );			
            //}
            if ( $this->_get_opt('enabled')  ) {
                if ( is_admin() ) {
                    add_action('fv/admin/form_edit_photo/extra', array($this, 'action_form_edit_photo_extra'), 10, 1);
                }

                add_action('fv/public/punterest_theme/list_item/extra', array($this, 'action_show'), 10, 1);
                add_action('fv_after_contest_list', array($this, 'action_public_assets'), 10, 1);
                add_filter('fv/public/theme/list_item/rel', array($this, 'filter_rel'), 10, 2);
            }
            
        }

        public function filter_rel($rel, $photo) {
            return $rel . $photo->id;
        }

        /**
         * Return access token from File
         *
         * @since 2.2.083 / 0.1
         * @return string @access_token@
         */
        public function action_form_edit_photo_extra($photo) {
            //$photo->options = FvFunctions::getContestOptionsArr($photo->options);

            for ($i = 0; $i < $this->IMG_COUNT; $i++) {
                $photo_src = '';
                $photo_id = '';

                if (isset($photo->options['image' . $i]) && (int) $photo->options['image' . $i] > 0) {
                    $photo_id = (int) $photo->options['image' . $i];
                    $photo_src = reset(wp_get_attachment_image_src($photo_id, 'thumbnail'));
                }
                include 'views/_photo_edit_form_extra.php';
            }
        }

        /**
         * Show info
         *
         */
        public function action_show($photo) {
            $photo->options = FvFunctions::getContestOptionsArr($photo->options);
            echo "<div class='contest-block-extra'/>";
            for ($i = 0; $i < $this->IMG_COUNT; $i++) {
                if (isset($photo->options['image' . $i]) && (int) $photo->options['image' . $i] > 0) {
                    $photo_src = reset(wp_get_attachment_image_src((int) $photo->options['image' . $i], 'full'));
                    $photo_src_thumb = reset(wp_get_attachment_image_src((int) $photo->options['image' . $i], 'thumbnail'));
                    echo "<a href='$photo_src' class='fv_lightbox' rel='fw{$photo->id}' title='{$photo->name}' data-id='{$photo->id}'><img src='{$photo_src_thumb}'/></a>";
                }
            }
            echo "</div>";
        }

        /**
         * Enqueue addon public styles
         *
         * @since 2.2.083 / 0.1
         */
        public function action_public_assets() {
            wp_enqueue_style($this->slug . 'css', FV_GALL_URL . '/assets/fv_gallery.css', false, self::VER, 'all');
        }

        /**
         * Dynamically add Addon settings section
         *
         * @since 2.2.083 / 0.1
         */
        public function section_settings($sections) {
            //var_dump($this->addonsSettings[$this->slug . '_access_token']);
            $description = '<p class="description">This addon allow add more than one image for one contest item (just from admin).</p>';

            //$sections = array();
            $sections[] = array(
                'title' => 'Gallery',
                'desc' => $description,
                'icon' => 'image-outline',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array(
                    array(
                        'id' => $this->slug . '_enabled',
                        'type' => 'switch',
                        'title' => 'Enable gallery addon?',
                        //'subtitle'  => __('Admin can delete all photos!', 'fv_upd'),
                        'default' => true,
                    ),
                    array(
                        'id' => $this->slug . '_count',
                        'type' => 'number',
                        'title' => 'How many gallery fileds add?',
                        //'subtitle' => __('Enter access token from https://www.dropbox.com/developers/apps', 'fv_upd'),
                        //'validate'  => 'numeric',
                        //'msg'      => 'Please fill this field!',
                        'default' => '3'
                    ),
                )
            );

            return $sections;
        }

        /**
         * Helper function to get the class object. If instance is already set, return it.
         * Else create the object and return it.
         *
         * @since 2.2.083 / 0.1
         *
         * @return object $instance Return the class instance
         */
        public static function get_instance() {

            if (!isset(self::$instance)) {
                return self::$instance = new FvAddon_Gallery('Gallery', 'gall');
            }

            return self::$instance;
        }

    }

    /** Instantiate the class */
    FvAddon_Gallery::get_instance();
}

// Function :: END
