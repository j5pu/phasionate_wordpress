<?php
$categories = get_the_category($post->ID);

if (!$categories) {
	return;
}
?>

<section class="container-wrap">
	<div class="container">
		<div class="related-wrap">
			<?php
					$category_ids = array();
					foreach($categories as $rcat) { $category_ids[] = $rcat->term_id; }

					$args=array(
						'category__in' => $category_ids,
						'post__not_in' => array($post->ID),
						'showposts'=> 8,
						'orderby' => 'rand' //random posts
					);
				
				query_posts($args);

				if ( have_posts() ) : ?>
        
        <div class="hr-title hr-long"><abbr><?php _e("Related Articles", "kleo_framework");?></abbr></div>
        
				<div class="kleo-carousel-container dot-carousel">
					<div class="kleo-carousel-items kleo-carousel-post" data-min-items="1" data-max-items="6">
						<ul class="kleo-carousel">

							<?php
							while ( have_posts() ) : the_post();

								get_template_part('page-parts/post-content-carousel');

							endwhile;
							?>

						</ul>
					</div>
					<div class="carousel-arrow">
						<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
						<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
					</div> 
					<div class="kleo-carousel-post-pager carousel-pager"></div>
				</div><!--end carousel-container-->

				<?php
				endif;

				// Reset Query
				wp_reset_query();
				?>
		</div>
	</div>
</section>