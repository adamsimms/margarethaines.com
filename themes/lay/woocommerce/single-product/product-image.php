<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$post_thumbnail_id = array( $product->get_image_id() );

$nav = get_theme_mod('lay_woocommerce_singleproduct_show_carousel_buttons', false) ? 'lay-woocommerce-gallery-navigation-enabled' : '';

$html = 
'<div class="lay-woocommerce-gallery swiper-container '.$nav.'">
<div class="swiper-wrapper">';

$attachment_ids = $product->get_gallery_image_ids();
if( get_theme_mod('lay_woocommerce_singleproduct_show_first_image', true) == 1 ) {
    $attachment_ids = array_merge($post_thumbnail_id, $attachment_ids);
}

// error_log(print_r($product, true));
if( method_exists($product, 'get_available_variations') ) {
    $variations = $product->get_available_variations();
    foreach ( $variations as $variation ) {
        $variation_image_id = $variation['image_id'];
        if( !in_array( $variation_image_id, $attachment_ids ) ) {
            $landscape_portrait_class = 'portrait';
            $img = wp_get_attachment_image_src( $variation_image_id );
            if( is_array($img) ) {
                if( $img[1] > $img[2] ) {
                    $landscape_portrait_class = 'landscape';
                }
                
                $variation_data_attributes = '';
    
                $keys = array_keys($variation['attributes']);
                foreach( $keys as $key ) {
                    $variation_data_attributes .= 'data-'.$key.'="'.$variation['attributes'][$key].'" ';
                }
                $html .= '<div style="display:none;" '.$variation_data_attributes.' class="swiper-slide lay-woocommerce-product-variation-slide">'.LayElFunctions::getLazyImgByImageId($variation_image_id).'</div>';
            }
        }
    }
}


if ( $attachment_ids && $product->get_image_id() ) {
	foreach ( $attachment_ids as $attachment_id ) {
        $landscape_portrait_class = 'portrait';
        $img = wp_get_attachment_image_src( $attachment_id );
        if( $img[1] > $img[2] ) {
            $landscape_portrait_class = 'landscape';
        }
        $html .= '<div class="swiper-slide">'.LayElFunctions::getLazyImgByImageId($attachment_id).'</div>';
    }
}

$buttons = get_theme_mod('lay_woocommerce_singleproduct_show_carousel_buttons', false) ? '<div class="swiper-button-next"></div><div class="swiper-button-prev"></div>' : '';

$html .= 
'</div>
'.$buttons.'
<div class="swiper-pagination"></div>
</div>';
echo $html;