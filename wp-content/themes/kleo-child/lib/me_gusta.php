<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Me_gusta_phasionate_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 
			'description' => __( 'Post más votados en Phasionate', 'kleo_framework' ) 
		);
		parent::__construct( 'kleo_me_gusta_phasionate', __('(Phasionate) Me gusta','kleo_framework'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$desc = $instance['description'];
		$posts = empty( $instance['posts'] ) ? 1 : $instance['posts'];
		$display_count = $instance['display_count'];

		// Output our widget
		echo $before_widget;
		if( !empty( $title ) ) echo $before_title . $title . $after_title;

		if( $desc ) echo '<p>' . $desc . '</p>';

		$likes_posts_args = array(
			'numberposts' => $posts,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => '_item_likes',
			'post_type' => 'post',
			'post_status' => 'publish'
		);
		$kleo_recent_posts = get_posts($likes_posts_args);
		?>
	
			<div>

				<ul class='news-widget-wrap'>
			
					<?php 
					$c=1;
					foreach( $kleo_recent_posts as $post ) : setup_postdata( $post ); 
							$count_output = '';
							$count = get_post_meta( $post->ID, '_item_likes', true);
							//$count_output = " <span class='item-likes-count'>($count)</span>";
							$count_output = " - $count Votos -";				
					?>
							<li class="news-content-ph top5">
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

										<div class="news-num"><?php echo $c; ?></div>
										<div class="news-headline-ph"><?php echo get_the_title($post->ID); ?></div></br>
										<?php /*<span class="news-excerpt-ph"><small><p><?php echo $post->post_excerpt;</p></small></span>    */?> 
										<div class="clear"></div>
									
								</a>
				
							</li>
							<div class="clear"></div>
					<?php
							$c++;
							endforeach; wp_reset_postdata(); ?>

				</ul>

			</div>

		<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description'], '<a><b><strong><i><em><span>');
		$instance['posts'] = strip_tags($new_instance['posts']);
		$instance['display_count'] = strip_tags($new_instance['display_count']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);

		$defaults = array(
			'title' => __('Me gusta', 'kleo_framework'),
			'description' => '',
			'posts' => 5,
			'display_count' => 1
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];
		$description = $instance['description'];
		$posts = $instance['posts'];
		$display_count = $instance['display_count'];
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',"kleo_framework"); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:',"kleo_framework"); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo $description; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Posts:',"kleo_framework"); ?></label> 
			<input id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" type="text" value="<?php echo $posts; ?>" size="3" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('display_count'); ?>" name="<?php echo $this->get_field_name('display_count'); ?>" type="checkbox" value="1" <?php checked( $display_count ); ?>>
			<label for="<?php echo $this->get_field_id('display_count'); ?>"><?php _e('Display like counts',"kleo_framework"); ?></label>
		</p>

		<?php
	}
}

/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "Me_gusta_phasionate_widget" );' ) );
