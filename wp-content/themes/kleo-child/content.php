<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>
<?php
$postclass = '';
if( is_single() && get_cfield('centered_text') == 1) { $postclass = 'text-center'; } ?>

<?php if (is_single()): //para la paginacion esto tb aparece en archive.php  ?>
	<!-- Begin Article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(array($postclass)); ?>>	
	<h3>
		<?php echo get_the_excerpt(); ?>
	</h3>
	<span class="date updated" style="display:none"><?php the_time(); ?></span>
	<hr/>
	<?php
		$cats = get_the_category();
		$cat_name = $cats[0]->name;
		if ($cat_name != "Streetstyle"){
	?>
	<div class="infoPost_beforeTitle">
		<span class="datePosted"><?php echo get_post_time('d/m/Y', true); ?></span>
		<a class="author-link url" href="<?php  echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )  ?>" rel="author"><?php echo (get_the_author( )) ; ?></a>
	</div>
	<?php }else{ ?>
	<div class="infoPost_beforeTitle">
		<span class="datePosted"><?php echo get_post_time('d/m/Y', true); ?></span>
		<a class="author-link url" href="<?php bloginfo('wpurl'); ?>/equipo" rel="author">Redacción</a>
	</div>
	<?php } ?>
<?php endif;?>
			<?php if(!is_single()):?><div class="content_posts portada_posts"><?php endif;?>				
				<?php if ( kleo_postmedia_enabled() && kleo_get_post_thumbnail() != '' ) : ?>
					<?php if (is_single()): ?>
							<?php echo kleo_get_post_thumbnail( null, 'kleo-full-width' );?>
						<?php else :?>
							<a  href="<?php the_permalink()?>" class="element-wrap"><span class="hover-element"><i>.</i></span><?php echo kleo_get_post_thumbnail( null, 'kleo-full-width' );?></a>
					<?php endif; ?>				
				<?php if (! is_single() ) : ?>
				<?php $category = get_the_category();?>
					<div class="hr-title hr-long">
						<abbr>
						<a  href="<?php the_permalink()?>">
						<!--a href="<?php echo get_category_link($category[0]->term_id );?>"-->
							<?php echo $category[0]->cat_name ?>
						</a>
					</div>
					<h5>
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'kleo_framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h5>
				<?php endif; ?>
			
				<?php if (! is_single() ) : ?>
					<div class="pt-cv-content"><small><?php echo get_the_excerpt();?></small></div>
				<?php endif; //! is_single() ?>

				<?php endif; ?>

				<?php if (  is_single() ) : // Only display Excerpts for Search ?>
					<div class="article-content">
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'kleo_framework' ) ); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'kleo_framework' ), 'after' => '</div>' ) ); ?>
						<?php echo get_the_tag_list('<p class="tags">',', ','</p>');?>
					</div>
				<?php endif; ?>
				<!--end article-content-->
			<?php if(!is_single()):?></div><?php endif;?>	
</article><!--end article-->


