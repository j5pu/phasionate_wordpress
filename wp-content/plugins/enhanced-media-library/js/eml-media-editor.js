window.wp = window.wp || {};
window.eml = window.eml || { l10n: {} };

( function( $, _ ) {

    var media = wp.media,
        l10n = media.view.l10n,
        original = {},
        gallery = wp.mce.views.get('gallery');



    _.extend( eml.l10n, wpuxss_eml_media_editor_l10n );



    /**
     * wp.media.gallery
     *
     */
    _.extend( media.gallery.defaults, {
		orderby : 'menuOrder'
    });

    delete media.gallery.defaults.id;

    _.extend( media.gallery, {

        collections: {},

        attachments: function( shortcode ) {

            var collections = this.collections,
                shortcodeString = shortcode.string(),
                result = collections[ shortcodeString ],
                attrs, args, query, others, self = this,
                isFilterBased = emlIsGalleryFilterBased( shortcode.attrs.named );


            delete collections[ shortcodeString ];


            if ( result && ! isFilterBased ) {
                return result;
            }

            // Fill the default shortcode attributes.
            attrs = _.defaults( shortcode.attrs.named, this.defaults );
            args  = _.pick( attrs, 'orderby', 'order' );

            args.type    = this.type;
            args.perPage = -1;


            if ( 'rand' === attrs.orderby ) {
                attrs._orderbyRandom = true;
            }

            if ( 'post_date' === attrs.orderby ) {
                args.orderby = 'date';
            }

            // Map the `orderby` attribute to the corresponding model property.
            if ( ! attrs.orderby || /^menu_order(?: ID)?$/i.test( attrs.orderby ) ) {
                args.orderby = 'menuOrder';
            }

            if ( 'menuOrder' === args.orderby ) {
                args.order = 'ASC';
            }

            if ( undefined === attrs.id && ! isFilterBased ) {
                attrs.id = media.view.settings.post && media.view.settings.post.id;
            }

            if ( isFilterBased ) {

                if ( undefined !== attrs.id ) {
                    args.uploadedTo = attrs.id;
                }

                _.each( eml.l10n.all_taxonomies, function( terms, taxonomy ) {

                    if ( attrs[taxonomy] ) {

                        if ( _.isArray( attrs[taxonomy] ) ) {
                            args[taxonomy] = attrs[taxonomy];
                        }
                        else {
                            args[taxonomy] = attrs[taxonomy].split(',');
                        }
                    }
                });

                if ( attrs.monthnum && attrs.year ) {
                    args.monthnum = attrs.monthnum;
                    args.year = attrs.year;
                }
            }
            else {

                if ( attrs.ids ) {

                    args.post__in = attrs.ids.split(',');

                    if ( 'menuOrder' === args.orderby ) {
                        args.orderby = 'post__in';
                    }
                }
                else if ( attrs.include ) {
                    args.post__in = attrs.include.split(',');
                }

                if ( attrs.exclude ) {
                    args.post__not_in = attrs.exclude.split(',');
                }

                if ( ! args.post__in ) {
                    args.uploadedTo = attrs.id;
                }
            }


            // Collect the attributes that were not included in `args`.
            others = _.omit( attrs, 'id', 'ids', 'include', 'exclude' );

            _.each( this.defaults, function( value, key ) {
                others[ key ] = self.coerce( others, key );
            });

            query = wp.media.query( args );
            query[ this.tag ] = new Backbone.Model( others );

            return query;
        },

        shortcode: function( attachments ) {

            var collections = this.collections,
                props = attachments.props.toJSON(),
                attrs = _.pick( props, 'orderby', 'order' ),
                shortcode, clone,
                isFilterBased = emlIsGalleryFilterBased( props );


            if ( attachments.type ) {
                attrs.type = attachments.type;
                delete attachments.type;
            }

            if ( attachments[this.tag] ) {
                _.extend( attrs, attachments[this.tag].toJSON() );
            }

            if ( ! isFilterBased || 'menuOrder' === attrs.orderby ) {
                // Convert all gallery shortcodes to use the `ids` property.
                // Ignore `post__in` and `post__not_in`; the attachments in
                // the collection will already reflect those properties.
                attrs.ids = attachments.pluck('id');
            }

            // Copy the `uploadedTo` post ID.
            if ( undefined !==  props.uploadedTo && null !== props.uploadedTo ) {
                attrs.id = props.uploadedTo;
            }

            if ( undefined !== attrs._orderbyRandom ) {

                if ( attrs._orderbyRandom ) {
                    attrs.orderby = 'rand';
                } else {
                    delete attrs.orderby;
                }
                delete attrs._orderbyRandom;
            }


            _.each( eml.l10n.all_taxonomies, function( terms, taxonomy ) {

                if ( props[taxonomy] ) {
                    attrs[taxonomy] = props[taxonomy];
                }
            });


            if ( props.monthnum && props.year ) {
                attrs.monthnum = props.monthnum;
                attrs.year = props.year;
            }

            if ( 'rand' === attrs.orderby || 'menuOrder' === attrs.orderby ) {
                delete attrs.order;
            }

            attrs = this.setDefaults( attrs );


            shortcode = new wp.shortcode({
                tag:    this.tag,
                attrs:  attrs,
                type:   'single'
            });

            // Use a cloned version of the gallery.
            clone = new wp.media.model.Attachments( attachments.models, {
                props: props
            });
            clone[ this.tag ] = attachments[ this.tag ];
            collections[ shortcode.string() ] = clone;

            return shortcode;
        },

        edit: function( content ) {

            var shortcode = wp.shortcode.next( this.tag, content ),
                attachments, selection, state;

            // Bail if we didn't match the shortcode or all of the content.
            if ( ! shortcode || shortcode.content !== content ) {
                return;
            }

            // Ignore the rest of the match object.
            shortcode = shortcode.shortcode;

            attachments = this.attachments( shortcode );

            selection = new wp.media.model.Selection( attachments.models, {
                props:    attachments.props.toJSON(),
                multiple: true
            });

            selection[ this.tag ] = attachments[ this.tag ];

            // Fetch the query's attachments, and then break ties from the
            // query to allow for sorting.
            selection.more().done( function() {
                // Break ties with the query.
                selection.props.set({ query: false });
                selection.unmirror();
            });

            // Destroy the previous gallery frame.
            if ( this.frame ) {
                this.frame.dispose();
            }

            if ( shortcode.attrs.named.type && 'video' === shortcode.attrs.named.type ) {
                state = 'video-' + this.tag + '-edit';
            } else {
                state = this.tag + '-edit';
            }

            // Store the current frame.
            this.frame = wp.media({
                frame:     'post',
                state:     state,
                title:     this.editTitle,
                editing:   true,
                multiple:  true,
                selection: selection
            }).open();

            return this.frame;
        }
    });

})( jQuery, _ );
