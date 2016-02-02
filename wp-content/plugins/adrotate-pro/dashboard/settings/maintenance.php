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
<h3><?php _e('Maintenance', 'adrotate-pro'); ?></h3>
<span class="description"><?php _e('Use these functions when you notice your database is slow, unresponsive and sluggish.', 'adrotate-pro'); ?></span>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Optimize Database', 'adrotate-pro'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_db_optimize_submit" value="<?php _e('Optimize Database', 'adrotate-pro'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to optimize the AdRotate database.', 'adrotate-pro'); ?>\n\n<?php _e('Did you make a backup of your database?', 'adrotate-pro'); ?>\n\n<?php _e('This may take a moment and may cause your website to respond slow temporarily!', 'adrotate-pro'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate-pro'); ?>')" /><br />
			<span class="description"><?php _e('Cleans up overhead data in the AdRotate tables.', 'adrotate-pro'); ?><br />
			<?php _e('Overhead data is accumulated garbage resulting from changes you\'ve made. This can vary from nothing to several hundred kilobytes of data.', 'adrotate-pro'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Clean-up Database', 'adrotate-pro'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_db_cleanup_submit" value="<?php _e('Clean-up Database', 'adrotate-pro'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to clean up your database. This may delete expired schedules and older statistics.', 'adrotate-pro'); ?>\n\n<?php _e('Are you sure you want to continue?', 'adrotate-pro'); ?>\n\n<?php _e('This might take a while and may slow down your site during this action!', 'adrotate-pro'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate-pro'); ?>')" /><br />
			<label for="adrotate_db_cleanup_schedules"><input type="checkbox" name="adrotate_db_cleanup_schedules" value="1" /> <?php _e('Delete expired schedules.', 'adrotate-pro'); ?></label><br />
			<label for="adrotate_db_cleanup_statistics"><input type="checkbox" name="adrotate_db_cleanup_statistics" value="1" /> <?php _e('Delete stats older than 356 days.', 'adrotate-pro'); ?></label><br />
			<span class="description"><?php _e('AdRotate creates empty records when you start making ads, groups or schedules. In rare occasions these records are faulty.', 'adrotate-pro'); ?><br /><?php _e('If you made an ad, group or schedule that does not save when you make it use this button to delete those empty records.', 'adrotate-pro'); ?><br /><?php _e('Additionally you can clean up old schedules and/or statistics. This will improve the speed of your site.', 'adrotate-pro'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Re-evaluate Ads', 'adrotate-pro'); ?></th>
		<td>
			<input type="submit" id="post-role-submit" name="adrotate_evaluate_submit" value="<?php _e('Re-evaluate all ads', 'adrotate-pro'); ?>" class="button-secondary" onclick="return confirm('<?php _e('You are about to check all ads for errors.', 'adrotate-pro'); ?>\n\n<?php _e('This might take a while and may slow down your site during this action!', 'adrotate-pro'); ?>\n\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate-pro'); ?>')" /><br />
			<span class="description"><?php _e('This will apply all evaluation rules to all ads to see if any error slipped in. Normally you should not need this feature.', 'adrotate-pro'); ?></span>
		</td>
	</tr>
</table>
<span class="description"><?php _e('DISCLAIMER: The above functions are intented to be used to OPTIMIZE your database. They only apply to your ads/groups and stats. Not to other settings or other parts of WordPress! Always always make a backup! If for any reason your data is lost, damaged or otherwise becomes unusable in any way or by any means in whichever way I will not take responsibility. You should always have a backup of your database. These functions do NOT destroy data. If data is lost, damaged or unusable in any way, your database likely was beyond repair already. Claiming it worked before clicking these buttons is not a valid point in any case.', 'adrotate-pro'); ?></span>

<h3><?php _e('Troubleshooting', 'adrotate-pro'); ?></h3>
<span class="description"><?php _e('The below options are not meant for normal use and are only there for developers to review saved settings or how ads are selected. These can be used as a measure of troubleshooting upon request but for normal use they SHOULD BE LEFT UNCHECKED!!', 'adrotate-pro'); ?></span>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Developer Debug', 'adrotate-pro'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_debug" <?php if($adrotate_debug['general'] == true) { ?>checked="checked" <?php } ?> /> General - <span class="description"><?php _e('Troubleshoot ads and how they are selected. Visible on the front-end.', 'adrotate-pro'); ?></span><br />
			<input type="checkbox" name="adrotate_debug_publisher" <?php if($adrotate_debug['publisher'] == true) { ?>checked="checked" <?php } ?> /> Publishers - <span class="description"><?php _e('View advert specs and (some) stats in the dashboard. Visible only to publishers.', 'adrotate-pro'); ?></span><br />
			<input type="checkbox" name="adrotate_debug_advertiser" <?php if($adrotate_debug['advertiser'] == true) { ?>checked="checked" <?php } ?> /> Advertisers - <span class="description"><?php _e('View advert specs on the moderator queue. Output stats summary for Advertisers!', 'adrotate-pro'); ?></span><br />
			<input type="checkbox" name="adrotate_debug_geo" <?php if($adrotate_debug['geo'] == true) { ?>checked="checked" <?php } ?> /> Geo Targeting - <span class="description"><?php _e('View Geo Targeting data on the Geo Targeting tab here in settings. Also has Geo Data output on the front-end.', 'adrotate-pro'); ?></span><br />
			<input type="checkbox" name="adrotate_debug_timers" <?php if($adrotate_debug['timers'] == true) { ?>checked="checked" <?php } ?> /> Clicktracking - <span class="description"><?php _e('Disable timers for clicks and impressions and enable a alert window for clicktracking. AdRotate Internal Tracker only.', 'adrotate-pro'); ?></span><br />
			<input type="checkbox" name="adrotate_debug_track" <?php if($adrotate_debug['track'] == true) { ?>checked="checked" <?php } ?> /> Tracking Encryption - <span class="description"><?php _e('Temporarily disable encryption on the redirect url. AdRotate Internal Tracker only.', 'adrotate-pro'); ?></span><br />
		</td>
	</tr>
</table>

<h3><?php _e('Status and Versions', 'adrotate-pro'); ?></h3>
<table class="form-table">			
	<tr>
		<td><?php _e('Current version:', 'adrotate-pro'); ?> <?php echo $adrotate_version['current']; ?> <?php if($adrotate_version['current'] != ADROTATE_VERSION) { _e('Should be:', 'adrotate-pro'); echo ' '.ADROTATE_VERSION; } ?></td>
		<td><?php _e('Previous version:', 'adrotate-pro'); ?> <?php echo $adrotate_version['previous']; ?></td>
	</tr>
	<tr>
		<td><?php _e('Current database version:', 'adrotate-pro'); ?> <?php echo $adrotate_db_version['current']; ?>  <?php if($adrotate_version['current'] != ADROTATE_VERSION) { _e('Should be:', 'adrotate-pro'); echo ' '.ADROTATE_DB_VERSION; } ?></td>
		<td><?php _e('Previous database version:', 'adrotate-pro'); ?> <?php echo $adrotate_db_version['previous']; ?></td>
	</tr>
	<tr>
		<td valign="top"><?php _e('Current status of adverts', 'adrotate-pro'); ?></td>
		<td><?php _e('Normal', 'adrotate-pro'); ?>: <?php echo $adrotate_advert_status['normal']; ?>, <?php _e('Error', 'adrotate-pro'); ?>: <?php echo $adrotate_advert_status['error']; ?>, <?php _e('Expired', 'adrotate-pro'); ?>: <?php echo $adrotate_advert_status['expired']; ?>, <?php _e('Expires Soon', 'adrotate-pro'); ?>: <?php echo $adrotate_advert_status['expiressoon']; ?>, <?php _e('Unknown', 'adrotate-pro'); ?>: <?php echo $adrotate_advert_status['unknown']; ?>.</td>
	</tr>
	<tr>
		<td><?php _e('Banners/assets Folder', 'adrotate-pro'); ?></td>
		<td>
			<?php echo (is_writable(ABSPATH.$adrotate_config['banner_folder'])) ? '<span style="color:#009900;">'.__('Exists and appears writable', 'adrotate-pro').'</span>' : '<span style="color:#CC2900;">'.__('Not writable or does not exist', 'adrotate-pro').'</span>'; ?>
		</td>
	</tr>
	<tr>
		<td><?php _e('Reports Folder', 'adrotate-pro'); ?></td>
		<td>
			<?php echo (is_writable(ABSPATH.'wp-content/reports/')) ? '<span style="color:#009900;">'.__('Exists and appears writable', 'adrotate-pro').'</span>' : '<span style="color:#CC2900;">'.__('Not writable or does not exist', 'adrotate-pro').'</span>'; ?>
		</td>
	</tr>
	<tr>
		<td><?php _e('Ad evaluation next run:', 'adrotate-pro'); ?></td>
		<td><?php if(!$adevaluate) '<span style="color:#CC2900;">'._e('Not scheduled!', 'adrotate-pro').'</span>'; else echo '<span style="color:#009900;">'.date_i18n(get_option('date_format')." H:i", $adevaluate).'</span>'; ?></td>
	</tr>
	<tr>
		<td><?php _e('Ad Notifications next run:', 'adrotate-pro'); ?></td>
		<td><?php if(!$adschedule) '<span style="color:#CC2900;">'._e('Not scheduled!', 'adrotate-pro').'</span>'; else echo '<span style="color:#009900;">'.date_i18n(get_option('date_format')." H:i", $adschedule).'</span>'; ?></td>
	</tr>
	<tr>
		<td><?php _e('Clean Trackerdata next run:', 'adrotate-pro'); ?></td>
		<td><?php if(!$adtracker) '<span style="color:#CC2900;">'._e('Not scheduled!', 'adrotate-pro').'</span>'; else echo '<span style="color:#009900;">'.date_i18n(get_option('date_format')." H:i", $adtracker).'</span>'; ?></td>
	</tr>
</table>
