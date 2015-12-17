window.wp = window.wp || {};



window.emlIsGalleryFilterBased = function( attrs ) {

    var filterBasedFields;

    if ( _.isUndefined( attrs ) ) {
        return false;
    }

    // because of 0 (unattached) value
    if ( ! _.isUndefined( attrs.uploadedTo ) ) {
        return true;
    }

    if ( _.filter( _.pick( attrs, 'monthnum', 'year' ), _.identity ).length == 2 ) {
        filterBasedFields = _.omit( attrs, 'type', 'orderby', 'order', 'query', 'perPage', 'post__in', 'include', 'exclude', 'id', 'ids', 'columns', 'itemtag', 'icontag', 'captiontag', 'link', 'size', '_orderByField', '_orderbyRandom' );
    }
    else {
        filterBasedFields = _.omit( attrs, 'type', 'orderby', 'order', 'query', 'perPage', 'post__in', 'include', 'exclude', 'id', 'ids', 'columns', 'itemtag', 'icontag', 'captiontag', 'link', 'size', '_orderByField', '_orderbyRandom', 'monthnum', 'year' );
    }

    // if any of these is set: %taxonomy_name%, monthnum, year
    if ( _.filter( _.values( filterBasedFields ), _.identity ).length ) {
        return true;
    }

    return false;
};



( function( $, _ ) {

    var media = wp.media,
        original = {};

    /**
     * wp.media.view.MediaFrame.Post
     *
     */
    original.MediaFrame = {

        Post: {
            galleryMenu: media.view.MediaFrame.Post.prototype.galleryMenu
        }
    };

    _.extend( media.view.MediaFrame.Post.prototype, {

        galleryMenu: function( view ) {

            original.MediaFrame.Post.galleryMenu.apply( this, arguments );

            var library = this.state().get('library'),
                isFilterBased = emlIsGalleryFilterBased( library.props.toJSON() );


            if ( isFilterBased ) {
                view.hide( 'gallery-library' );
            }
        }
    });



    /**
     * wp.media.view.Attachment.EditLibrary
     *
     */
    _.extend( media.view.Attachment.EditLibrary.prototype, {

        initialize: function() {

            var state = this.controller.state(),
                isFilterBased = emlIsGalleryFilterBased( state.get('library').props.toJSON() );


            this.buttons.close = ( 'gallery-edit' == state.get('id') && isFilterBased ) ? false : true;
        }
    });



    /**
     * wp.media.view.Settings.Gallery
     *
     */
    _.extend( media.view.Settings.Gallery.prototype.events, {
        'change ._orderbyRandom' : 'change_orderbyRandom',
    });

    _.extend( media.view.Settings.Gallery.prototype, {

        template:  media.template('eml-gallery-settings'),

        change_orderbyRandom: function( event ) {

            var content = this.controller.frame.content,
                reverse = content.get().toolbar.get( 'reverse' );

            reverse.model.set( 'disabled', $( event.target ).is(':checked') );
        }
    });



    /**
     * wp.media.controller.GalleryEdit
     *
     */
    original.GalleryEdit = {

        gallerySettings: media.controller.GalleryEdit.prototype.gallerySettings,
    };

    _.extend( media.controller.GalleryEdit.prototype, {

        gallerySettings: function( browser ) {

            original.GalleryEdit.gallerySettings.apply( this, arguments );

            var library = this.get('library'),
                reverse = browser.toolbar.get( 'reverse' );


            reverse.model.set( 'disabled', 'rand' === library.props.get('orderby') );

            reverse.options.click = function() {

                switch( library.gallery.get( 'order' ) ) {
                    case 'ASC':
                        library.props.set( 'order', 'DESC' );
                        library.gallery.set( 'order', 'DESC' );
                        break;
                    case 'DESC':
                        library.props.set( 'order', 'ASC' );
                        library.gallery.set( 'order', 'ASC' );
                        break;
                    default:
                        library.props.set( 'order', 'DESC' );
                        library.gallery.set( 'order', 'DESC' );
                }

                library.reset( library.toArray().reverse() );
                library.saveMenuOrder();
            }
        }
    });

})( jQuery, _ );
