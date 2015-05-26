<?php
/**
 * Template Name: Full-With + Img My Phasion
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php /*get_template_part('page-parts/general-title-section'); */?>

<?php /*get_template_part('page-parts/general-before-wrap'); */?>

<img style="border-top: 2px solid #F66; border-bottom: 2px solid #F66; width: 100%; position: relative; top: -5px;" src="/wp-content/themes/kleo-child/assets/img/portada_login.jpg" alt="portada_login" />

<?php
if ( have_posts() ) :
	// Start the Loop.
	while ( have_posts() ) : the_post();

		/*
		 * Include the post format-specific template for the content. If you want to
		 * use this in a child theme, then include a file called called content-___.php
		 * (where ___ is the post format) and that will be used instead.
		 */
		get_template_part( 'content', 'page' );

	endwhile;

endif;
?>
        
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>