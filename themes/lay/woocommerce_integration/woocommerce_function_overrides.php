<?php

// using filters to overwrite this didn't work for me so I'm just using function overrides

function woocommerce_output_content_wrapper() {
    ?>
    <div id="lay-woocommerce">
    <?php
}

function woocommerce_output_content_wrapper_end() {
    ?>
    </div>
    <?php
}

function woocommerce_template_loop_product_title() {
    global $product;
    $temp_price_html = $product->get_price_html();
    $price_html = '';
    if ( $temp_price_html ){
        $price_html = $temp_price_html;
    }
    $show_add_to_cart_button = get_theme_mod('lay_woocommerce_pt_show_add_to_cart_button', 0);
    $add_to_cart_button = '';
    if( $show_add_to_cart_button ) {
        $add_to_cart_button = do_shortcode( '[add_to_cart id="'.$product->get_id().'"]' );
    }
    $out_of_stock = ( !$product->managing_stock() && !$product->is_in_stock() ) ? '<div class="_'.get_theme_mod('lay_woocommerce_pt_outofstock_textformat', 'Shop_Small').'_no_spaces lay_woocommerce_product_thumbnail-out_of_stock">Out of stock</div>' : '';
    echo 
    '<div class="lay_woocommerce_product_thumbnail_title_wrap">
        <div class="lay_woocommerce_product_thumbnail_title_left">
            <div class="_'.get_theme_mod('lay_woocommerce_pt_textformat', 'Shop_Product_Thumbnails').'_no_spaces lay-woocommerce-product-thumbnail-title '.esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">'.get_the_title().'</div>
            <div class="_'.get_theme_mod('lay_woocommerce_pt_price_textformat', 'Shop_Product_Thumbnails').'_no_spaces lay-woocommerce-product-thumbnail-price">'.$price_html.'</div>
            '.$out_of_stock.'
        </div>
        <div class="lay_woocommerce_product_thumbnail_title_right">
            '.$add_to_cart_button.'
        </div>
    </div>';
}

/**
 * Adds a demo store banner to the site if enabled.
 */
function woocommerce_demo_store() {
    if ( ! is_store_notice_showing() ) {
        return;
    }

    $notice = get_option( 'woocommerce_demo_store_notice' );

    if ( empty( $notice ) ) {
        $notice = __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'woocommerce' );
    }

    $notice_id = md5( $notice );
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo apply_filters( 'woocommerce_demo_store', '<p class="woocommerce-store-notice demo_store" data-notice-id="' . esc_attr( $notice_id ) . '" style="display:none;">' . wp_kses_post( $notice ) . ' <a href="#" class="woocommerce-store-notice__dismiss-link"></a></p>', $notice );
}

function wc_dropdown_variation_attribute_options( $args = array() ) {
    $args = wp_parse_args(
        apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ),
        array(
            'options'          => false,
            'attribute'        => false,
            'product'          => false,
            'selected'         => false,
            'name'             => '',
            'id'               => '',
            'class'            => '',
            'show_option_none' => __( 'Choose an option', 'woocommerce' ),
        )
    );

    // Get selected value.
    if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
        $selected_key = 'attribute_' . sanitize_title( $args['attribute'] );
        // phpcs:disable WordPress.Security.NonceVerification.Recommended
        $args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] );
        // phpcs:enable WordPress.Security.NonceVerification.Recommended
    }

    $options               = $args['options'];
    $product               = $args['product'];
    $attribute             = $args['attribute'];
    $name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
    $id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
    $class                 = $args['class'];
    $show_option_none      = (bool) $args['show_option_none'];
    $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
        $attributes = $product->get_variation_attributes();
        $options    = $attributes[ $attribute ];
    }

    $html  = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" placeholder="'.esc_attr( wc_attribute_label( $attribute ) ).'" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    $html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

    if ( ! empty( $options ) ) {
        if ( $product && taxonomy_exists( $attribute ) ) {
            // Get terms if this is a taxonomy - ordered. We need the names too.
            $terms = wc_get_product_terms(
                $product->get_id(),
                $attribute,
                array(
                    'fields' => 'all',
                )
            );

            foreach ( $terms as $term ) {
                if ( in_array( $term->slug, $options, true ) ) {
                    $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</option>';
                }
            }
        } else {
            foreach ( $options as $option ) {
                // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
                $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
                $html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
            }
        }
    }

    $html .= '</select>';

    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args );
}