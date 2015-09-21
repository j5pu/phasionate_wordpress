<!-- This file is used to markup the public-facing widget. -->
<?php
//var_dump ($r);

$output = '';
if ($r) :
	$contest_link = fv_generate_contestant_link($contest_id, $link);
	
	if ($title) { $output .= $before_title . $title . $after_title; }
	
	$output .= '<ul class="contestant-gallery">';
	foreach ($r as $contestant) :
		//$r->the_post();

		if ($link) {
			$photo_url = $contest_link . '=' . $contestant->id;
		} else {
			$photo_url = '';
		}
		$img_src = FvFunctions::getPhotoThumbnailArr($contestant);
        //wp_get_attachment_image_src($contestant->image_id);
		$thumbnail = $img_src[0];
		$output .=sprintf('<li class="contestant-thumb" style="width:%4$s;"><a href="%1$s" title="%3$s"><img src="%3$s" alt="%2$s" title="%2$s"/></a></li>', $photo_url, __('View', 'fv'), $thumbnail, $block_size);
	endforeach;
	$output .= '</ul>';

endif;
echo $output;

    