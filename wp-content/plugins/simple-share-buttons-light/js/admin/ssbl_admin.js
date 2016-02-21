jQuery(document).ready(function() {

	// switch for checkboxes
	jQuery(".ssbl-admin-wrap input:checkbox").bootstrapSwitch({
		onColor: 	'primary',
		size:		'normal'
	});

	jQuery('.ssbl-updated').fadeIn('fast');
	jQuery('.ssbl-updated').delay(1000).fadeOut('slow');

	//------- INCLUDE LIST ----------//

	// add drag and sort functions to include table
	jQuery(function() {
		jQuery( "#ssblsort1, #ssblsort2" ).sortable({
			connectWith: ".ssblSortable"
		}).disableSelection();
	  });


	// extract and add include list to hidden field
	jQuery('#selected_buttons').val(jQuery('#ssblsort2 li').map(function() {
	// For each <li> in the list, return its inner text and let .map()
	//  build an array of those values.
	return jQuery(this).attr('id');
	}).get());

	// after a change, extract and add include list to hidden field
	jQuery('.ssbp-wrap').mouseout(function() {
		jQuery('#selected_buttons').val(jQuery('#ssblsort2 li').map(function() {
		// For each <li> in the list, return its inner text and let .map()
		//  build an array of those values.
		return jQuery(this).attr('id');
		}).get());
	});

	//---------------------------------------------------------------------------------------//
    //
    // SSBL ADMIN FORM
    //
    jQuery( "#ssbl-admin-form:not('.ssbl-form-non-ajax')" ).on( 'submit', function(e) {

        // don't submit the form
        e.preventDefault();

        // show spinner to show save in progress
        jQuery("button.ssbl-btn-save").html('<i class="fa fa-spinner fa-spin"></i>');

        // get posted data and serialise
        var ssblData = jQuery("#ssbl-admin-form").serialize();

        // disable all inputs
        jQuery(':input').prop('disabled', true);
		jQuery(".ssbl-admin-wrap input:checkbox").bootstrapSwitch('disabled', true);


        jQuery.post(
            jQuery( this ).prop( 'action' ),
            {
                ssblData: ssblData
            },
            function() {

				// show success
                jQuery('button.ssbl-btn-save-success').fadeIn(100).delay(2500).fadeOut(200);

	            // re-enable inputs and reset save button
	            jQuery(':input').prop('disabled', false);
				jQuery(".ssbl-admin-wrap input:checkbox").bootstrapSwitch('disabled', false);
                jQuery("button.ssbl-btn-save").html('<i class="fa fa-floppy-o"></i>');
            }
        ); // end post
    } ); // end form submit

});
