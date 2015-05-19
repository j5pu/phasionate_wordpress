<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class En_shopping_area_phasionate_widget extends WP_Widget {

	/**
	 * Widget setup
	 */
	function __construct() {
	
		$widget_ops = array( 
			'description' => __( 'Shopping Area.', 'kleo_framework' ) 
		);
		parent::__construct( 'kleo_shopping_area_phasionate', __('(Phasionate)Shopping Area widget','kleo_framework'), $widget_ops );
	}

	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		
		$title = apply_filters( 'widget_title', $instance['title'] );

		// Output our widget
		echo $before_widget;
		if( !empty( $title ) ) echo $before_title . $title . $after_title;
		//sacamos los post mas visitadod del un plugin, wp_postviews
		 $args = array(
			'numberposts' => 1,
			'cat' => '566',
			'post_type' => 'post',
			'post_status' => 'publish',
		 	'order' => 'DESC',
 			'orderby' => 'meta_value_num'
		);
		$shop_post = get_posts($args);
		//aqui hacemos lo de siempre, y pintamos el Html, según los resultados
		foreach( $shop_post as $shop_post ) {			
			echo '<h2 style="text-align: center;font-family:Playfair Display;font-weight:400;font-style:normal">'.get_the_title($shop_post->ID).'</h2>';
			//echo $shop_post->post_content;
			echo do_shortcode( $shop_post->post_content );
			wp_reset_query();
		}


		echo $after_widget;
		
	}

	/**
	 * Update widget
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = esc_attr( $new_instance['title'] );
		return $instance;

	}

	/**
	 * Widget setting
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
        $defaults = array(
            'title' => '',
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = esc_attr( $instance['title'] );

	?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'kleo_framework' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		

	<?php
	}

}

/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "En_shopping_area_phasionate_widget" );' ) );
