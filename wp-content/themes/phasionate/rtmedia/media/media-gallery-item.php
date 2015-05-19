<?php
/** That's all, stop editing from here * */
global $rtmedia_backbone;
$rtmedia_backbone = array(
	'backbone' => false,
	'is_album' => false,
	'is_edit_allowed' => false
);
if ( isset( $_POST[ 'backbone' ] ) )
	$rtmedia_backbone['backbone'] = $_POST[ 'backbone' ];
if ( isset( $_POST[ 'is_album' ] ) )
	$rtmedia_backbone['is_album'] = $_POST[ 'is_album' ][0];
if ( isset( $_POST[ 'is_edit_allowed' ] ) )
	$rtmedia_backbone['is_edit_allowed'] = $_POST[ 'is_edit_allowed' ][0];
?>
<li class="rtmedia-list-item el-zero-fade" id="<?php echo rtmedia_id(); ?>">
	<?php do_action( 'rtmedia_before_item' ); ?>
	<a href ="<?php rtmedia_permalink(); ?>" title="<?php echo rtmedia_title(); ?>">
		<div class="rtmedia-item-thumbnail">

      <img src="<?php rtmedia_image("rt_media_thumbnail"); ?>" alt="<?php rtmedia_image_alt(); ?>" >

		</div>

		<div class="rtmedia-item-title">
			<h4 title="<?php echo rtmedia_title(); ?>">


				<?php echo rtmedia_title(); ?>

			</h4>
		</div>
	</a>
	<?php do_action( 'rtmedia_after_item' ); ?>
</li>
