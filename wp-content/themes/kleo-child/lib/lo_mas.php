<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Lo_mas_phasionate_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 
			'description' => __( 'Lo más en Phasionate', 'kleo_framework' ) 
		);
		parent::__construct( 'kleo_lo_mas_phasionate', __('(Phasionate) Lo m&aacute;s en... ','kleo_framework'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$desc = $instance['description'];
		$posts = empty( $instance['posts'] ) ? 1 : $instance['posts'];
		$cat = $instance['cat'];
		$display_count = $instance['display_count'];

		// Output our widget
		echo $before_widget;
		if( !empty( $title ) ) echo $before_title . $title . $after_title;

		if( $desc ) echo '<p>' . $desc . '</p>';

		$likes_posts_args = array(
			'numberposts' => $posts,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => 'views',
			'post_type' => 'post',
			'cat' => $cat,
			'post_status' => 'publish'
		);
		$likes_posts = get_posts($likes_posts_args);

		echo '<ul class="news-widget-wrap">';
		//$c=1;
		foreach( $likes_posts as $likes_post ) {
			$count_output = '';
			if( $display_count ) {
				$count = get_post_meta( $likes_post->ID, '_item_likes', true);
				
				$count_output = " <span class='item-likes-count'>($count)</span>";
			}
			
				$img_url = wp_get_attachment_url( get_post_thumbnail_id($likes_post->ID) );
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

			echo '<li class="news-content-ph">';
			?>
			  <a class="news-link" href="<?php echo get_permalink($likes_post->ID); ?>">
			  <span class="news-thumb-ph"><?php echo $html_img; ?></span>
              <span class="news-headline-ph"><?php echo get_the_title($likes_post->ID); ?></span>
			  <span class="news-excerpt-ph"><small><p><?php echo $likes_post->post_excerpt;?></p></small></span>
			<?php
			echo '</a></li><div class="clear"></div>';
			//$c++;
		}
		echo '</ul>';

		echo $after_widget;
		wp_reset_query();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description'], '<a><b><strong><i><em><span>');
		$instance['posts'] = strip_tags($new_instance['posts']);
		$instance['cat'] = $new_instance['cat'];
		$instance['display_count'] = strip_tags($new_instance['display_count']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);

		$defaults = array(
			'title' => __('Lo Mas', 'kleo_framework'),
			'description' => '',
			'posts' => 5,
			'cat' => '',
			'display_count' => 1
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];
		$description = $instance['description'];
		$posts = $instance['posts'];
		$cat = $instance['cat'];
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
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php _e( 'Show from category: ' , 'kleo_framework' ); ?></label>
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name( 'cat' ), 'show_option_all' => __( 'All categories' , 'kleo_framework' ), 'hide_empty' => 1, 'hierarchical' => 1, 'selected' => $cat ) ); ?>
		</p>

		<?php
	}
}

/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "Lo_mas_phasionate_widget" );' ) );
