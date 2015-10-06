<?php
include 'bps-form.php';
include 'bps-search.php';

function bps_help ()
{
    $screen = get_current_screen ();

	$title_00 = __('Overview', 'bp-profile-search');
	$content_00 = '
<p>'.
__('Configure your profile search form, then display it:', 'bp-profile-search'). '
<ul>
<li>'. sprintf (__('In its Members Directory page, selecting the option %s', 'bp-profile-search'), '<em>'. __('Add to Directory', 'bp-profile-search'). '</em>'). '</li>
<li>'. sprintf (__('In a sidebar or widget area, using the widget %s', 'bp-profile-search'), '<em>'. __('Profile Search', 'bp-profile-search'). '</em>'). '</li>
<li>'. sprintf (__('In a post or page, using the shortcode %s (*)', 'bp-profile-search'), '<strong>[bps_display form=id template=tpl]</strong>'). '</li>
<li>'. sprintf (__('Anywhere in your theme, using the PHP code %s (*)', 'bp-profile-search'), "<strong>&lt;?php do_action ('bps_display_form', id, tpl); ?&gt;</strong>"). '</li>
</ul>'.
__('(*) Replace <em>id</em> with your actual form ID, and <em>tpl</em> with the name of the form template you want to use.', 'bp-profile-search'). '
</p>';

	$title_01 = __('Form Fields', 'bp-profile-search');
	$content_01 = '
<p>'.
__('Select the profile fields to show in your search form.', 'bp-profile-search'). '
<ul>
<li>'. __('Customize the field label and description, or leave them empty to use the default', 'bp-profile-search'). '</li>
<li>'. __('Tick <em>Range</em> to enable the <em>Value Range Search</em> for numeric fields, or the <em>Age Range Search</em> for date fields', 'bp-profile-search'). '</li>
<li>'. __('To reorder the fields in the form, drag them up or down by the handle on the left', 'bp-profile-search'). '</li>
<li>'. __('To remove a field from the form, click the [x] on the right', 'bp-profile-search'). '</li>
</ul>'.
__('Please note:', 'bp-profile-search'). '
<ul>
<li>'. __('To leave a field description blank, enter a single dash (-) character', 'bp-profile-search'). '</li>
<li>'. __('The <em>Age Range Search</em> option is mandatory for date fields', 'bp-profile-search'). '</li>
<li>'. __('The <em>Value Range Search</em> works for numeric fields only', 'bp-profile-search'). '</li>
<li>'. __('The <em>Value Range Search</em> is not supported for <em>Multi Select Box</em> and <em>Checkboxes</em> fields', 'bp-profile-search'). '</li>
</ul>
</p>';

	$title_02 = __('Add to Directory', 'bp-profile-search');
	$content_02 = '
<p>'.
__('Insert your search form in its Members Directory page.', 'bp-profile-search'). '
<ul>
<li>'. __('Select the form template to use', 'bp-profile-search'). '</li>
<li>'. __('Specify the optional form header', 'bp-profile-search'). '</li>
<li>'. __('Enable the <em>Toggle Form</em> feature', 'bp-profile-search'). '</li>
<li>'. __('Enter the text for the <em>Toggle Form</em> button', 'bp-profile-search'). '</li>
</ul>'.
__('If you select <em>Add to Directory: No</em>, the above options are ignored.', 'bp-profile-search'). '
</p>';

	$title_03 = __('Form Attributes', 'bp-profile-search');
	$content_03 = '
<p>'.
__('Select your form’s <em>method</em> attribute.', 'bp-profile-search'). '
<ul>
<li>'. __('POST: the form data are not visible in the URL and it’s not possible to bookmark the results page', 'bp-profile-search'). '</li>
<li>'. __('GET: the form data are sent as URL variables and it’s possible to bookmark the results page', 'bp-profile-search'). '</li>
</ul>'.
__('Select your form’s <em>action</em> attribute. The <em>action</em> attribute points to your form’s results page, that could be:', 'bp-profile-search'). '
<ul>
<li>'. __('The BuddyPress Members Directory page', 'bp-profile-search'). '</li>
<li>'. __('A custom Members Directory page', 'bp-profile-search'). '</li>
</ul>'.
sprintf (__('You can create a custom Members Directory page using the shortcode %s, and you can even use a custom directory template.', 'bp-profile-search'), '<strong>[bps_directory]</strong>'). ' '.
__('To learn more, read the <a href="http://dontdream.it/bp-profile-search/custom-directories/" target="_blank">Custom Directories</a> tutorial.', 'bp-profile-search'). '
</p>';

	$title_04 = __('Text Search Mode', 'bp-profile-search');
	$content_04 = '
<p>'.
__('Select your text search mode.', 'bp-profile-search'). '
<ul>
<li>'. __('LIKE: a search for <em>John</em> finds <em>John</em>, <em>Johnson</em>, <em>Long John Silver</em>, and so on', 'bp-profile-search'). '</li>
<li>'. __('SAME: a search for <em>John</em> finds <em>John</em> only', 'bp-profile-search'). '</li>
</ul>'.
__('In both modes, two wildcard characters are available:', 'bp-profile-search'). '
<ul>
<li>'. __('Percent sign (%): matches any text, or no text at all', 'bp-profile-search'). '</li>
<li>'. __('Underscore (_): matches any single character', 'bp-profile-search'). '</li>
</ul>
</p>';

	$sidebar = '
<p><strong>'. __('For more information:', 'bp-profile-search'). '</strong></p>
<p><a href="http://dontdream.it/bp-profile-search/" target="_blank">'. __('Documentation', 'bp-profile-search'). '</a></p>
<p><a href="http://dontdream.it/bp-profile-search/questions-and-answers/" target="_blank">'. __('Questions and Answers', 'bp-profile-search'). '</a></p>
<p><a href="http://dontdream.it/bp-profile-search/incompatible-plugins/" target="_blank">'. __('Incompatible plugins', 'bp-profile-search'). '</a></p>
<p><a href="http://dontdream.it/support/forum/bp-profile-search-forum/" target="_blank">'. __('Support Forum', 'bp-profile-search'). '</a></p>
<br><br>';

	$screen->add_help_tab (array ('id' => 'bps_00', 'title' => $title_00, 'content' => $content_00));
	$screen->add_help_tab (array ('id' => 'bps_01', 'title' => $title_01, 'content' => $content_01));
	$screen->add_help_tab (array ('id' => 'bps_03', 'title' => $title_03, 'content' => $content_03));
	$screen->add_help_tab (array ('id' => 'bps_02', 'title' => $title_02, 'content' => $content_02));
	$screen->add_help_tab (array ('id' => 'bps_04', 'title' => $title_04, 'content' => $content_04));

	$screen->set_help_sidebar ($sidebar);

	return true;
}

function bps_admin_js ()
{
	$translations = array (
		'field' => __('field', 'bp-profile-search'),
		'label' => __('label', 'bp-profile-search'),
		'description' => __('description', 'bp-profile-search'),
		'range' => __('Range', 'bp-profile-search'),
	);
	wp_enqueue_script ('bps-admin', plugins_url ('bps-admin.js', __FILE__), array ('jquery-ui-sortable'), BPS_VERSION);
	wp_localize_script ('bps-admin', 'bps_strings', $translations);
}

function bps_update_meta ()
{
	$bps_options = array ();

	list ($x, $fields) = bps_get_fields ();

	$bps_options['field_name'] = array ();
	$bps_options['field_label'] = array ();
	$bps_options['field_desc'] = array ();
	$bps_options['field_range'] = array ();

	$j = 0;
	$posted = isset ($_POST['bps_options'])? $_POST['bps_options']: array ();
	if (isset ($posted['field_name']))  foreach ($posted['field_name'] as $k => $id)
	{
		if (empty ($fields[$id]))  continue;

		$field = $fields[$id];
		$field_type = $field->type;
		$field_type = apply_filters ('bps_field_validation_type', $field_type, $field);
		$field_type = apply_filters ('bps_field_type_for_validation', $field_type, $field);
		$label = stripslashes ($posted['field_label'][$k]);
		$desc = stripslashes ($posted['field_desc'][$k]);

		$bps_options['field_name'][$j] = $id;
		$bps_options['field_label'][$j] = $l = $label;
		$bps_options['field_desc'][$j] = $d = $desc;
		$bps_options['field_range'][$j] = $r = isset ($posted['field_range'][$k]);

		if (bps_custom_field ($field_type))
		{
			list ($l, $d, $r) = apply_filters ('bps_field_validation', array ($l, $d, $r), $field);
			$bps_options['field_label'][$j] = $l;
			$bps_options['field_desc'][$j] = $d;
			$bps_options['field_range'][$j] = $r;
		}
		else
		{
			if ($field_type == 'datebox')  $bps_options['field_range'][$j] = true;
			if ($field_type == 'checkbox' || $field_type == 'multiselectbox')  $bps_options['field_range'][$j] = false;
		}

		if ($bps_options['field_range'][$j] == false)  $bps_options['field_range'][$j] = null;
		$j = $j + 1;
	}

	return $bps_options;
}

function bps_fields_box ($post)
{
	$bps_options = bps_meta ($post->ID);

	list ($groups, $fields) = bps_get_fields ();
	echo '<script>var bps_groups = ['. json_encode ($groups). '];</script>';
?>

	<div id="field_box" class="field_box">
<?php

	foreach ($bps_options['field_name'] as $k => $id)
	{
		if (empty ($fields[$id]))  continue;

		$field = $fields[$id];
		$label = esc_attr ($bps_options['field_label'][$k]);
		$default = esc_attr ($field->name);
		$showlabel = empty ($label)? "placeholder=\"$default\"": "value=\"$label\"";
		$desc = esc_attr ($bps_options['field_desc'][$k]);
		$default = esc_attr ($field->description);
		$showdesc = empty ($desc)? "placeholder=\"$default\"": "value=\"$desc\"";
?>

		<p id="field_div<?php echo $k; ?>" class="sortable">
			<span>&nbsp;&Xi; </span>
<?php
			bps_field_select ("bps_options[field_name][$k]", "field_name$k", $id);
?>
			<input type="text" name="bps_options[field_label][<?php echo $k; ?>]" id="field_label<?php echo $k; ?>" <?php echo $showlabel; ?> style="width: 16%" />
			<input type="text" name="bps_options[field_desc][<?php echo $k; ?>]" id="field_desc<?php echo $k; ?>" <?php echo $showdesc; ?> style="width: 32%" />
			<label><input type="checkbox" name="bps_options[field_range][<?php echo $k; ?>]" id="field_range<?php echo $k; ?>" value="<?php echo $k; ?>"<?php if (isset ($bps_options['field_range'][$k])) echo ' checked="checked"'; ?> /><?php _e('Range', 'bp-profile-search'); ?> </label>
			<a href="javascript:hide('field_div<?php echo $k; ?>')" class="delete">[x]</a>
		</p>
<?php
	}
?>
		<input type="hidden" id="field_next" value="<?php echo count ($bps_options['field_name']); ?>" />
	</div>
	<p><a href="javascript:add_field()"><?php _e('Add Field', 'bp-profile-search'); ?></a></p>
<?php
}

function bps_field_select ($name, $id, $value)
{
	list ($groups, $x) = bps_get_fields ();

	echo "<select name='$name' id='$id'>\n";
	foreach ($groups as $group => $fields)
	{
		$group = esc_attr ($group);
		echo "<optgroup label='$group'>\n";
		foreach ($fields as $field)
		{
			$selected = $field['id'] == $value? " selected='selected'": '';
			echo "<option value='$field[id]'$selected>$field[name]</option>\n";
		}
		echo "</optgroup>\n";
	}
	echo "</select>\n";

	return true;
}

function bps_get_fields ()
{
	global $group, $field;

	static $groups = array ();
	static $fields = array ();

	if (count ($groups))  return array ($groups, $fields);

	if (!function_exists ('bp_has_profile'))
	{
		printf ('<p class="bps_error">'. __('%s: The BuddyPress Extended Profiles component is not active.', 'bp-profile-search'). '</p>',
			'<strong>BP Profile Search '. BPS_VERSION. '</strong>');
		return array ($groups, $fields);
	}

	if (bp_has_profile ('hide_empty_fields=0'))
	{
		while (bp_profile_groups ())
		{
			bp_the_profile_group (); 
			$group->name = str_replace ('&amp;', '&', stripslashes ($group->name));
			$groups[$group->name] = array ();

			while (bp_profile_fields ())
			{
				bp_the_profile_field ();
				$field->name = str_replace ('&amp;', '&', stripslashes ($field->name));
				$field->description = str_replace ('&amp;', '&', stripslashes ($field->description));
				$groups[$group->name][] = array ('id' => $field->id, 'name' => $field->name);
				$fields[$field->id] = $field;
			}
		}
	}

	list ($groups, $fields) = apply_filters ('bps_get_fields', array ($groups, $fields));
	return array ($groups, $fields);
}

function bps_custom_field ($type)
{
	return !in_array ($type, array ('textbox', 'number', 'url', 'textarea', 'selectbox', 'multiselectbox', 'radio', 'checkbox', 'datebox'));
}

function bps_get_widget ($form)
{
	$widgets = get_option ('widget_bps_widget');
	if ($widgets == false)  return __('unused', 'bp-profile-search');

	$titles = array ();
	foreach ($widgets as $key => $widget)
		if (isset ($widget['form']) && $widget['form'] == $form)  $titles[] = !empty ($widget['title'])? $widget['title']: __('(no title)');
		
	return count ($titles)? implode ('<br/>', $titles): __('unused', 'bp-profile-search');
}

function bps_field_options ($id)
{
	static $options = array ();

	if (isset ($options[$id]))  return $options[$id];

	$field = new BP_XProfile_Field ($id);
	if (empty ($field->id))  return array ();

	$options[$id] = array ();
	$rows = $field->get_children ();
	if (is_array ($rows))
		foreach ($rows as $row)
			$options[$id][stripslashes (trim ($row->name))] = stripslashes (trim ($row->name));

	return $options[$id];
}
