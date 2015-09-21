/*
 * Functions for Settings page
 *
 * Plugin Name: WP Foto Vote
 * Plugin URI: http://wp-vote.net
 * Author: Maxim K
 * Author URI: http://maxim-kaminsky.com/
 */

FvLib.addHook('doc_ready', function() {
	// load css editor for additional CSS styles editor
	var editor = CodeMirror.fromTextArea(
		  document.querySelector("textarea[name='fotov-custom-css']"),
		  {
			  extraKeys: { "Ctrl-Space": "autocomplete" }
		  }
	);

    jQuery('.colorpicker .color').wpColorPicker();

});

function fv_reset_color(el, default_color)
{
    jQuery(el).parent().find('.wp-color-picker').iris('color', default_color);
    jQuery(el).parent().append("<i>Color reset to default. Don't remember save options.</i>");
}