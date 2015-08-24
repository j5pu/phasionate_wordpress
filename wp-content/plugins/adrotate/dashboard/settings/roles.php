<h3><?php _e('Roles', 'adrotate'); ?></h3>
<span class="description"><?php _e('Who has access to what?', 'adrotate'); ?></span>
<table class="form-table">
	<tr>
		<th valign="top"><?php _e('Manage/Add/Edit adverts', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_ad_manage"><select name="adrotate_ad_manage">
				<?php wp_dropdown_roles($adrotate_config['ad_manage']); ?>
			</select> <?php _e('Role to see and add/edit ads.', 'adrotate'); ?></label>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Delete/Reset adverts', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_ad_delete"><select name="adrotate_ad_delete">
				<?php wp_dropdown_roles($adrotate_config['ad_delete']); ?>
			</select> <?php _e('Role to delete ads and reset stats.', 'adrotate'); ?></label>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Manage/Add/Edit groups', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_group_manage"><select name="adrotate_group_manage">
				<?php wp_dropdown_roles($adrotate_config['group_manage']); ?>
			</select> <?php _e('Role to see and add/edit groups.', 'adrotate'); ?></label>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Delete groups', 'adrotate'); ?></th>
		<td>
			<label for="adrotate_group_delete"><select name="adrotate_group_delete">
				<?php wp_dropdown_roles($adrotate_config['group_delete']); ?>
			</select> <?php _e('Role to delete groups.', 'adrotate'); ?></label>
		</td>
	</tr>
</table>