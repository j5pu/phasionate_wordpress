<?php
/*
	Plugin Name: WP Foto Vote addon - confirm vote
	Plugin URI: http://wp-vote.net/
	Description: Confirm vote modal 
	Author: Maxim Kaminsky
	Author URI: http://www.maxim-kaminsky.com/
	Plugin support EMAIL: wp-vote@hotmail.com
	Version: 0.1
  
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
	ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
	ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
	ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.   

 */


// Init class early then Redux Framework, for add Addon options, else they are not added
add_action( 'plugins_loaded', 'FvAddon_CoutdownDeafultRun', 3 );

function FvAddon_CoutdownDeafultRun(){
	if (!class_exists( 'FvAddonBase' )) {return;}

	class FvAddon_CoutdownDeafult extends FvAddonBase {
		CONST VER = 0.1;

        public $addonUrl;
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
			parent::__construct($name, $slug);
            $this->addonUrl = FV::$ADDONS_URL . 'coutdown-deafult/';
		}

		/**
		 * Performs all the necessary actions	
		 *
		 * @since 2.2.083 / 0.1
		 */
		public function init() 
		{
			//** Dont remove this, else $this->addonsSettings will be EMPTY!
			parent::init();

            add_action( 'fv/load_countdown/default', array($this, 'run'), 10, 3 );
		}

        public function run($contest_date_start, $contest_date_finish, $public_translated_messages) {
            wp_enqueue_style('fv_coutdown-deafult', $this->addonUrl . 'assets/fv-countdown-default.css', false, self::VER, 'all');
            wp_enqueue_script('fv_coutdown-deafult', $this->addonUrl . 'assets/fv-countdown-default.js', array('jquery'), self::VER);

            $date_diff = strtotime($contest_date_finish) - current_time('timestamp', 0);
            $days_leave = round($date_diff / 86400);
            $hours_leave = floor( ($date_diff % 86400) / (60 * 60) );
            $minutes_leave = floor( ($date_diff % 86400) % (60 * 60) / 60 );
            $secs_leave = floor( ($date_diff % 86400) % (60 * 60) % 60 );

            include_once 'views/default.php';
        }

        public function register($countdowns) {
            $countdowns['default'] = 'Default';
            return $countdowns;
        }


		/**
		 * Performs all the necessary Admin actions
		 *
		 * @since 2.2.083
		 */
		public function admin_init() {
			//** Dont remove this, else $this->addonsSettings will be EMPTY!
			parent::admin_init();			
			// There you can load plugin textdomain as example
            add_filter( 'fv/countdown/list', array($this, 'register'), 10, 1 );
		}		

		/**
		 * Enqueue addon public script and styles
		 *
		 * @since 2.2.083 / 0.1
		 *
		 */
		public function public_assets_scripts() 
		{
		}
		
		/**
		 * Enqueue addon public styles
		 *
		 * @since 2.2.083 / 0.1
		 */
		public function public_assets_styles() {
			//wp_enqueue_style( $this->slug . '_css', FV_CV_URL . '/assets/fv_confirm-vote.css', false, self::VER, 'all');
		}						
		
		/**
		 * Dynamically add Addon settings section
		 *
		 * @since 2.2.083 / 0.1
		 */
		public function section_settings($sections) 
		{
		
			//$sections = array();
            /*
			$sections[] = array(
				'title' => __('Confirm vote', $this->mu_slug),
				'desc' => __('<p class="description">This addon enable confirm modal window before vote.</p>', $this->mu_slug),
				'icon' => 'el-icon-check',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array(
					array(
						'id'        => $this->slug . '_enabled',
						'type'      => 'switch',
						'title'     => __('Enable confirm before vote?', $this->mu_slug),
						//'subtitle'  => __('', $this->mu_slug),
						'default'   => true,
					),													
					array(
						'id'       => $this->slug . '_confirm_title',
						'type'     => 'text',
						'title'    => __('Title - confirm vote', $this->mu_slug),
						'subtitle' => __('Enter success modal title (1-2 word)', $this->mu_slug),
						'validate' => 'not_empty',
						'default'  => 'Confirm your vote'
					),
					array(
						'id'       => $this->slug . '_confirm_msg',
						'type'     => 'text',
						'title'    => __('Message - confirm vote', $this->mu_slug),
						'subtitle' => __('Enter success modal title', $this->mu_slug),
						'validate' => 'not_empty',
						'default'  => 'Are you sure to vote for this entry?'
					),									
				
				)
			);
            */
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
		public static function get_instance() 
		{

			if ( ! isset( self::$instance ) )
				return self::$instance = new FvAddon_CoutdownDeafult('CoutdownDeafult', 'cd');

			return self::$instance;

		}

	}
	
	/** Instantiate the class */
	$fvAddon_65482 = FvAddon_CoutdownDeafult::get_instance();
	
}	// Function :: END