<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
    <div class="lay-woocommerce-product-tab">
        <?php 
        if( count($product_tabs) == 1 ) :
            foreach ( $product_tabs as $key => $product_tab ) : ?>
                <div class="lay-woocommerce-product-text">
                <?php
                if ( isset( $product_tab['callback'] ) ) {
                    call_user_func( $product_tab['callback'], $key, $product_tab );
                }
                ?>
                </div>
            <?php endforeach;
        else:
            foreach ( $product_tabs as $key => $product_tab ) : ?>
                <div class="lay-woocommerce-tab-title <?php echo esc_attr( $key ); ?>-tab-title">
                    <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                    <svg height="9" width="16">
                        <polyline fill="none" stroke="black" points="1,0 8,8 15,0"></polyline>
                    </svg>
                </div>
                <div class="lay-woocommerce-tab-content <?php echo esc_attr( $key ); ?>-tab-content">
                    <?php
                    if ( isset( $product_tab['callback'] ) ) {
                        call_user_func( $product_tab['callback'], $key, $product_tab );
                    }
                    ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php do_action( 'woocommerce_product_after_tabs' ); ?>
<?php endif; ?>
