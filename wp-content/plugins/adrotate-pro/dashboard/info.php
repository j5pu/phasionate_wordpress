<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2015 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

$banners = $groups = $schedules = $queued = 0;
$banners = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` != 'empty' AND `type` != 'a_empty';");
$groups = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_groups` WHERE `name` != '';");
$schedules = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate_schedule` WHERE `name` != '';");
$queued = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}adrotate` WHERE `type` = 'queue';");
$data = get_option("adrotate_advert_status");

if($status > 0) adrotate_status($status, array('ticket' => $ticketid));
?>

<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">

		<div id="postbox-container-1" class="postbox-container" style="width:50%;">
			<div id="normal-sortables" class="meta-box-sortables ui-sortable">
				
				<h3><?php _e('Currently', 'adrotate-pro'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
						<table width="100%">
							<thead>
							<tr class="first">
								<td width="50%"><strong><?php _e('Your setup', 'adrotate-pro'); ?></strong></td>
								<td width="50%"><strong><?php _e('Adverts that need you', 'adrotate-pro'); ?></strong></td>
							</tr>
							</thead>
							
							<tbody>
							<tr class="first">
								<td class="first b"><a href="admin.php?page=adrotate-ads"><?php echo $banners; ?> <?php _e('Adverts', 'adrotate-pro'); ?></a></td>
								<td class="b"><a href="admin.php?page=adrotate-ads"><?php echo $data['expiressoon']; ?> <?php _e('(Almost) Expired', 'adrotate-pro'); ?></a></td>
							</tr>
							<tr>
								<td class="first b"><a href="admin.php?page=adrotate-groups"><?php echo $groups; ?> <?php _e('Groups', 'adrotate-pro'); ?></a></td>
								<td class="b"><a href="admin.php?page=adrotate-ads"><?php echo $data['error']; ?> <?php _e('Have errors', 'adrotate-pro'); ?></a></td>
							</tr>
							<tr>
								<td class="first b"><a href="admin.php?page=adrotate-schedules"><?php echo $schedules; ?> <?php _e('Schedules', 'adrotate-pro'); ?></a></td>
								<td class="b"><a href="admin.php?page=adrotate-moderate"><?php echo $queued; ?> <?php _e('Queued', 'adrotate-pro'); ?></a></td>
							</tr>
							</tbody>

							<thead>
							<tr class="first">
								<td colspan="2"><strong><?php _e('Support AdRotate', 'adrotate-pro'); ?></strong></td>
							</tr>
							</thead>

							<tbody>
							<tr class="first">
								<td colspan="2">
									<center><?php _e('Consider writing a review if you like AdRotate. Also follow my Facebook page for updates about me and my plugins. Thank you!', 'adrotate-pro'); ?><br /><br />
									<a class="button-secondary" target="_blank" href="https://wordpress.org/support/view/plugin-reviews/adrotate?rate=5#postform">Write review on WordPress.org</a></center><br />
									<script>(function(d, s, id) {
									  var js, fjs = d.getElementsByTagName(s)[0];
									  if (d.getElementById(id)) return;
									  js = d.createElement(s); js.id = id;
									  js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
									  fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
									<p><center><div class="fb-page" 
										data-href="https://www.facebook.com/Arnandegans" 
										data-width="490" 
										data-adapt-container-width="true" 
										data-hide-cover="false" 
										data-show-facepile="false">
									</div></center></p>
								</td>
							</tr>

							</tbody>
						</table>
					</div>
				</div>

				<h3><?php _e('Premium Support', 'adrotate-pro'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
					<?php if($a['status'] == 1) { ?>					
						<form name="request" id="post" method="post" action="admin.php?page=adrotate">
							<?php wp_nonce_field('ajdg_nonce_support_request','ajdg_nonce_support'); ?>
						
							<p><img src="<?php echo WP_CONTENT_URL; ?>/plugins/adrotate-pro/images/icon-support.png" class="alignleft pro-image" />&raquo; <?php _e('What went wrong? (if anything) or what are you trying to do?', 'adrotate-pro'); ?><br />&raquo; <?php _e('Include error messages and/or relevant information.', 'adrotate-pro'); ?><br />&raquo; <?php _e('Try to remember steps or actions you took that might have caused the problem.', 'adrotate-pro'); ?></p>
							
							<p class="red"><?php _e('Please do not double post! Sending multiple messages with the same question will put you at the very end of my support priorities.', 'adrotate-pro'); ?></p>
						
							<p><label for="ajdg_support_username"><strong><?php _e('Your name:', 'adrotate-pro'); ?></strong><br /><input tabindex="1" name="ajdg_support_username" type="text" class="search-input" style="width:100%;" value="<?php echo $firstname." ".$lastname;?>" autocomplete="off" /></label></p>
							<p><label for="ajdg_support_email"><strong><?php _e('Your Email Address:', 'adrotate-pro'); ?></strong><br /><input tabindex="1" name="ajdg_support_email" type="text" class="search-input" style="width:100%;" value="<?php echo $user->user_email;?>" autocomplete="off" /></label></p>
							<p><label for="ajdg_support_subject"><strong><?php _e('Subject:', 'adrotate-pro'); ?></strong><br /><input tabindex="2" name="ajdg_support_subject" type="text" class="search-input" style="width:100%;" value="" autocomplete="off" /></label></p>
							<p><label for="ajdg_support_message"><strong><?php _e('Problem description / Question:', 'adrotate-pro'); ?></strong><br /><textarea tabindex="3" name="ajdg_support_message" style="width:100%; height:100px;"></textarea></label></p>
						
							<p><strong><?php _e('When you send this form the following data will be submitted:', 'adrotate-pro'); ?></strong></p>
							<p><em><?php _e('Your name, Account email address, Your website url and some basic WordPress information will be included with the ticket.', 'adrotate-pro'); ?><br /><?php _e('This information is treated as confidential and is mandatory.', 'adrotate-pro'); ?></em></p>
						
							<p class="submit">
								<input tabindex="4" type="submit" name="adrotate_support_submit" class="button-primary" value="<?php _e('Send Email', 'adrotate-pro'); ?>" />&nbsp;&nbsp;&nbsp;<em><?php _e('Please use english or dutch only!', 'adrotate-pro'); ?></em>
							</p>
						
						</form>
			
					<?php } else { ?>
						<p><img src="<?php echo WP_CONTENT_URL; ?>/plugins/adrotate-pro/images/icon-support.png" class="alignleft pro-image" /><?php _e('When you activate your AdRotate Pro license you can use fast and personal email support. No more queueing up in the forums. Email support is get priority over the forums and is checked 5 days per week.', 'adrotate-pro'); ?></p>

						<p class="submit">
							<?php if(adrotate_is_networked()) { ?>
								<a href="<?php echo network_admin_url('admin.php?page=adrotate'); ?>" class="button-primary"><?php _e('Activate License', 'adrotate-pro'); ?></a>
							<?php } else { ?>
								<a href="<?php echo admin_url('admin.php?page=adrotate-settings'); ?>" class="button-primary"><?php _e('Activate License', 'adrotate-pro'); ?></a>	
							<?php } ?>
							<em><?php _e('Contact your site administrator if you do not know what this means.', 'adrotate-pro'); ?></em>
						</p>
					<?php }	?>

					</div>
				</div>

			</div>
		</div>

		<div id="postbox-container-3" class="postbox-container" style="width:50%;">
			<div id="side-sortables" class="meta-box-sortables ui-sortable">
						
				<h3><?php _e('AdRotate News and Developer Blog', 'adrotate-pro'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
						<?php 
							wp_widget_rss_output(array(
							'url' => array('http://meandmymac.net/feed/', 'http://ajdg.solutions/feed/'), 
							'title' => 'News', 
							'items' => 6, 
							'show_summary' => 1, 
							'show_author' => 0, 
							'show_date' => 1)
							);
						?>
					</div>
				</div>

				<h3><?php _e('AdRotate is brought to you by', 'adrotate-pro'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
						<p><img src="<?php echo WP_CONTENT_URL; ?>/plugins/adrotate-pro/images/arnan-jungle.jpg" alt="Arnan de Gans" width="100" height="100" align="left" class="adrotate-photo" style="margin: 0 10px 0 0;" />
						 <a href="http://meandmymac.net/?pk_campaign=adrotatepro-infopage" title="Arnan de Gans">Arnan de Gans</a> (<a href="https://ajdg.solutions/?pk_campaign=adrotatepro-infopage" title="Arnan de Gans">AJdG Solutions</a>) - <?php _e('Premium plugins, support and services for WordPress and WooCommerce! I am a digital nomad in the Philippines. Click on my name to find out more about me and what I am doing. Thanks for your support and for using my plugins!', 'adrotate-pro'); ?></p>
					</div>
				</div>

			</div>	
		</div>

	</div>

	<div class="clear"></div>
	<p><?php echo adrotate_trademark(); ?></p>
</div>