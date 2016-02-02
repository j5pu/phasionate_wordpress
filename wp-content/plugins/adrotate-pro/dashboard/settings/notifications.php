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
<h3><?php _e('Notifications', 'adrotate-pro'); ?></h3>
<span class="description"><?php _e('Set up who gets notifications if ads need your attention.', 'adrotate-pro'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Delivery method', 'adrotate-pro'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_notification_email" <?php if($adrotate_notifications['notification_email'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Email message.', 'adrotate-pro'); ?><br />
			<input type="checkbox" name="adrotate_notification_push" <?php if($adrotate_notifications['notification_push'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Push notifications to your smartphone.', 'adrotate-pro'); ?><br />
			<span class="description"><?php _e('Push notifications are delivered through Pushover, a notification service for Android and iOS', 'adrotate-pro'); ?><br /><?php _e('The Pushover App is a one time purchase for either Android and/or iOS. More information can be found on the pushover website;', 'adrotate-pro'); ?> <a href="http://www.pushover.net" target="_blank">pushover.net</a>.</span>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><?php _e('Test notification', 'adrotate-pro'); ?></th>
		<td>
			<input type="submit" name="adrotate_notification_test_submit" class="button-secondary" value="<?php _e('Test', 'adrotate-pro'); ?>" /> <?php _e('This sends a test notification. Before you test, save the options first!', 'adrotate-pro'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Dashboard Notifications', 'adrotate-pro'); ?></h3>
<span class="description"><?php _e('These show to every administrator who can edit adverts.', 'adrotate-pro'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Notification banners', 'adrotate-pro'); ?></th>
		<td><label for="adrotate_notification_dashboard"><input type="checkbox" name="adrotate_notification_dashboard" <?php if($adrotate_notifications['notification_dashboard'] == 'N') { ?>checked="checked" <?php } ?> /> <?php _e('Disable dashboard notifications.', 'adrotate-pro'); ?></label></td>
	</tr>
</table>

<h3><?php _e('Email Notifications', 'adrotate-pro'); ?></h3>
<span class="description"><?php _e('Set up who gets notification emails.', 'adrotate-pro'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Publishers', 'adrotate-pro'); ?></th>
		<td>
			<textarea name="adrotate_notification_email_publisher" cols="50" rows="2"><?php echo $notification_mails; ?></textarea><br />
			<span class="description"><?php _e('A comma separated list of email addresses. Maximum of 5 addresses. Keep this list to a minimum!', 'adrotate-pro'); ?><br />
			<?php _e('Messages are sent once every 24 hours when needed. If this field is empty no email notifications will be send.', 'adrotate-pro'); ?></span>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Advertisers', 'adrotate-pro'); ?></th>
		<td>
			<textarea name="adrotate_notification_email_advertiser" cols="50" rows="2"><?php echo $advertiser_mails; ?></textarea><br />
			<span class="description"><?php _e('Who gets email from advertisers. Maximum of 2 addresses. Comma seperated. This field may not be empty!', 'adrotate-pro'); ?></span>
		</td>
	</tr>
</table>

<h3><?php _e('Push Notifications', 'adrotate-pro'); ?></h3>
<span class="description"><?php _e('Receive information about what is happening with your AdRotate setup on your smartphone via Pushover.', 'adrotate-pro'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Publishers', 'adrotate-pro'); ?></th>
		<td>
			<input type="checkbox" name="adrotate_notification_push_geo" <?php if($adrotate_notifications['notification_push_geo'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('When you are running out of Geo Targeting Lookups.', 'adrotate-pro'); ?><br /><br />
			<input type="checkbox" name="adrotate_notification_push_status" <?php if($adrotate_notifications['notification_push_status'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Daily digest of any advert status other than normal.', 'adrotate-pro'); ?><br />
			<input type="checkbox" name="adrotate_notification_push_queue" <?php if($adrotate_notifications['notification_push_queue'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Any advertiser saving an advert in your moderation queue.', 'adrotate-pro'); ?><br />
			<input type="checkbox" name="adrotate_notification_push_approved" <?php if($adrotate_notifications['notification_push_approved'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('A moderator approved an advert from the moderation queue.', 'adrotate-pro'); ?><br />
			<input type="checkbox" name="adrotate_notification_push_rejected" <?php if($adrotate_notifications['notification_push_rejected'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('A moderator rejected an advert from the moderation queue.', 'adrotate-pro'); ?><br /><span class="description"><?php _e('If you have a lot of activity with many advertisers adding/changing adverts you may get a lot of messages!', 'adrotate-pro'); ?></span>

		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('User Key', 'adrotate-pro'); ?></th>
		<td>
			<label for="adrotate_notification_push_user"><input name="adrotate_notification_push_user" type="text" class="search-input" size="50" value="<?php  echo $adrotate_notifications['notification_push_user']; ?>" autocomplete="off" /> <?php _e('Get your user token', 'adrotate-pro'); ?> <a href="https://pushover.net" target="_blank"><?php _e('here', 'adrotate-pro'); ?></a>.</label>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Api Token', 'adrotate-pro'); ?></th>
		<td>
			<label for="adrotate_notification_push_api"><input name="adrotate_notification_push_api" type="text" class="search-input" size="50" value="<?php  echo $adrotate_notifications['notification_push_api']; ?>" autocomplete="off" /> <?php _e('Create your', 'adrotate-pro'); ?> <a href="https://pushover.net/apps/build" target="_blank"><?php _e('App', 'adrotate-pro'); ?></a> <?php _e('and get your API token', 'adrotate-pro'); ?> <a href="https://pushover.net/apps" target="_blank"><?php _e('here', 'adrotate-pro'); ?></a>.</label>
		</td>
	</tr>
</table>