<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );


// wc_get_template( 'archive-product.php' );

$cat = get_queried_object();
$catID = $cat->term_id;

$config = array(
    'limit' => '-1',
    'paginate' => '',
    'orderby' => 'date',
    'skus' => '',
    'category' => '',
	'tag' => array
		(
			array
				(
					'label' => $cat->name,
					'value' => $cat->slug,
				)
		),
    'order' => 'ASC',
    'on_sale' => '',
    'best_selling' => '',
    'top_rated' => '',
    'desktop' => array
        (
            'colCount' => 4,
            'colGutter' => 2,
            'rowGutter' => 4
		),
    'tablet' => array
        (
            'colCount' => 3,
            'colGutter' => 3,
            'rowGutter' => 5
		),
    'phone' => array
        (
            'colCount' => 2,
            'colGutter' => 4,
            'rowGutter' => 8
		),
    'layoutType' => 'top-aligned',
    'id' => 'm_kv6rlneb_x5bynf449786sihwf166u'
);
// putting "lay-woocommerce" container around this so we get spaces
echo '<div id="lay-woocommerce"><div id="grid">'.Lay_WooCommerce::build_lay_products_markup($config).'</div></div>';

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

/* todo: see what the following line does */
get_footer( 'shop' );