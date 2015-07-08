<?php
/**
 * Template Name: Staff
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

<section class="container-wrap main-color">
	<div id="main-container" class="container-full">
		<div class="template-page col-sm-12 tpl-no">
			<div class="wrap-content">			
				<!-- Begin Article -->
				<article id="post-5732" class="clearfix post-5732 page type-page status-publish hentry">
    				<div class="article-content"> 
						<section class="container-wrap main-color" style="">
							<div class="section-container container">
								<div class="row">
									<div class="col-sm-12 wpb_column column_container">
										<div class="wpb_wrapper">
											<div class="kleo_text_column wpb_content_element ">
												<div class="wpb_wrapper">


<h2>DIRECTORA:</h2>

<?php $user_info = get_userdata(11); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; //echo esc_url( get_author_posts_url( '11' ) ); ?>" rel="author">
	<?php echo get_avatar( '11', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '11') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>        

<h2>REDACCIÓN:</h2>

<?php $user_info = get_userdata(71); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '71' ) ); ?>" rel="author">
	<?php echo get_avatar( '71', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '71') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>        

<?php $user_info = get_userdata(70); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '70' ) ); ?>" rel="author">
	<?php echo get_avatar( '70', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '70') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>        

<?php $user_info = get_userdata(35); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35' ) ); ?>" rel="author">
	<?php echo get_avatar( '35', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>        

<?php $user_info = get_userdata(206); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35' ) ); ?>" rel="author">
	<?php echo get_avatar( '206', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>   

<?php $user_info = get_userdata(208); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35' ) ); ?>" rel="author">
	<?php echo get_avatar( '208', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>   

<?php $user_info = get_userdata(207); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35' ) ); ?>" rel="author">
	<?php echo get_avatar( '207', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '35') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>   

<h2>FOTOGRAFÍA:</h2>

<?php $user_info = get_userdata(127); ?>

<div id="authorarea" class="vcard author">
	<a class="author-link photo" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '127' ) ); ?>" rel="author">
	<?php echo get_avatar( '127', 150 ); ?></a>
	<a class="author-link url" href="<?php echo "#"; // echo esc_url( get_author_posts_url( '127') ); ?>" rel="author">
	<h2 class="fn"><?php echo $user_info->display_name; ?></h2></a>
	<div class="authorinfo role">
		<?php echo $user_info->description; ?><br/>
	</div>
</div>        


												</div> 
											</div> 
										</div> 
									</div> 
								</div>
							</div>
						</section><!-- end section -->
					</div><!--end article-content-->
				</article>
				<!-- End  Article -->
			</div>
		</div>
	</div>
</section>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>