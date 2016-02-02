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
<h3><?php _e('Statistics', 'adrotate-pro'); ?></h3></td>
<span class="description"><?php _e('Track statistics for your adverts.', 'adrotate-pro'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('How to track stats', 'adrotate-pro'); ?></th>
		<td>
			<select name="adrotate_stats">
				<option value="0" <?php if($adrotate_config['stats'] == 0) { echo 'selected'; } ?>><?php _e('Disabled - Do not track stats', 'adrotate-pro'); ?></option>
				<option value="1" <?php if($adrotate_config['stats'] == 1) { echo 'selected'; } ?>>Internal Tracker (<?php _e('Default', 'adrotate-pro'); ?>)</option>
				<option value="2" <?php if($adrotate_config['stats'] == 2) { echo 'selected'; } ?>>Piwik Analytics (<?php _e('Advanced, Faster', 'adrotate-pro'); ?>)</option>
				<option value="3" <?php if($adrotate_config['stats'] == 3) { echo 'selected'; } ?>>Google Analytics (<?php _e('Faster', 'adrotate-pro'); ?>)</option>
			</select><br />
			<span class="description">
				<strong>Interal Tracker</strong> - <?php _e('Tracks impressions and clicks internally', 'adrotate-pro'); ?>, <a href="https://ajdg.solutions/manuals/adrotate-manuals/adrotate-statistics/?pk_campaign=adrotatepro_settings&pk_kwd=adrotate_statsmanual" target="_blank"><?php _e('manual', 'adrotate-pro'); ?></a>.<br />
				<strong><?php _e('Supports:', 'adrotate-pro'); ?></strong> <em><?php _e('Click and Impression recording, Click and impression limits, impression spread for schedules, local stats display. Javascript/HTML5/Flash adverts will only track impressions.', 'adrotate-pro'); ?></em><br /><br />
				<strong>Piwik Analytics</strong> - <?php _e('Requires Piwik Analytics tracker installed in your sites footer! Uses data attributes', 'adrotate-pro'); ?>, <a href="https://ajdg.solutions/manuals/adrotate-manuals/piwik-analytics/?pk_campaign=adrotatepro_settings&pk_kwd=adrotate_piwikmanual" target="_blank"><?php _e('manual', 'adrotate-pro'); ?></a>.<br />
				<strong><?php _e('Supports:', 'adrotate-pro'); ?></strong> <em><?php _e('Click and Impression recording via Cookie, stats are displayed in Actions > Contents.', 'adrotate-pro'); ?></em><br /><br />
				<strong>Google Analytics</strong> - <?php _e('Requires Google Universal Analytics tracker installed in your sites footer! uses onClick() and onload() in adverts', 'adrotate-pro'); ?>, <a href="https://ajdg.solutions/manuals/adrotate-manuals/google-analytics/?pk_campaign=adrotatepro_settings&pk_kwd=adrotate_googlemanual" target="_blank"><?php _e('manual', 'adrotate-pro'); ?></a>.<br />
				<strong><?php _e('Supports:', 'adrotate-pro'); ?></strong> <em><?php _e('Click and Impression recording via Cookie, stats are displayed in Events > Banner.', 'adrotate-pro'); ?></em>
			</span>
		</td>
	</tr>
</table>

<h3><?php _e('Internal Tracker', 'adrotate-pro'); ?></h3></td>
<span class="description"><?php _e('The settings below are for the internal tracker and have no effect when using Piwik/Google Analytics.', 'adrotate-pro'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Logged in impressions', 'adrotate-pro'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_enable_loggedin_impressions" <?php if($adrotate_config['enable_loggedin_impressions'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Track impressions from logged in users.', 'adrotate-pro'); ?>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Logged in clicks', 'adrotate-pro'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_enable_loggedin_clicks" <?php if($adrotate_config['enable_loggedin_clicks'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Track clicks from logged in users.', 'adrotate-pro'); ?>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Impression timer', 'adrotate-pro'); ?></th>
		<td>
			<input name="adrotate_impression_timer" type="text" class="search-input" size="5" value="<?php echo $adrotate_config['impression_timer']; ?>" autocomplete="off" /> <?php _e('Seconds.', 'adrotate-pro'); ?><br />
			<span class="description"><?php _e('Default: 60.', 'adrotate-pro'); ?> <?php _e('This number may not be empty, be lower than 10 or exceed 3600 (1 hour).', 'adrotate-pro'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Click timer', 'adrotate-pro'); ?></th>
		<td>
			<input name="adrotate_click_timer" type="text" class="search-input" size="5" value="<?php echo $adrotate_config['click_timer']; ?>" autocomplete="off" /> <?php _e('Seconds.', 'adrotate-pro'); ?><br />
			<span class="description"><?php _e('Default: 86400.', 'adrotate-pro'); ?> <?php _e('This number may not be empty, be lower than 60 or exceed 86400 (24 hours).', 'adrotate-pro'); ?></span>
		</td>
	</tr>
</table>
