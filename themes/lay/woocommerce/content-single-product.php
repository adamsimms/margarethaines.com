<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$attributes = $product->get_attributes();
// error_log(print_r($attributes, true));
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<?php 

$variations_class = 'lay-no-variations';
if( count($attributes) > 0 ) {
    if( count($attributes) == 1 ) {
        $variations_class = 'lay-variations-count-1';
    } else {
        $variations_class = 'lay-variations-count-more-than-1';
    }
}

$lay_woocommerce_singleproduct_sticky_class = get_theme_mod('lay_woocommerce_singleproduct_sticky', true) == true ? 'lay-woocommerce-sticky' : 'lay-woocommerce-not-sticky';

$lay_woocommerce_singleproduct_show_quantity_input = get_theme_mod('lay_woocommerce_singleproduct_show_quantity_input', false) == true ? '' : 'lay-woocommerce-hide-qty-input';

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    <div class="lay-woocommerce-single-product-wrap <?php echo $lay_woocommerce_singleproduct_show_quantity_input; ?> <?php echo $lay_woocommerce_singleproduct_sticky_class; ?> <?php echo $variations_class ?> <?php echo get_theme_mod('lay_woocommerce_singleproduct_layout_type', 'one_image_per_row'); ?>">
        <?php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action( 'woocommerce_before_single_product_summary' );
        ?>
        <div class="summary entry-summary">
            <div class="lay-woocommerce-summary-inner">
                <?php
                /**
                 * Hook: woocommerce_single_product_summary.
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked WC_Structured_Data::generate_product_data() - 60
                 */
                do_action( 'woocommerce_single_product_summary' );
                ?>
            </div>
        </div>
    </div>
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>