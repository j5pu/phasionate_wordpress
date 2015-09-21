/* Magnage Columns and Thumb Shapes */

var msnry;

(function ($) {
    jQuery(window).resize(function () {
        jQuery("#grid .wrap-post").each(function () {

            var gridW = jQuery('#grid').width();

            // CASE COL 6
            if (jQuery(this).hasClass('column-6')) {

                if (gridW > 840) {
                    jQuery(this).css('width', '');
                }

                if (gridW < 840 && gridW > 700) {
                    jQuery(this).css('width', '20%');
                }

                if (gridW < 700 && gridW > 560) {
                    jQuery(this).css('width', '25%');
                }

                if (gridW < 560 && gridW > 420) {
                    jQuery(this).css('width', '33.3333%');
                }

                if (gridW < 420 && gridW > 280) {
                    jQuery(this).css('width', '50%');
                }

                if (gridW < 280) {
                    jQuery(this).css('width', '100%');
                }

            }

            // CASE COL 5
            if (jQuery(this).hasClass('column-5')) {

                if (gridW > 700) {
                    jQuery(this).css('width', '');
                }

                if (gridW < 700 && gridW > 560) {
                    jQuery(this).css('width', '25%');
                }

                if (gridW < 560 && gridW > 420) {
                    jQuery(this).css('width', '33.3333%');
                }

                if (gridW < 420 && gridW > 280) {
                    jQuery(this).css('width', '50%');
                }

                if (gridW < 280) {
                    jQuery(this).css('width', '100%');
                }

            }

            // CASE COL 4
            if (jQuery(this).hasClass('column-4')) {

                if (gridW > 560) {
                    jQuery(this).css('width', '');
                }

                if (gridW < 560 && gridW > 420) {
                    jQuery(this).css('width', '33.3333%');
                }

                if (gridW < 420 && gridW > 280) {
                    jQuery(this).css('width', '50%');
                }

                if (gridW < 280) {
                    jQuery(this).css('width', '100%');
                }

            }

            // CASE COL 3
            if (jQuery(this).hasClass('column-3')) {

                if (gridW > 420) {
                    jQuery(this).css('width', '');
                }

                if (gridW < 420 && gridW > 280) {
                    jQuery(this).css('width', '50%');
                }

                if (gridW < 280) {
                    jQuery(this).css('width', '100%');
                }

            }

            // CASE COL 2
            if (jQuery(this).hasClass('column-2')) {

                if (gridW > 280) {
                    jQuery(this).css('width', '');
                }

                if (gridW < 280) {
                    jQuery(this).css('width', '100%');
                }

            }

            // Manage Thumb Sizes

            var itemW = jQuery(this).width();


            if (jQuery(this).hasClass('pr-thumb-land')) {

                var itemH = itemW / 3 * 2;

                jQuery('.post-image', jQuery(this)).css('width', itemW + 'px');
                jQuery('.post-image', jQuery(this)).css('height', itemH + 'px');

            }

            if (jQuery(this).hasClass('pr-thumb-port')) {

                var itemH = (itemW / 3 * 4) + getRandomInt(0, 40);

                jQuery('.post-image', jQuery(this)).css('width', itemW + 'px');
                jQuery('.post-image', jQuery(this)).css('height', itemH + 'px');

            }


            // Magnage Elements

            var relWidth = jQuery('.post-image', jQuery(this)).width();
            var relHeight = jQuery('.post-image', jQuery(this)).height();

            if (relWidth < 240 || relHeight < 240) {
                jQuery('.caption-subtitle', jQuery(this)).css('display', 'none');
            } else {
                jQuery('.caption-subtitle', jQuery(this)).css('display', '');

            }

            if (relWidth < 180 || relHeight < 180) {
                jQuery('.caption-title', jQuery(this)).css('display', 'none');
                jQuery('.meta-value', jQuery(this)).css('display', 'none');
            } else {
                jQuery('.caption-title', jQuery(this)).css('display', '');
                jQuery('.meta-value', jQuery(this)).css('display', '');
            }

            if (relWidth < 180) {
                jQuery('.wrap-excerpt', jQuery(this)).css('display', 'none');
            } else {
                jQuery('.wrap-excerpt', jQuery(this)).css('display', '');
            }

            if (relWidth < 160 || relHeight < 160) {
                jQuery('.btn-caption').css({'text-align': 'center', 'top': '50%', 'margin-top': '-30px'});
                jQuery('.btn-caption span').css('margin', '5px');
            } else {
                jQuery('.btn-caption').css({'text-align': '', 'top': '', 'left': '', 'margin': ''});
                jQuery('.btn-caption span').css('margin', '');
            }

        });
    });

    // using Math.round() in result will be uneven!
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    var fashion_load = function () {
        jQuery(window).trigger('resize');
        var container = document.querySelector('ul#grid')

        // initialize Masonry after all images have loaded
        imagesLoaded(container, function () {
            msnry = new Masonry(container, {
                //columnWidth: 200,
                columnWidth: '.wrap-post',
                itemSelector: 'li'
            });
        });
    }

    fashion_load();

    FvLib.addHook('fv/ajax_go_to_page/ready', fashion_load, 10);


    var fashion_infinite_selector = function (selector) {
        return '#grid';
    }
    FvLib.addFilter('fv/fv_ajax_go_to_page/infinite_selector', fashion_infinite_selector, 10, 1);

})(jQuery);