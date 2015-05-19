<?php
/** 
 * Displays social share icons
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */


$social_share = sq_option( 'blog_social_share', 1 );
if( get_cfield( 'blog_social_share' ) != '' ) {
	$social_share = get_cfield( 'blog_social_share' );
}
$like_status = sq_option( 'likes_status', 1 );

if ( $social_share != 1 && $like_status != 1 ) {
	return;
}

?>
<section class="container-wrap">
	<div class="container">
		<div class="share-links">
      
      <div class="hr-title hr-long"><abbr><?php _e("Share this article:", "kleo_framework"); ?></abbr></div>
      
			<?php if ( $like_status == 1 ) : ?>
			
      <span class="kleo-love">
      	<?php do_action('kleo_show_love'); ?>
      </span>
			
			<?php endif; ?>
			
			<?php if ( $social_share == 1 ) : ?>
			
      <span class="kleo-facebook">
      	<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="post_share_facebook" onclick="javascript:window.open(this.href,
					'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;"><i class="icon-facebook"></i>
					</a>
				</li>
      </span>
      <span class="kleo-twitter">
      	<a href="https://twitter.com/share?url=<?php the_permalink(); ?>" class="post_share_twitter" onclick="javascript:window.open(this.href,
					'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;"><i class="icon-twitter"></i>
					</a>
      </span>
      <span class="kleo-googleplus">
      	<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
					'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="icon-gplus"></i>
					</a>
      </span>
      <span class="kleo-pinterest">
      	<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>"><i class="icon-pinterest-circled"></i>
					</a>
      </span>

		<?php
			$img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			if ( $img_url != '' ) {
				$image = aq_resize( $img_url, 200, null, true, true, true );
				if( ! $image ) {
					$image = $img_url;
				}
				$html_img = '<img src=\'' . $image . '\'></br>';
			}
			else {
				$html_img = '';			
			}	

			$email='<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'><html xmlns=\'http://www.w3.org/1999/xhtml\'><head><meta http-equiv=\'Content-Type\' content=\'text/html; charset=UTF-8\'/><title>Demystifying Email Design</title><meta name=\'viewport\' content=\'width=device-width, initial-scale=1.0\'/></head><body style=\'margin: 0; padding: 0;\'><table border=\'1\' cellpadding=\'0\' cellspacing=\'0\' width=\'100%\'><tr><td>'.$html_img.get_the_excerpt().'</br><a href='.get_permalink().'>Leer mas..</a></td></tr></table></body></html>';
		?>

      <span class="kleo-mail">
      	<a href="mailto:?subject=<?php the_title(); ?>&body=<?php echo $email;?>" class="post_share_email"><i class="icon-mail"></i>
					</a>
      </span>
			
      <?php endif; ?>
			
		</div>					
	</div>
</section>