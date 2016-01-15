<?php



/**
 *  wpuxss_eml_shortcode_atts_gallery
 *
 *  @since    2.1.5
 *  @created  12/01/16
 */

add_filter( 'shortcode_atts_gallery', 'wpuxss_eml_shortcode_atts_gallery', 10, 3 );

if ( ! function_exists( 'wpuxss_eml_shortcode_atts_gallery' ) ) {

    function wpuxss_eml_shortcode_atts_gallery( $out, $pairs, $atts ) {

        $is_filter_based = false;
        $id = isset( $atts['id'] ) ? intval( $atts['id'] ) : 0;


        // enforce order defaults
        $pairs['order'] = 'ASC';
        $pairs['orderby'] = 'menu_order ID';


        foreach ( $pairs as $name => $default ) {
    		if ( array_key_exists( $name, $atts ) )
    			$out[$name] = $atts[$name];
    		else
    			$out[$name] = $default;
    	}


        if ( isset( $atts['monthnum'] ) && isset( $atts['year'] ) ) {
            $is_filter_based = true;
        }


        $tax_query = array();

        foreach ( get_taxonomies_for_attachments( 'names' ) as $taxonomy ) {

            if ( isset( $atts[$taxonomy] ) ) {

                $terms = explode( ',', $atts[$taxonomy] );

                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $terms,
                    'operator' => 'IN',
                );

                $is_filter_based = true;
            }
        }


        if ( ! $is_filter_based ) {
            return $out;
        }


        $ids = array();

        $query = array(
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $out['order'],
            'orderby' => $out['orderby'],
            'posts_per_page' => isset( $atts['limit'] ) ? intval( $atts['limit']  ) : -1, //TODO: add pagination
            'fields' => 'ids'
        );

        if ( isset( $atts['monthnum'] ) && isset( $atts['year'] ) ) {

            $query['monthnum'] = $atts['monthnum'];
            $query['year'] = $atts['year'];
        }

        if ( 'post__in' === $out['orderby'] ) {
            $query['orderby'] = 'menu_order ID';
        }

        if ( ! empty( $tax_query ) ) {

            $tax_query['relation'] = 'AND';
            $query['tax_query'] = $tax_query;
        }

        if ( $id ) {
            $query['post_parent'] = $id;
        }

        $ids = get_posts( $query );

        if ( ! empty( $ids ) ) {
            $out['include'] = implode( ',', $ids );
        }

        return $out;
    }
}

?>
