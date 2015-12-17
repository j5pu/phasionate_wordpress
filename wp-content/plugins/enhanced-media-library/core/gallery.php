<?php



/**
 *  wpuxss_eml_gallery_shortcode
 *
 *  @since    2.1
 *  @created  24/11/15
 */

add_filter( 'post_gallery', 'wpuxss_eml_gallery_shortcode', 12, 3 );

if ( ! function_exists( 'wpuxss_eml_gallery_shortcode' ) ) {

    function wpuxss_eml_gallery_shortcode( $output, $attr, $instance = 0 ) {

        $post = get_post();

        $is_filter_based = false;


        $html5 = current_theme_supports( 'html5', 'gallery' );
        $atts = shortcode_atts( array(
            'ids'        => '',
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'itemtag'    => $html5 ? 'figure'     : 'dl',
            'icontag'    => $html5 ? 'div'        : 'dt',
            'captiontag' => $html5 ? 'figcaption' : 'dd',
            'columns'    => 3,
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => '',
            'link'       => '',
            'unattached' => ''
        ), $attr, 'gallery' );


        $query = array(
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby'],
            'posts_per_page' => -1, //TODO: add limit and pagination
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


        if ( isset( $attr['id'] ) ) {
            $atts['id'] = intval( $attr['id'] );
            $is_filter_based = true;
        }
        elseif ( /*! isset( $attr['ids'] ) &&*/ ! $is_filter_based ) {
            $atts['id'] = $post ? intval( $post->ID ) : 0;
        }

        // we need a value for gallery tag attributes
        $id = isset( $attr['id'] ) ? $atts['id'] : 0;


        if ( $is_filter_based ) {

            if ( 'post__in' === $atts['orderby'] ) {
                $query['orderby'] = 'menu_order ID';
            }

            if ( ! empty( $tax_query ) ) {

                $tax_query['relation'] = 'AND';
                $query['tax_query'] = $tax_query;
            }

            if ( isset( $atts['id'] ) ) {
                $query['post_parent'] = intval( $atts['id'] );
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
        else {

            $query['post_parent'] = isset( $atts['id'] ) ? $atts['id'] : 0;

            $attachments = get_children( $query );
        }

        if ( empty( $attachments ) ) {
            return '';
        }

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
            }
            return $output;
        }

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

        /**
         * Filter whether to print default gallery styles.
         *
         * @since 3.1.0
         *
         * @param bool $print Whether to print default gallery styles.
         *                    Defaults to false if the theme supports HTML5 galleries.
         *                    Otherwise, defaults to true.
         */
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
        $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

        /**
         * Filter the default gallery shortcode CSS styles.
         *
         * @since 2.5.0
         *
         * @param string $gallery_style Default CSS styles and opening HTML div container
         *                              for the gallery shortcode output.
         */
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
 *  wpuxss_eml_jp_carousel_force_enable
 *
 *  Ensure Jetpack Carousel compatibility
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
                                else {
                                    #><li>{{wp.media.view.l10n.unattached}}</li><#
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
