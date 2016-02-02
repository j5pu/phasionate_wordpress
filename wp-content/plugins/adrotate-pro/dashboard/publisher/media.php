<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2015 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */
?>

<form method="post" action="admin.php?page=adrotate-media" enctype="multipart/form-data">
	<?php wp_nonce_field('adrotate_save_media','adrotate_nonce'); ?>
	<input type="hidden" name="MAX_FILE_SIZE" value="512000" />

	<h3><?php _e('Upload new file', 'adrotate-pro'); ?></h3>
	<label for="adrotate_image"><input tabindex="1" type="file" name="adrotate_image" /><br /><em><strong><?php _e('Accepted files:', 'adrotate-pro'); ?></strong> jpg, jpeg, gif, png, swf and flv. <?php _e('For HTML5 ads you can also upload html and javascript files.', 'adrotate-pro'); ?> <?php _e('Maximum size is 512Kb.', 'adrotate-pro'); ?></em><br /><em><strong><?php _e('Important:', 'adrotate-pro'); ?></strong> <?php _e('Make sure your file has no spaces or special characters in the name. Replace spaces with a - or _.', 'adrotate-pro'); ?><br /><?php _e('If you remove spaces from filenames for HTML5 adverts also edit the html file so it knows about the changed name. For example for the javascript file.', 'adrotate-pro'); ?></em></label>

	<?php if(get_option('adrotate_responsive_required') > 0) { ?>
        <p><em><?php _e('For responsive adverts make sure the filename is in the following format; "imagename.full.ext". A full set of sized images is strongly recommended.', 'adrotate-pro'); ?></em><br />
        <em><?php _e('For smaller size images use ".320", ".480", ".768" or ".1024" in the filename instead of ".full" for the various viewports.', 'adrotate-pro'); ?></em><br />
        <em><strong><?php _e('Example:', 'adrotate-pro'); ?></strong> <?php _e('image.full.jpg, image.320.jpg and image.768.jpg will serve the same advert for different viewports.', 'adrotate-pro'); ?></em></p>
	<?php } ?>

	<p class="submit">
		<input tabindex="2" type="submit" name="adrotate_media_submit" class="button-primary" value="<?php _e('Upload file', 'adrotate-pro'); ?>" /> <em><?php _e('Click only once per file!', 'adrotate-pro'); ?></em>
	</p>
</form>

<h3><?php _e('Available files in', 'adrotate-pro'); ?> '<?php echo '/'.$adrotate_config['banner_folder']; ?>'</h3>
<table class="widefat" style="margin-top: .5em">

	<thead>
	<tr>
        <th><?php _e('Name', 'adrotate-pro'); ?></th>
        <th width="12%"><center><?php _e('Actions', 'adrotate-pro'); ?></center></th>
	</tr>
	</thead>

	<tbody>
	<?php
	// Read Banner folder
	$files = array();
	if($handle = opendir(ABSPATH.$adrotate_config['banner_folder'])) {
	    while (false !== ($file = readdir($handle))) {
	        if ($file != "." AND $file != ".." AND $file != "index.php") {
	            $files[] = $file;
	        }
	    }
	    closedir($handle);

	    if(count($files) > 0) {
			sort($files);
			$banner_path = site_url('/'.$adrotate_config['banner_folder']);
			$class = '';
			foreach($files as $file) {
				$fileinfo = pathinfo($file);

				if($class != 'alternate') {
					$class = 'alternate';
				} else {
					$class = '';
				}
		
				if(
					(
						strtolower($fileinfo['extension']) == "jpg" 
						OR strtolower($fileinfo['extension']) == "gif" 
						OR strtolower($fileinfo['extension']) == "png" 
						OR strtolower($fileinfo['extension']) == "jpeg" 
						OR strtolower($fileinfo['extension']) == "swf" 
						OR strtolower($fileinfo['extension']) == "flv"
						OR strtolower($fileinfo['extension']) == "js" 
						OR strtolower($fileinfo['extension']) == "html"
					)
				) {
				    ?>
				    <tr class="<?php echo $class; ?>"><td><?php echo $file;?></td><td><center><a href="<?php echo admin_url('/admin.php?page=adrotate-media&file='.$file); ?>&_wpnonce=<?php echo wp_create_nonce('adrotate_delete_media_'.$file); ?>" title="<?php _e('Delete file', 'adrotate-pro'); ?>" onclick="return confirm('<?php _e('Are you sure you want to delete this file?', 'adrotate-pro'); ?>\n<?php _e('Make sure no adverts still use this image!', 'adrotate-pro'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate-pro'); ?>')"><?php _e('Delete', 'adrotate-pro'); ?></a></center></td></tr>
				    <?php
				}
			}
		} else {
	    	echo "<tr><td colspan='2'>".__('No files found', 'adrotate-pro')."</td></tr>";
		}
	} else {
    	echo "<tr><td colspan='2'>".__('Banners folder not found or not accessible', 'adrotate-pro')."</td></tr>";
	}
	?>
	</tbody>
</table>
<p><center>
	<?php _e("Make sure the banner images are not in use by adverts when you delete them!", "adrotate"); ?>
</center></p>
