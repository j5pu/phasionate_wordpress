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

<h3><?php _e('Summary', 'adrotate-pro'); ?></h3>
<p><em><?php _e('Overall statistics over active adverts', 'adrotate-pro'); ?></em></p>

<table class="widefat" style="margin-top: .5em">					

	<tbody>
	<?php if($adrotate_debug['advertiser'] == true) { ?>
	<tr>
		<td colspan="2">
			<?php 
			echo "<p><strong>User Report</strong><pre>"; 
			print_r($summary); 
			echo "</pre></p>"; 
			?>
		</td>
	</tr>
	<?php } ?>

    <tr>
		<th width="15%"><?php _e('General', 'adrotate-pro'); ?></th>
		<td><?php echo $summary['ad_amount']; ?> <?php _e('ads, sharing a total of', 'adrotate-pro'); ?> <?php echo $summary['total_impressions']; ?> <?php _e('impressions.', 'adrotate-pro'); ?></td>
	</tr>
    <tr>
		<th><?php _e('Most clicks', 'adrotate-pro'); ?></th>
		<td><?php if($summary['thebest']) {?>'<?php echo $summary['thebest']['title']; ?>' <?php _e('with', 'adrotate-pro'); ?> <?php echo $summary['thebest']['clicks']; ?> <?php _e('clicks.', 'adrotate-pro'); ?><?php } else { ?><?php _e('No ad stands out at this time.', 'adrotate-pro'); ?><?php } ?></td>
	</tr>
    <tr>
		<th><?php _e('Least clicks', 'adrotate-pro'); ?></th>
		<td><?php if($summary['theworst']) {?>'<?php echo $summary['theworst']['title']; ?>' <?php _e('with', 'adrotate-pro'); ?> <?php echo $summary['theworst']['clicks']; ?> <?php _e('clicks.', 'adrotate-pro'); ?><?php } else { ?><?php _e('No ad stands out at this time.', 'adrotate-pro'); ?><?php } ?></td>
	</tr>
    <tr>
		<th><?php _e('Average on all ads', 'adrotate-pro'); ?></th>
		<td><?php echo $summary['total_clicks']; ?> <?php _e('clicks.', 'adrotate-pro'); ?></td>
	</tr>
    <tr>
		<th><?php _e('Click-Through-Rate', 'adrotate-pro'); ?></th>
		<td><?php echo adrotate_ctr($summary['total_clicks'], $summary['total_impressions']); ?>%, <?php _e('based on', 'adrotate-pro'); ?> <?php echo $summary['total_impressions']; ?> <?php _e('impressions and', 'adrotate-pro'); ?> <?php echo $summary['total_clicks']; ?> <?php _e('clicks.', 'adrotate-pro'); ?></td>
	</tr>
	</tbody>

</table>

<h3><?php _e('Monthly overview of clicks and impressions', 'adrotate-pro'); ?></h3>
<table class="widefat" style="margin-top: .5em">					

	<tbody>
  	<tr>
        <th colspan="2">
			<div style="text-align:center;"><?php echo adrotate_stats_nav('advertiserfull', 0, $month, $year); ?></div>
        	<?php echo adrotate_stats_graph('advertiserfull', $current_user->ID, 1, $monthstart, $monthend); ?>
        </th>
  	</tr>
	</tbody>

</table>

<form method="post" action="admin.php?page=adrotate-advertiser">
<h3><?php _e('Export options for montly overview', 'adrotate-pro'); ?></h3>
<table class="widefat" style="margin-top: .5em">					

    <tbody>
    <tr>
		<th><?php _e('Select period', 'adrotate-pro'); ?></th>
		<td>
			<?php wp_nonce_field('adrotate_report_advertiser','adrotate_nonce'); ?>
	    	<input type="hidden" name="adrotate_export_id" value="<?php echo $current_user->ID; ?>" />
			<input type="hidden" name="adrotate_export_type" value="advertiser" />
	        <select name="adrotate_export_month" id="cat" class="postform">
		        <option value="0"><?php _e('Whole year', 'adrotate-pro'); ?></option>
		        <option value="1" <?php if($month == "1") { echo 'selected'; } ?>><?php _e('January', 'adrotate-pro'); ?></option>
		        <option value="2" <?php if($month == "2") { echo 'selected'; } ?>><?php _e('February', 'adrotate-pro'); ?></option>
		        <option value="3" <?php if($month == "3") { echo 'selected'; } ?>><?php _e('March', 'adrotate-pro'); ?></option>
		        <option value="4" <?php if($month == "4") { echo 'selected'; } ?>><?php _e('April', 'adrotate-pro'); ?></option>
		        <option value="5" <?php if($month == "5") { echo 'selected'; } ?>><?php _e('May', 'adrotate-pro'); ?></option>
		        <option value="6" <?php if($month == "6") { echo 'selected'; } ?>><?php _e('June', 'adrotate-pro'); ?></option>
		        <option value="7" <?php if($month == "7") { echo 'selected'; } ?>><?php _e('July', 'adrotate-pro'); ?></option>
		        <option value="8" <?php if($month == "8") { echo 'selected'; } ?>><?php _e('August', 'adrotate-pro'); ?></option>
		        <option value="9" <?php if($month == "9") { echo 'selected'; } ?>><?php _e('September', 'adrotate-pro'); ?></option>
		        <option value="10" <?php if($month == "10") { echo 'selected'; } ?>><?php _e('October', 'adrotate-pro'); ?></option>
		        <option value="11" <?php if($month == "11") { echo 'selected'; } ?>><?php _e('November', 'adrotate-pro'); ?></option>
		        <option value="12" <?php if($month == "12") { echo 'selected'; } ?>><?php _e('December', 'adrotate-pro'); ?></option>
			</select> 
			<input type="text" name="adrotate_export_year" size="10" class="search-input" value="<?php echo date('Y'); ?>" autocomplete="off" />
		</td>
	</tr>
    <tr>
		<th><?php _e('Email options', 'adrotate-pro'); ?></th>
		<td>
  			<input type="text" name="adrotate_export_addresses" size="45" class="search-input" value="" autocomplete="off" /> <em><?php _e('Maximum of 3 email addresses, comma seperated. Leave empty to download the CSV file instead.', 'adrotate-pro'); ?></em>
		</td>
	</tr>
    <tr>
		<th>&nbsp;</th>
		<td>
  			<input type="submit" name="adrotate_export_submit" class="button-primary" value="<?php _e('Export', 'adrotate-pro'); ?>" /> <em><?php _e('Download or email your selected timeframe as a CSV file.', 'adrotate-pro'); ?></em>
		</td>
	</tr>
	</tbody>

</table>
</form>