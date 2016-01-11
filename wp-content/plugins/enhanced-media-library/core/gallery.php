<?php



/**
 *  wpuxss_eml_get_gallery_attachments
 *
 *  'eml_gallery_attachments' filter callback
 *
 *  @since    2.1.4
 *  @created  26/12/15
 */

add_filter( 'eml_gallery_attachments', 'wpuxss_eml_get_gallery_attachments', 10, 2 );

if ( ! function_exists( 'wpuxss_eml_get_gallery_attachments' ) ) {

    function wpuxss_eml_get_gallery_attachments( $attachments, $attr ) {

        $attachments = eml_get_gallery_attachments( $attr );

        return $attachments;
    }
}



/**
 *  eml_get_gallery_attachments
 *
 *  Retrive attachments for a gallery, for future API
 *
 *  @since    2.1.4
 *  @created  08/01/16
 */

if ( ! function_exists( 'eml_get_gallery_attachments' ) ) {

    function eml_get_gallery_attachments( $attr ) {

        $post = get_post();

        $is_filter_based = false;

        $atts = array_merge( array(
            'ids'        => '',
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'include'    => '',
            'exclude'    => ''
        ), $attr );

        if ( ! isset( $attr['id'] ) ) {
            $atts['id'] = 0;
        }
        else {
            $atts['id'] = isset( $post->ID ) ? intval( $post->ID ) : 0;
        }

        $id = intval( $atts['id'] );

        $query = array(
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby'],
            'posts_per_page' => isset( $atts['limit'] ) ? intval( $atts['limit']  ) : -1, //TODO: add pagination
        );

        if ( isset( $attr['monthnum'] ) && isset( $attr['year'] ) ) {

            $query['monthnum'] = $attr['monthnum'];
            $query['year'] = $attr['year'];

            $is_filter_based = true;
        }


        $tax_query = array();

        foreach ( get_object_taxonomies( 'attachment', 'names' ) as $taxonomy ) {

            if ( isset( $attr[$taxonomy] ) ) {

                $terms = explode( ',', $attr[$taxonomy] );

                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $terms,
                    'operator' => 'IN',
                );

                $is_filter_based = true;
            }
        }


        if ( $is_filter_based ) {

            if ( 'post__in' === $atts['orderby'] ) {
                $query['orderby'] = 'menu_order ID';
            }

            if ( ! empty( $tax_query ) ) {

                $tax_query['relation'] = 'AND';
                $query['tax_query'] = $tax_query;
            }

            if ( $id ) {
                $query['post_parent'] = $id;
            }

            $_attachments = get_posts( $query );

            $attachments = array();
            foreach ( $_attachments as $key => $val )
                $attachments[$val->ID] = $_attachments[$key];
        }
        elseif ( ! empty( $atts['include'] ) ) {

            $query['include'] = $atts['include'];

            $_attachments = get_posts( $query );

            $attachments = array();
            foreach ( $_attachments as $key => $val )
                $attachments[$val->ID] = $_attachments[$key];
        }
        elseif ( ! empty( $atts['exclude'] ) ) {

            $query['exclude'] = $atts['exclude'];
            $query['post_parent'] = isset( $atts['id'] ) ? $atts['id'] : 0;

            $attachments = get_children( $query );
        }
        elseif ( $id ) {

            $query['post_parent'] = $id;

            $attachments = get_children( $query );
        }
        else {

            $attachments = array();
        }

        return $attachments;
    }
}



/**
 *  wpuxss_eml_get_gallery_html
 *
 *  @since    2.1.4
 *  @created  26/12/15
 */

add_filter( 'eml_gallery_output', 'wpuxss_eml_get_gallery_html', 10, 4 );

if ( ! function_exists( 'wpuxss_eml_get_gallery_html' ) ) {

    function wpuxss_eml_get_gallery_html( $output, $attachments, $attr, $instance ) {

        $html5 = current_theme_supports( 'html5', 'gallery' );
        $atts = array_merge( array(
            'itemtag'    => $html5 ? 'figure'     : 'dl',
            'icontag'    => $html5 ? 'div'        : 'dt',
            'captiontag' => $html5 ? 'figcaption' : 'dd',
            'columns'    => 3,
            'size'       => 'thumbnail',
            'link'       => ''
        ), $attr );

        $itemtag = tag_escape( $atts['itemtag'] );
        $captiontag = tag_escape( $atts['captiontag'] );
        $icontag = tag_escape( $atts['icontag'] );
        $valid_tags = wp_kses_allowed_html( 'post' );
        if ( ! isset( $valid_tags[ $itemtag ] ) ) {
            $itemtag = 'dl';
        }
        if ( ! isset( $valid_tags[ $captiontag ] ) ) {
            $captiontag = 'dd';
        }
        if ( ! isset( $valid_tags[ $icontag ] ) ) {
            $icontag = 'dt';
        }

        $columns = intval( $atts['columns'] );
        $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
        $float = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";

        $gallery_style = '';


        if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
            $gallery_style = "
            <style type='text/css'>
                #{$selector} {
                    margin: auto;
                }
                #{$selector} .gallery-item {
                    float: {$float};
                    margin-top: 10px;
                    text-align: center;
                    width: {$itemwidth}%;
                }
                #{$selector} img {
                    border: 2px solid #cfcfcf;
                }
                #{$selector} .gallery-caption {
                    margin-left: 0;
                }
                /* see gallery_shortcode() in wp-includes/media.php */
            </style>\n\t\t";
        }

        $size_class = sanitize_html_class( $atts['size'] );
        $gallery_div = "<div id='$selector' class='gallery galleryid-{$instance} gallery-columns-{$columns} gallery-size-{$size_class}'>";


        $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {

            $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
            if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
            } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
                $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
            } else {
                $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
            }
            $image_meta  = wp_get_attachment_metadata( $id );

            $orientation = '';
            if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
            }
            $output .= "<{$itemtag} class='gallery-item'>";
            $output .= "
                <{$icontag} class='gallery-icon {$orientation}'>
                    $image_output
                </{$icontag}>";
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
                    " . wptexturize($attachment->post_excerpt) . "
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
            if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
                $output .= '<br style="clear: both" />';
            }
        }

        if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
            $output .= "
                <br style='clear: both' />";
        }

        $output .= "
            </div>\n";

        return $output;
    }
}



/**
 *  wpuxss_get_eml_gallery_feed
 *
 *  @since    2.1.4
 *  @created  26/12/15
 */

if ( ! function_exists( 'wpuxss_get_eml_gallery_feed' ) ) {

    function wpuxss_get_eml_gallery_feed( $attachments, $attr ) {

        $atts = array_merge( array(
            'size'       => 'thumbnail',
        ), $attr );

        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
        }
        return $output;
    }
}



/**
 *  wpuxss_eml_gallery_shortcode
 *
 *  @since    2.1
 *  @created  24/11/15
 */

add_filter( 'post_gallery', 'wpuxss_eml_gallery_shortcode', 12, 3 );

if ( ! function_exists( 'wpuxss_eml_gallery_shortcode' ) ) {

    function wpuxss_eml_gallery_shortcode( $output, $attr, $instance = 0 ) {

        $attr = apply_filters( 'eml_gallery_attributes', $attr );

        $attachments = apply_filters( 'eml_gallery_attachments', array(), $attr );


        if ( empty( $attachments ) ) {
            return '';
        }

        if ( is_feed() ) {
            $output = wpuxss_get_eml_gallery_feed( $attachments, $attr );
            return $output;
        }

        $output = apply_filters( 'eml_gallery_output', '', $attachments, $attr, $instance );

        return $output;
    }
}



/**
 *  wpuxss_eml_jp_carousel_force_enable
 *
 *  Jetpack Carousel compatibility
 *
 *  @since    2.1
 *  @created  16/12/15
 */

add_filter( 'jp_carousel_force_enable', 'wpuxss_eml_jp_carousel_force_enable' );

if ( ! function_exists( 'wpuxss_eml_jp_carousel_force_enable' ) ) {

    function wpuxss_eml_jp_carousel_force_enable( $enabled ) {
        return true;
    }
}



/**
 *  wpuxss_eml_jp_tiled_gallery_force_enable
 *
 *  Jetpack (3.8.2) Tiled Galleries compatibility
 *
 *  @since    2.1
 *  @created  16/12/15
 */

add_filter( 'eml_gallery_output', 'wpuxss_eml_jp_tiled_gallery_force_enable', 10, 4 );

function wpuxss_eml_jp_tiled_gallery_force_enable( $output, $attachments, $attr, $instance ) {

    if ( ! class_exists( 'Jetpack_Tiled_Gallery' ) ) {
        return $output;
    }

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = array_merge( array(
        'itemtag'    => $html5 ? 'figure'     : 'dl',
        'icontag'    => $html5 ? 'div'        : 'dt',
        'captiontag' => $html5 ? 'figcaption' : 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'link'       => ''
    ), $attr );


    $gallery = new eml_Jetpack_Tiled_Gallery;
    $output = $gallery->gallery_output( $attachments, $atts );

    return $output;
}



add_action( 'init', 'wpuxss_eml_jetpack_tiled_gallery_override' );

if ( ! function_exists( 'wpuxss_eml_jetpack_tiled_gallery_override' ) ) {

    function wpuxss_eml_jetpack_tiled_gallery_override() {

        if ( ! class_exists( 'Jetpack_Tiled_Gallery' ) ) {
            return;
        }

        class eml_Jetpack_Tiled_Gallery extends Jetpack_Tiled_Gallery {

            private static $talaveras = array( 'rectangular', 'square', 'circle', 'rectangle', 'columns' );

            public function gallery_output( $attachments, $atts ) {

                $this->set_atts( $atts );

                if (
                    in_array(
                        $this->atts['type'],
                        $talaveras = apply_filters( 'jetpack_tiled_gallery_types', self::$talaveras )
                    )
                ) {
                    // Enqueue styles and scripts
                    self::default_scripts_and_styles();

                    // Generate gallery HTML
                    $gallery_class = 'Jetpack_Tiled_Gallery_Layout_' . ucfirst( $this->atts['type'] );
                    $gallery = new $gallery_class( $attachments, $this->atts['link'], $this->atts['grayscale'], (int) $this->atts['columns'] );
                    $gallery_html = $gallery->HTML();

                    if ( $gallery_html && class_exists( 'Jetpack' ) && class_exists( 'Jetpack_Photon' ) ) {
                        // Tiled Galleries in Jetpack require that Photon be active.
                        // If it's not active, run it just on the gallery output.
                        if ( ! in_array( 'photon', Jetpack::get_active_modules() ) && ! Jetpack::is_development_mode() )
                            $gallery_html = Jetpack_Photon::filter_the_content( $gallery_html );
                    }

                    return trim( preg_replace( '/\s+/', ' ', $gallery_html ) ); // remove any new lines from the output so that the reader parses it better
                }

                return '';
            }
        }
    }
}



/**
 *  wpuxss_eml_print_media_gallery_templates
 *
 *  @since    2.1
 *  @created  10/12/15
 */

add_action( 'print_media_templates', 'wpuxss_eml_print_media_gallery_templates' );

if ( ! function_exists( 'wpuxss_eml_print_media_gallery_templates' ) ) {

    function wpuxss_eml_print_media_gallery_templates() { ?>

        <script type="text/html" id="tmpl-eml-gallery-settings">

            <div class="eml-info-box">

        		<h3><?php _e('Gallery Settings'); ?></h3>

        		<label class="setting">
        			<span><?php _e('Link To'); ?></span>
        			<select class="link-to"
        				data-setting="link"
        				<# if ( data.userSettings ) { #>
        					data-user-setting="urlbutton"
        				<# } #>>

        				<option value="post" <# if ( ! wp.media.galleryDefaults.link || 'post' == wp.media.galleryDefaults.link ) {
        					#>selected="selected"<# }
        				#>>
        					<?php esc_attr_e('Attachment Page'); ?>
        				</option>
        				<option value="file" <# if ( 'file' == wp.media.galleryDefaults.link ) { #>selected="selected"<# } #>>
        					<?php esc_attr_e('Media File'); ?>
        				</option>
        				<option value="none" <# if ( 'none' == wp.media.galleryDefaults.link ) { #>selected="selected"<# } #>>
        					<?php esc_attr_e('None'); ?>
        				</option>
        			</select>
        		</label>

        		<label class="setting">
        			<span><?php _e('Columns'); ?></span>
        			<select class="columns" name="columns"
        				data-setting="columns">
        				<?php for ( $i = 1; $i <= 9; $i++ ) : ?>
        					<option value="<?php echo esc_attr( $i ); ?>" <#
        						if ( <?php echo $i ?> == wp.media.galleryDefaults.columns ) { #>selected="selected"<# }
        					#>>
        						<?php echo esc_html( $i ); ?>
        					</option>
        				<?php endfor; ?>
        			</select>
        		</label>

        		<label class="setting _orderbyRandom">
        			<span><?php _e( 'Random Order' ); ?></span>
        			<input type="checkbox" data-setting="_orderbyRandom" />
        		</label>

        		<label class="setting size">
        			<span><?php _e( 'Size' ); ?></span>
        			<select class="size" name="size"
        				data-setting="size"
        				<# if ( data.userSettings ) { #>
        					data-user-setting="imgsize"
        				<# } #>
        				>
        				<?php
        				// This filter is documented in wp-admin/includes/media.php
        				$size_names = apply_filters( 'image_size_names_choose', array(
        					'thumbnail' => __( 'Thumbnail' ),
        					'medium'    => __( 'Medium' ),
        					'large'     => __( 'Large' ),
        					'full'      => __( 'Full Size' ),
        				) );

        				foreach ( $size_names as $size => $label ) : ?>
        					<option value="<?php echo esc_attr( $size ); ?>">
        						<?php echo esc_html( $label ); ?>
        					</option>
        				<?php endforeach; ?>
        			</select>
        		</label>

            </div>

            <#
            var library = data.controller.frame.state().get( 'library' ),
                isFilterBased = emlIsGalleryFilterBased( library.props.toJSON() );

            if ( isFilterBased ) { #>

                <div class="eml-info-box">

                    <h3><?php _e( 'Based On', 'eml' ); ?></h3>
                    <label class="setting filter-based">

                        <ul class="eml-filter-based">

                            <#
                            _.each( eml.l10n.all_taxonomies, function( attrs, taxonomy ) {

                                var ids = library.props.get( taxonomy ),
                                    taxonomy_string;

                                if ( ids ) {

                                    taxonomy_string = attrs.singular_name + ': ' + _.values( _.pick( attrs.terms, ids ) ).join(', ');

                                    #><li>{{taxonomy_string}}</li><#
                                }
                            });

                            var months = wp.media.view.settings.months,
                                monthnum = library.props.get( 'monthnum' ),
                                year = library.props.get( 'year' ),
                                uploadedTo = library.props.get( 'uploadedTo' );

                            if ( monthnum && year ) {
                                date = _.first( _.where( months, { month: monthnum, year: year } ) ).text;
                                #><li>{{date}}</li><#
                            }

                            if ( ! _.isUndefined( uploadedTo ) ) {

                                if ( uploadedTo == wp.media.view.settings.post.id ) {
                                    #><li>{{wp.media.view.l10n.uploadedToThisPost}}</li><#
                                }
                                else if ( parseInt( uploadedTo ) ) {
                                    #><li>{{window.eml.l10n.uploaded_to}}{{uploadedTo}}</li><#
                                }
                            }
                            #>
                        </ul>
                    </label>
                </div>
            <# } #>
    	</script>
    <?php }
}

?>
