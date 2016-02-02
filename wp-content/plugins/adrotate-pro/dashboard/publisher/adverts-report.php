<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2015 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

$banner = $wpdb->get_row("SELECT `title`, `tracker` FROM `".$wpdb->prefix."adrotate` WHERE `id` = '$ad_edit_id';");

$stats = adrotate_stats($ad_edit_id);
$stats_today = adrotate_stats($ad_edit_id, $today);
//$stats_last_month = adrotate_stats($ad_edit_id, mktime(0, 0, 0, date("m")-1, 1, date("Y")), mktime(0, 0, 0, date("m")-1, date("t"), date("Y")));
$stats_last_month = adrotate_stats($ad_edit_id, mktime(0, 0, 0, date("m")-1, 1, date("Y")), mktime(0, 0, 0, date("m"), 0, date("Y")));
$stats_this_month = adrotate_stats($ad_edit_id, mktime(0, 0, 0, date("m"), 1, date("Y")), mktime(0, 0, 0, date("m"), date("t"), date("Y")));

// Get Click Through Rate
$ctr = adrotate_ctr($stats['clicks'], $stats['impressions']);
$ctr_this_month = adrotate_ctr($stats_this_month['clicks'], $stats_this_month['impressions']);

if($adrotate_debug['publisher'] == true) {
	echo "<p><strong>[DEBUG] Ad Stats (all time)</strong><pre>";
	print_r($stats); 
	echo "</pre></p>"; 
	echo "<p><strong>[DEBUG] Ad Stats (today)</strong><pre>";
	print_r($stats_today); 
	echo "</pre></p>"; 
}	

?>
<h3><?php _e('Statistics for advert', 'adrotate-pro'); ?> '<?php echo $banner->title; ?>'</h3>
<table class="widefat" style="margin-top: .5em">

	<tbody>
  	<tr>
        <td width="20%"><div class="stats_large"><?php _e('Impressions', 'adrotate-pro'); ?><br /><div class="number_large"><?php echo $stats['impressions']; ?></div></div></td>
        <td width="20%"><div class="stats_large"><?php _e('Clicks', 'adrotate-pro'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $stats['clicks']; } else { echo '--'; } ?></div></div></td>
        <td><div class="stats_large"><?php _e('Impressions today', 'adrotate-pro'); ?><br /><div class="number_large"><?php echo $stats_today['impressions']; ?></div></div></td>
        <td width="20%"><div class="stats_large"><?php _e('Clicks today', 'adrotate-pro'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $stats_today['clicks']; } else { echo '--'; } ?></div></div></td>
        <td width="20%"><div class="stats_large"><?php _e('CTR', 'adrotate-pro'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $ctr.' %'; } else { echo '--'; } ?></div></div></td>
  	</tr>
  	<tr>
        <td width="20%"><div class="stats_large"><?php _e('Impressions last month', 'adrotate-pro'); ?><br /><div class="number_large"><?php echo $stats_last_month['impressions']; ?></div></div></td>
        <td width="20%"><div class="stats_large"><?php _e('Clicks last month', 'adrotate-pro'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $stats_last_month['clicks']; } else { echo '--'; } ?></div></div></td>
        <td><div class="stats_large"><?php _e('Impressions this month', 'adrotate-pro'); ?><br /><div class="number_large"><?php echo $stats_this_month['impressions']; ?></div></div></td>
        <td width="20%"><div class="stats_large"><?php _e('Clicks this month', 'adrotate-pro'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $stats_this_month['clicks']; } else { echo '--'; } ?></div></div></td>
        <td width="20%"><div class="stats_large"><?php _e('CTR', 'adrotate-pro'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $ctr_this_month.' %'; } else { echo '--'; } ?></div></div></td>
  	</tr>
	<tbody>

</table>

<h3><?php _e('Monthly overview of clicks and impressions', 'adrotate-pro'); ?></h3>
<form method="post" action="admin.php?page=adrotate-ads&view=report&ad=<?php echo $ad_edit_id; ?>">
<table class="widefat" style="margin-top: .5em">
	<tbody>
  	<tr>
        <th colspan="5">
        	<div style="text-align:center;"><?php echo adrotate_stats_nav('ads', $ad_edit_id, $month, $year); ?></div>
        	<?php 
				echo adrotate_stats_graph('ads', $ad_edit_id, 1, $monthstart, $monthend); 
			?>
        </th>
  	</tr>
	</tbody>

</table>	
</form>


<form method="post" action="admin.php?page=adrotate-ads">
<h3><?php _e('Export options', 'adrotate-pro'); ?></h3>
<table class="widefat" style="margin-top: .5em">

	<tbody>
    <tr>
		<th width="10%"><?php _e('Select period', 'adrotate-pro'); ?></th>
		<td width="40%" colspan="4">
			<?php wp_nonce_field('adrotate_report_ads','adrotate_nonce'); ?>
	    	<input type="hidden" name="adrotate_export_id" value="<?php echo $ad_edit_id; ?>" />
			<input type="hidden" name="adrotate_export_type" value="single" />
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
		<th width="10%"><?php _e('Email options', 'adrotate-pro'); ?></th>
		<td width="40%" colspan="4">
  			<input type="text" name="adrotate_export_addresses" size="45" class="search-input" value="" autocomplete="off" /> <em><?php _e('Maximum of 3 email addresses, comma seperated. Leave empty to download the CSV file instead.', 'adrotate-pro'); ?></em>
		</td>
	</tr>
    <tr>
		<th width="10%">&nbsp;</th>
		<td width="40%" colspan="4">
  			<input type="submit" name="adrotate_export_submit" class="button-primary" value="<?php _e('Export', 'adrotate-pro'); ?>" /> <em><?php _e('Download or email your selected timeframe as a CSV file.', 'adrotate-pro'); ?></em>
		</td>
	</tr>
	</tbody>

</table>
</form>
<p><em><strong><?php _e('Note:', 'adrotate-pro'); ?></strong> <?php _e('All statistics are indicative. They do not nessesarily reflect results counted by other parties.', 'adrotate-pro'); ?></em></p>