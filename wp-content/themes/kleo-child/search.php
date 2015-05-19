<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

get_header(); ?>

<?php 
//Specific class for post listing */
$blog_type = sq_option('blog_type','masonry');
$template_classes = $blog_type . '-listing';
if ($blog_type == 'standard' && sq_option('blog_meta_status', 1) == 1) { $template_classes .= ' with-meta'; }
add_filter('kleo_main_template_classes', create_function('$cls','$cls .=" posts-listing '.$template_classes.'"; return $cls;'));
?>

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

	<?php if ( have_posts() ) :

	if ($blog_type == 'masonry') : ?>
		<div class="row">
			<div class="grid-posts kleo-isotope masonry">
	<?php endif; ?>

	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			?>
			<?php 
			if ($blog_type == 'masonry') :
				 get_template_part( 'page-parts/post-content-masonry');
			else:  
				$col = "content-col-2";
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(array($postclass.$col)); ?>>				
				<?php
				 get_template_part( 'content', get_post_format() );
			endif;

		endwhile;
		
		if ($blog_type == 'masonry') : ?>
				</div>
			</div>
		<?php endif; ?>	

		<?php
		
		// Previous/next post navigation.
		kleo_pagination();

	else :
		// If no content, include the "No posts found" template.
		?>
		<div class="no-search">
			<p class="">&iexcl;Ooooops!</p> 
		</div>
		<?php
		get_template_part( 'content', 'none' );

	endif;
?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>