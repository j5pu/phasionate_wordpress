<div class="form-group">
	<label for="gallery-image1">Gallery image <?php echo $i; ?></label> <small>(Use full image, thumbnail get`s automatically) </small>
	<div class="row">
		<div class="col-sm-17">
			<div class="input-group">
				<div class="input-group-addon"><span class="dashicons dashicons-images-alt"></span></div>
				<input value="<?php echo $photo_src; ?>" type="text" class="form-control" id="gallery-image<?php echo $i; ?>" placeholder="image url">				
			 </div>		      
			<input type="hidden" name="form[options][image<?php echo $i; ?>]" id="gallery-image<?php echo $i; ?>-id" value="<?php echo $photo_id; ?>">		
			
		</div>
		<div class="col-sm-2">
			<img src="<?php echo $photo_src; ?>" alt="" id="gallery-image<?php echo $i; ?>-thumb" height="28">			
		</div>
		<div class="col-sm-5">
			<button type="button" class="btn" onclick="fv_wp_media_upload('input#gallery-image<?php echo $i; ?>', 'input#gallery-image<?php echo $i; ?>-id', 'img#gallery-image<?php echo $i; ?>-thumb');">Select</button>			
		</div>
	</div>
</div>

<div class="clearfix"></div>
