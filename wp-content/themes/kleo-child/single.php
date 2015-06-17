<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

get_header(); ?>

<?php
//Specific class for post listing */


if ( kleo_postmeta_enabled() ) {
	$meta_status = ' with-meta';
	add_filter( 'kleo_main_template_classes', create_function( '$cls','$cls .= "'.$meta_status.'"; return $cls;' ) );
}
$related = sq_option( 'related_posts', 1 );
if(get_cfield( 'related_posts') != '' ) {
	$related = get_cfield( 'related_posts' );
}
?>

<?php
//create full width template

kleo_switch_layout('right');

?>

<?php get_template_part( 'page-parts/general-before-wrap' );?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>


    <?php get_template_part( 'content', get_post_format() ); ?>

		<?php get_template_part( 'page-parts/posts-social-share' ); ?>

		<?php 
		if( $related == 1 ) {
			get_template_part( 'page-parts/posts-related' );
		}
		?>

		<?php
		global $not_post_in;
		$author_posts_args = array(
			'numberposts' => 3,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => 'views',
			'post_type' => 'post',
			'post_status' => 'publish', 
			'author' => get_the_author_meta( 'ID' ),
			'date_query' => array('column' => 'post_date_gmt', 'before' => '1 month ago') // Muestra los post más leidos solo del último mes.	
		);	
		$author_posts = get_posts($author_posts_args);
		?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
	<?php echo get_avatar( get_the_author_meta( 'user_email' ), 150 ); ?></a>
	<a class="author-link url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
	<h2 class="fn"><?php echo (get_the_author( )) ; ?></h2></a>
	<div class="authorinfo role">
		<?php the_author_meta( 'description' ); ?><br/>
	</div>
	<div class="postAuthor">
		<h5>Otros de sus articulos:</h5>
		<?php
		foreach( $author_posts as $author_post ) {
			echo '<div class="portada_posts">';
			$link = get_permalink($author_post->ID);
			$title = get_the_title($author_post->ID);			
			echo '<a href="'.$link.'">'.get_the_post_thumbnail( $author_post->ID, 'medium' ).'<h5><a href="'.$link.'">'.$title.'</a></h5>'.'</a>';
			echo '</div>';
			wp_reset_query();
		}
		?>
	</div>
</div>

		<?php
		$cats = get_the_category();
		$cat_name = $cats[0]->name;
		if ($cat_name == "Streetstyle"){
			$user_david = get_user_by( "email", "david@bizeulabs.com" );
		?>
<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo esc_url(get_author_posts_url( $user_david->id)); ?>" rel="author">
	<?php echo get_avatar( $user_david->id , 150 ); ?></a>
	<a class="author-link url" href="<?php echo esc_url(get_author_posts_url( $user_david->id)); ?>" rel="photographer">
	<h2 class="fn"><?php echo $user_david->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_david->description; ?><br/>
	</div>
</div>
		<?php
		}
		?>
		<?php
		// Previous/next post navigation.
		kleo_post_nav();
		?>
    <!-- Begin Comments -->
    <?php comments_template( '', true ); ?>
    <!-- End Comments -->
    
<?php endwhile; ?>

<?php get_template_part('page-parts/general-after-wrap');?>

<?php get_footer(); ?>