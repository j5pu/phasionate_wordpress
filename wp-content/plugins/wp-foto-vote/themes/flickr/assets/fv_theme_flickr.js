(function ($) {
    var handler = $('.justified-gallery'); // Get a reference to your grid items.

	if ( !fv.single ) {
        var flickr_load = function () {
            var rowHeight = 0,
                loadedImages = 0; // Counter for loaded images

            jQuery('.justified-gallery').imagesLoaded(function () {
                // Call the layout function.
                if ( rowHeight == 0 ) {
                    rowHeight  = 220;
                }

                $('.justified-gallery').flexImages({rowHeight: rowHeight, resize:true});

            }).progress(function (instance, image) {
                $block = jQuery(image.img).parent().parent().parent().parent();
                if ( $block.data('w') == "" ) {
                    $block.data( 'w', $block.width() );
                }
                if ( $block.data('h') == "" ) {
                    $block.data( 'h', $block.height() );
                }

                if ( rowHeight == 0 ) {
                    rowHeight = $block.data( 'h' );
                }

                // Update progress bar after each image load
                loadedImages++;
                if (loadedImages == handler.length) {
                    $('#progress').width( '100%');
                    $('#progress').fadeOut( 1000 );
                } else {
                    $('#progress').width( (loadedImages / handler.length * 100) + '%' );
                }
            });
        }

        flickr_load();

        FvLib.addHook('fv/ajax_go_to_page/ready', flickr_load, 10);


        var flickr_infinite_selector = function (selector) {
            return '.photo-display-container';
        }
        FvLib.addFilter('fv/fv_ajax_go_to_page/infinite_selector', flickr_infinite_selector, 10, 1);
	}

})(jQuery);


if ( fv.single ) {
	var image = document.querySelector('.main-image img.mainImage');

	image.onload = function() {

		EXIF.getData(image, function() {
			if ( EXIF.getTag(this, "Model") != undefined ) {
				document.querySelector('.exif-info .exif-model').innerHTML =  EXIF.getTag(this, "Model");
				document.querySelector('.exif-info .exif-focal-length').innerHTML =  EXIF.getTag(this, "FocalLength");
				document.querySelector('.exif-info .exif-shutter-speed').innerHTML =  EXIF.getTag(this, "ShutterSpeedValue");
				document.querySelector('.exif-info .exif-aperture').innerHTML =  EXIF.getTag(this, "ApertureValue");
				document.querySelector('.exif-info .exif-iso').innerHTML =  EXIF.getTag(this, "ISOSpeedRatings");
				document.querySelector('.exif-info .exif-taken-at').innerHTML =  EXIF.getTag(this, "DateTimeOriginal");
				document.querySelector('.exif').style.display = 'block';
				//EXIF.getTag(this, "Model");

				//console.log( EXIF.pretty(this) );
			}
		});

	};
}
