<?php
/**
 * Template Name: Concurso de portada
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */
get_header();
kleo_switch_layout('no');
get_template_part('page-parts/general-before-wrap-no-title');
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        get_template_part( 'content', 'page' );
    endwhile;
endif;
get_template_part('page-parts/general-after-wrap'); ?>
<?php get_footer(); ?>