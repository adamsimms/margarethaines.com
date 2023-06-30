<?php

// selectors to use textformats on:

// price: .woocommerce ul.products li.product .price
// .lay-woocommerce-loop-product__title
// .woocommerce a.button.add_to_cart_button
// .added_to_cart
// .onsale
// .woocommerce-result-count
// .woocommerce-products-header__title    - i want to hide this so i dont need this
// .woocommerce-breadcrumb  - i want to hide this so i dont need this

// .product_title
// .price
// .woocommerce-product-details__short-description
// .quantity
// .single_add_to_cart_button
// .product_meta
// .wc-tabs
// .woocommerce-Tabs-panel
// .woocommerce-Tabs-panel h2
// .cart_totals h2 (on standard cart page)

// style texts in tabs, "description", "Additional information", "reviews"

class WooCommerceFormats {

    public static $Shop_Big = array(
        "formatname" => "Shop_Big",
        "type" => "Paragraph",
        "fontfamily" => "helvetica neue,sans-serif",
        "fontsize" => "24",
        "fontsizemu" => "px",
        "fontweight" => "400",
        "color" => "#000",
        "lineheight" => "1.2",
        "lineheightmu" => "",
        "letterspacing" => "0",
        "spacebottom" => "20",
        "spacebottommu" => "px",
        "spacetop" => "0",
        "spacetopmu" => "px",
        "textalign" => "left",
        "text-indent" => "0",
        "phone-lineheight" => "1.2",
        "phone-lineheightmu" => "",
        "phone-spacetop" => "0",
        "phone-spacetopmu" => "px",
        "phone-spacebottom" => "20",
        "phone-spacebottommu" => "px",
        "phone-fontsize" => "24",
        "phone-fontsizemu" => "px",
        "tablet-lineheight" => "1.2",
        "tablet-lineheightmu" => "",
        "tablet-spacetop" => "0",
        "tablet-spacetopmu" => "px",
        "tablet-spacebottom" => "20",
        "tablet-spacebottommu" => "px",
        "tablet-fontsize" => "24",
        "tablet-fontsizemu" => "px",
        "italic" => false,
        "underline" => false,
        "borderbottom" => false,
        "caps" => false,
        "collapsed" => true,
        'not-deletable' => true
    );

    public static $Shop_Medium = array(
        "formatname" => "Shop_Medium",
        "type" => "Paragraph",
        "fontfamily" => "helvetica neue,sans-serif",
        "fontsize" => "18",
        "fontsizemu" => "px",
        "fontweight" => "400",
        "color" => "#000",
        "lineheight" => "1.2",
        "lineheightmu" => "",
        "letterspacing" => "0",
        "spacebottom" => "20",
        "spacebottommu" => "px",
        "spacetop" => "0",
        "spacetopmu" => "px",
        "textalign" => "left",
        "text-indent" => 0,
        "phone-lineheight" => "1.2",
        "phone-lineheightmu" => "",
        "phone-spacetop" => "0",
        "phone-spacetopmu" => "px",
        "phone-spacebottom" => "20",
        "phone-spacebottommu" => "px",
        "phone-fontsize" => "12",
        "phone-fontsizemu" => "px",
        "tablet-lineheight" => "1.2",
        "tablet-lineheightmu" => "",
        "tablet-spacetop" => "0",
        "tablet-spacetopmu" => "px",
        "tablet-spacebottom" => "20",
        "tablet-spacebottommu" => "px",
        "tablet-fontsize" => "18",
        "tablet-fontsizemu" => "px",
        "italic" => false,
        "underline" => false,
        "borderbottom" => false,
        "caps" => false,
        "collapsed" => true,
        'not-deletable' => true
    );

    public static $Shop_Small = array(
        "formatname" => "Shop_Small",
        "type" => "Paragraph",
        "fontfamily" => "helvetica neue,sans-serif",
        "fontsize" => "14",
        "fontsizemu" => "px",
        "fontweight" => "400",
        "color" => "#000",
        "lineheight" => "1.2",
        "lineheightmu" => "",
        "letterspacing" => "0",
        "spacebottom" => "20",
        "spacebottommu" => "px",
        "spacetop" => "0",
        "spacetopmu" => "px",
        "textalign" => "left",
        "text-indent" => 0,
        "phone-lineheight" => "1.2",
        "phone-lineheightmu" => "",
        "phone-spacetop" => "0",
        "phone-spacetopmu" => "px",
        "phone-spacebottom" => "20",
        "phone-spacebottommu" => "px",
        "phone-fontsize" => "18",
        "phone-fontsizemu" => "px",
        "tablet-lineheight" => "1.2",
        "tablet-lineheightmu" => "",
        "tablet-spacetop" => "0",
        "tablet-spacetopmu" => "px",
        "tablet-spacebottom" => "20",
        "tablet-spacebottommu" => "px",
        "tablet-fontsize" => "14",
        "tablet-fontsizemu" => "px",
        "italic" => false,
        "underline" => false,
        "borderbottom" => false,
        "caps" => false,
        "collapsed" => true,
        'not-deletable' => true
    );

    public static $Shop_Product_Thumbnails = array(
        "formatname" => "Shop_Product_Thumbnails",
        "type" => "Paragraph",
        "fontfamily" => "helvetica neue,sans-serif",
        "fontsize" => "21",
        "fontsizemu" => "px",
        "fontweight" => "400",
        "color" => "#000",
        "lineheight" => "1.2",
        "lineheightmu" => "",
        "letterspacing" => "0",
        "spacebottom" => "20",
        "spacebottommu" => "px",
        "spacetop" => "0",
        "spacetopmu" => "px",
        "textalign" => "left",
        "text-indent" => 0,
        "phone-lineheight" => "1.2",
        "phone-lineheightmu" => "",
        "phone-spacetop" => "0",
        "phone-spacetopmu" => "px",
        "phone-spacebottom" => "20",
        "phone-spacebottommu" => "px",
        "phone-fontsize" => "18",
        "phone-fontsizemu" => "px",
        "tablet-lineheight" => "1.2",
        "tablet-lineheightmu" => "",
        "tablet-spacetop" => "0",
        "tablet-spacetopmu" => "px",
        "tablet-spacebottom" => "20",
        "tablet-spacebottommu" => "px",
        "tablet-fontsize" => "21",
        "tablet-fontsizemu" => "px",
        "italic" => false,
        "underline" => false,
        "borderbottom" => false,
        "caps" => false,
        "collapsed" => true,
        'not-deletable' => true
    );

    public static $Shop_Order_Received = array(
        "formatname" => "Shop_Order_Received",
        "type" => "Paragraph",
        "fontfamily" => "helvetica neue,sans-serif",
        "fontsize" => "21",
        "fontsizemu" => "px",
        "fontweight" => "400",
        "color" => "#000",
        "lineheight" => "1.2",
        "lineheightmu" => "",
        "letterspacing" => "0",
        "spacebottom" => "20",
        "spacebottommu" => "px",
        "spacetop" => "0",
        "spacetopmu" => "px",
        "textalign" => "left",
        "text-indent" => 0,
        "phone-lineheight" => "1.2",
        "phone-lineheightmu" => "",
        "phone-spacetop" => "0",
        "phone-spacetopmu" => "px",
        "phone-spacebottom" => "20",
        "phone-spacebottommu" => "px",
        "phone-fontsize" => "18",
        "phone-fontsizemu" => "px",
        "tablet-lineheight" => "1.2",
        "tablet-lineheightmu" => "",
        "tablet-spacetop" => "0",
        "tablet-spacetopmu" => "px",
        "tablet-spacebottom" => "20",
        "tablet-spacebottommu" => "px",
        "tablet-fontsize" => "21",
        "tablet-fontsizemu" => "px",
        "italic" => false,
        "underline" => false,
        "borderbottom" => false,
        "caps" => false,
        "collapsed" => true,
        'not-deletable' => true
    );

    public static $Shop_Cart = array(
        "formatname" => "Shop_Cart",
        "type" => "Paragraph",
        "fontfamily" => "helvetica neue,sans-serif",
        "fontsize" => "14",
        "fontsizemu" => "px",
        "fontweight" => "400",
        "color" => "#000",
        "lineheight" => "1.2",
        "lineheightmu" => "",
        "letterspacing" => "0",
        "spacebottom" => "20",
        "spacebottommu" => "px",
        "spacetop" => "0",
        "spacetopmu" => "px",
        "textalign" => "left",
        "text-indent" => 0,
        "phone-lineheight" => "1.2",
        "phone-lineheightmu" => "",
        "phone-spacetop" => "0",
        "phone-spacetopmu" => "px",
        "phone-spacebottom" => "20",
        "phone-spacebottommu" => "px",
        "phone-fontsize" => "14",
        "phone-fontsizemu" => "px",
        "tablet-lineheight" => "1.2",
        "tablet-lineheightmu" => "",
        "tablet-spacetop" => "0",
        "tablet-spacetopmu" => "px",
        "tablet-spacebottom" => "20",
        "tablet-spacebottommu" => "px",
        "tablet-fontsize" => "14",
        "tablet-fontsizemu" => "px",
        "italic" => false,
        "underline" => false,
        "borderbottom" => false,
        "caps" => false,
        "collapsed" => true,
        'not-deletable' => true
    );

}

new WooCommerceFormats();