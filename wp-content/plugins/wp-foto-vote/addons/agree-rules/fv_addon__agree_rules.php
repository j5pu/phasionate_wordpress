<?php
/*
	Add checkbox to agree with rules to Upload form
	Version: 0.2
 */
  
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action( 'plugins_loaded', 'FvAddon_UploadAgreeRulesInit2', 3 );
  
function FvAddon_UploadAgreeRulesInit2(){
	if (!class_exists( 'FvAddonBase' ) || class_exists('FvAddon_UploadAgreeRules')) {return;}
	  
	class FvAddon_UploadAgreeRules extends FvAddonBase {

		/**
		 * Constructor. Loads the class.
		 *
		 * @since 1.0.0
		 */
		protected function __construct($name, $slug) {
			//** Dont remove this, else addon will not works
			parent::__construct($name, $slug, 'api_v2');
		}
		
		/**
		 * Class instance.
		 *
		 * @since 2.2.083
		 *
		 * @var object
		 */
		protected static $instance;			

		/**
		 * Performs all the necessary actions	
		 *
		 * @since 1.0.0
		 */
		public function init() {
			//** Dont remove this, else $this->addonsSettings will be EMPTY!
			parent::init();	
			
			// if not admin area
			if ( !is_admin() ) {
				// if addon Enabled in settings
				if ( $this->_get_opt('enabled') ) {
					add_filter( 'fv_upload_form_rules_filer', array($this, 'upload_form_rules_hook_agree'), 10, 2 );
					add_action( 'fv_after_upload_form', array($this, 'after_upload_form_agree') );
				}
			}
			
		}

		/**
		 * Enqueue addon public script and styles
		 *
		 * @since 1.0.0
		 *
		 */
		public function public_assets() {

		}
		
		public function upload_form_rules_hook_agree($text, $counter) {
			$checked = '';
			if ( $this->_get_opt('checked') ) {
				$checked = 'checked';
			}
			
			return $text . '<div class="fv_wrapper">'
						. '<label><div class="number">' . $counter . '</div> ' . $this->_get_opt('title') . ' </label> '
						. '<label class="checkbox_input"><input type="checkbox" id="fv_rules" ' . $checked . ' /> ' . $this->_get_opt('text') . '</label>'
						. '<span class="description">' . wp_kses_post($this->_get_opt('description')) . '</span>'
					. '</div>';
		}
		
		public function after_upload_form_agree() {
			echo '<script> function fv_hook_upload_image(form) { if ( !document.querySelector("#fv_rules").checked ) { alert("' . sanitize_text_field($this->_get_opt('error')) . '");return false; } return true; } </script>';
		}	
		
		/**
		 * Dynamically add Addon settings section
		 *
		 * @since 1.0.0
		 */
		public function section_settings($sections) {
			//$sections = array();
			$sections[] = array(
				'title' => __('Upload: agree with rules', 'fv_uar'),
				'desc' => __('<p class="description">Configure agree rules checkbox in upload form.</p>', 'fv_uar'),
				'icon' => 'input-checked',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array(
					array(
						'id'        => $this->slug . '_enabled',
						'type'      => 'switch',
						'title'     => __('Show agree rules checkbox in upload form?', 'fv_uar'),
						'subtitle'  => __('Look, it\'s on!', 'fv_uar'),
						'default'   => true,
						/*'hint'      => array(
							'title'   => 'Hint Title',
							'content' => 'This is the content of the tool-tip'
						),*/
					),						
					array(
						'id'        => $this->slug . '_checked',
						'type'      => 'switch',
						'title'     => __('At init agree rules checkbox must be checked?', 'fv_uar'),
						'default'   => true,
					),		
					array(
						'id'       => $this->slug . '_title',
						'type'     => 'text',
						'title'    => __('Agree rules title', 'fv_uar'),
						'validate' => 'not_empty',
						'msg'      => 'please fill this field',
						'default'  => 'Contest rules:'
					),					 
					array(
						'id'       => $this->slug . '_text',
						'type'     => 'text',
						'title'    => __('Agree rules text', 'fv_uar'),
						'subtitle' => __('Alloved tags in field: [a, br, strong] for insert link into rules page.', 'fv_uar'),
						'validate' => 'html_custom',
						'allowed_html' => array( 
							'a' => array( 
								'href' => array(), 
								'title' => array() ,
						                  'target' => array(),
							), 
							'br' => array(), 
							'strong' => array() 
						),
						'msg'      => 'please correct fill this field',
						'default'  => 'I agree with <a href="#">rules</a>.'
					),	
					array(
						 'id'=>$this->slug . '_description',
						 'type' => 'textarea',
						 'title' => __('Short rules text', 'redux-framework-demo'), 
						 'desc' => 'Some HTML is allowed in here (a, br, em, strong).',
						 'validate' => 'html_custom',
						 'default' => '<br />Test',
						 'allowed_html' => array(
							  'a' => array(
									'href' => array(),
									'title' => array(),
							                  'target' => array(),
							  ),
							  'br' => array(),
							  'em' => array(),
							  'strong' => array()
						 )
					),					 
					array(
						'id'       => $this->slug . '_error',
						'type'     => 'text',
						'title'    => __('Agree rules error', 'fv_uar'),
						'subtitle' => __('Enter error message, if user not check "Agree with rules".', 'fv_uar'),
						'validate' => 'not_empty',
						'msg'      => 'please fill this field',
						'desc'      => 'No html allowed!',
						'default'  => 'For submit photo you are must agree with contest rules!'
					),

				
				)
			);

			return $sections;
		}


		/**
		 * Helper function to get the class object. If instance is already set, return it.
		 * Else create the object and return it.
		 *
		 * @since 1.0.0
		 *
		 * @return object $instance Return the class instance
		 */
		public static function get_instance() {

			if ( ! isset( self::$instance ) )
				return self::$instance = new FvAddon_UploadAgreeRules('UploadAgreeRules', 'uar');

			return self::$instance;

		}

	}

	/** Instantiate the class */
	FvAddon_UploadAgreeRules::get_instance();
}	// Function :: END