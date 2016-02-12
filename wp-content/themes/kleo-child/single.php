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

	<!-- WP-PostRating - Muestra las estrellas para valorar el post -->
	<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
	
	<?php 
	$cats = get_the_category();
	$cat_name = $cats[0]->name;
	foreach ($cats as $struct ) {
		if ( $struct->cat_name == 'Streetstyle'){
			$cat_name = $struct->cat_name;
		}
	}
	if ($cat_name == "Streetstyle"){
		if( $related == 1 ) {
			?>
			<h4 class="titleLinksToStreet">Más de <a href="<?php echo get_category_link( $cats[0]->id );?>">Street Style</a></h4>
			<?php
			get_template_part( 'page-parts/posts-related' );
		}
	}
	?>

	<?php
	global $not_post_in;
	$current_post = get_the_ID();
	$author_posts_args = array(
		'post__not_in' => array($current_post),
		'numberposts' => 3,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'meta_key' => 'views',
		'post_type' => 'post',
		'post_status' => 'publish', 
		'author' => get_the_author_meta( 'ID' ),
		'date_query' => array('column' => 'post_date_gmt', 'before' => '1 week ago') // Muestra los post más leidos solo del último mes.	
	);	
	$author_posts = get_posts($author_posts_args);

// Descarta la caja de autor en la seccion StreetStyle
	if ($cat_name != "Streetstyle"){
	?>

	<div>
		<h2 class="newTitleAuthor">
		<a class="author-link photo newAuthorPhoto" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>" rel="author"> 
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 100 ); ?>
		</a>
		<span>Más artículos de </span>
		<a class="author-link url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>" rel="author">
			<?php echo (get_the_author( )) ; ?>
		</a>
		</h2>
		<div class="postAuthor">
			<?php
			foreach( $author_posts as $author_post ) {
				echo '<div class="portada_posts">';
				$link = get_permalink($author_post->ID);
				$title = get_the_title($author_post->ID);			
				echo '<a class="element-wrap" href="'.$link.'">'.get_the_post_thumbnail( $author_post->ID, 'medium' ).'<span class="hover-element"><i></i></span></a>'.'<h5><a href="'.$link.'">'.$title.'</a></h5>';
				echo '</div>';
				wp_reset_query();
			}
			?>
		</div>
	</div>

	<?php
	}else{
	?>
	<style>
	@media(min-width: 768px) { .adv-320x100{ display: none !important; } }
	@media(max-width: 768px) { .adv-300x600{ display: none !important; } }
	</style>
	<!-- Banner Definitivo Streetstyle (PC) -->
	<ins class="adsbygoogle streetStyleAdv adv-300x600"
	     style="display:inline-block;width:300px;height:600px"
	     data-ad-client="ca-pub-9006336585437783"
	     data-ad-slot="1908822954"></ins>
	<!-- Banner Definitivo Streetstyle (Móvil) -->
	<ins class="adsbygoogle streetStyleAdv adv-320x100"
	     style="display:inline-block;width:320px;height:100px"
	     data-ad-client="ca-pub-9006336585437783"
	     data-ad-slot="3385556152"></ins>
	<script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/streetstyleScript.js"></script>
	<?php	
	}

	// Previous/next post navigation.
	// kleo_post_nav();
	?>

<!-- Banner Google Adsense -->
<!-- Banner Street Style MadrEat (Guia) -->
<ins class="adsbygoogle"
     style="display:block;margin: 20px auto;"
     data-ad-client="ca-pub-9006336585437783"
     data-ad-slot="2807354150"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!-- Banner Google Adsense -->		
    <!-- Begin Comments -->
    <?php comments_template( '', true ); ?>
    <!-- End Comments -->
 
<?php endwhile; ?>

<?php get_template_part('page-parts/general-after-wrap');?>

<?php get_footer(); ?>