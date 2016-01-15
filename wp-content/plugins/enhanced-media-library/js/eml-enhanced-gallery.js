window.wp = window.wp || {};
window.eml = window.eml || { l10n: {} };



function emlIsGalleryFilterBased( attrs ) {

    if ( _.isUndefined( attrs ) || _.isEmpty( attrs ) ) {
        return false;
    }

    if ( attrs.uploadedTo ) {
        return true;
    }

    if ( _.filter( _.pick( attrs, 'monthnum', 'year' ), _.identity ).length == 2 ) {
        return true;
    }

    return _.some( eml.l10n.all_taxonomies, function( terms, taxonomy ) {
        return ( ! _.isUndefined( attrs[taxonomy] ) && ! _.isNull( attrs[taxonomy] ) );
    });
}



( function( $, _ ) {

    var media = wp.media,
        original = {};



    _.extend( eml.l10n, wpuxss_eml_enhanced_gallery_l10n );



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
    original.Settings = {

        Gallery: {
            render: media.view.Settings.Gallery.prototype.render
        }
    };

    _.extend( media.view.Settings.Gallery.prototype.events, {
        'change [data-setting=_orderbyRandom]' : 'change_orderbyRandom',
    });

    _.extend( media.view.Settings.Gallery.prototype, {

        render: function() {

            var append = this.basedOnHTML();


            original.Settings.Gallery.render.apply( this, arguments );

            if ( append ) {
                this.$el.append( append );
            }

            return this;
        },

        change_orderbyRandom: function( event ) {

            var content = this.controller.frame.content,
                reverse = content.get().toolbar.get( 'reverse' );

            reverse.model.set( 'disabled', $( event.target ).is(':checked') );
        },

        basedOnHTML: function() {

            var library = this.controller.frame.state().get('library'),
                isFilterBased = emlIsGalleryFilterBased( library.props.toJSON() ),
                append = '',
                date,
                months = media.view.settings.months,
                monthnum = library.props.get( 'monthnum' ),
                year = library.props.get( 'year' ),
                uploadedTo = library.props.get( 'uploadedTo' );

            if ( isFilterBased ) {

                append = '<br class="clear" /><h3>' + eml.l10n.based_on + '</h3><label class="setting eml-filter-based"><ul class="eml-filter-based">';

                _.each( eml.l10n.all_taxonomies, function( attrs, taxonomy ) {

                    var ids = library.props.get( taxonomy ),
                        taxonomy_string;

                    if ( ids ) {

                        taxonomy_string = attrs.singular_name + ': ' + _.values( _.pick( attrs.terms, ids ) ).join(', ');
                        append += '<li>' + taxonomy_string + '</li>';
                    }
                });

                if ( monthnum && year ) {
                    date = _.first( _.where( months, { month: monthnum, year: year } ) ).text;
                    append += '<li>' + date + '</li>';
                }

                if ( ! _.isUndefined( uploadedTo ) ) {

                    if ( uploadedTo == media.view.settings.post.id ) {
                        append += '<li>' + media.view.l10n.uploadedToThisPost + '</li>';
                    }
                    else if ( parseInt( uploadedTo ) ) {
                        append += '<li>' + eml.l10n.uploaded_to + uploadedTo + '</li>';
                    }
                }
                append += '</ul></label>';
            }

            return append;
        },
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
