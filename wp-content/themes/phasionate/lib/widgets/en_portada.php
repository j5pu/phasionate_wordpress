<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class En_Portada_phasionate_widget extends WP_Widget {

	/**
	 * Widget setup
	 */
	function __construct() {
	
		$widget_ops = array( 
			'description' => __( 'Post en portada.', 'kleo_framework' ) 
		);
		parent::__construct( 'kleo_en_portada_phasionate', __('(Phasionate) En Portada widget','kleo_framework'), $widget_ops );
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

		$kleo_recent_posts = get_posts('tag=destacado&showposts=4&post_status=publish&order=DESC');
		?>
	
		<div>

			<ul class='news-widget-wrap'>

				<?php foreach( $kleo_recent_posts as $post ) : setup_postdata( $post ); ?>
					<li class="news-content-ph">
						<a class="news-link" href="<?php echo get_permalink($post->ID); ?>">							
                                <?php
                                $img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                                if ( $img_url != '' ) {
                                    $image = aq_resize( $img_url, 200, null, true, true, true );
                                    if( ! $image ) {
                                        $image = $img_url;
                                    }
                                    $html_img = '<img src="' . $image . '" alt="" title="">';
                                }
                                else {
                                    $html_img = '';
                                }

                                ?>
                                <span class="news-thumb-ph"><?php echo $html_img; ?></span>
                                <span class="news-headline-ph"><?php echo get_the_title($post->ID); ?></span>
								<span class="news-excerpt-ph"><small><p><?php echo $post->post_excerpt;?></p></small></span>
						</a>
		
					</li>
					<div class="clear"></div>
				<?php endforeach; wp_reset_postdata(); ?>

			</ul>

		</div>

		<?php

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
add_action( 'widgets_init', create_function( '', 'register_widget( "En_Portada_phasionate_widget" );' ) );
