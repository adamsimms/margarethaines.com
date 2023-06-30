<?php

function lay_show_add_to_cart_controls(){
    return get_theme_mod('lay_woocommerce_pt_show_add_to_cart_button', 0);
}

function lay_show_add_to_cart_textformat(){
    if( get_theme_mod('lay_woocommerce_pt_show_add_to_cart_button', 0) && get_theme_mod('lay_woocommerce_pt_use_custom_textformat', 0) ) {
        return true;
    }
    return false;
}

$section = 'lay_woocommerce_product_thumbnails';

// taken from woocommerce
if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
    $regen_description = ''; // Nothing to report; Jetpack will handle magically.
} elseif ( apply_filters( 'woocommerce_background_image_regeneration', true ) && ! is_multisite() ) {
    $regen_description = __( 'After publishing your changes, new image sizes will be generated automatically.', 'woocommerce' );
} elseif ( apply_filters( 'woocommerce_background_image_regeneration', true ) && is_multisite() ) {
    /* translators: 1: tools URL 2: regen thumbs url */
    $regen_description = sprintf( __( 'After publishing your changes, new image sizes may not be shown until you regenerate thumbnails. You can do this from the <a href="%1$s" target="_blank">tools section in WooCommerce</a> or by using a plugin such as <a href="%2$s" target="_blank">Regenerate Thumbnails</a>.', 'woocommerce' ), admin_url( 'admin.php?page=wc-status&tab=tools' ), 'https://en-gb.wordpress.org/plugins/regenerate-thumbnails/' );
} else {
    /* translators: %s: regen thumbs url */
    $regen_description = sprintf( __( 'After publishing your changes, new image sizes may not be shown until you <a href="%s" target="_blank">Regenerate Thumbnails</a>.', 'woocommerce' ), 'https://en-gb.wordpress.org/plugins/regenerate-thumbnails/' );
}

$wp_customize->add_section(
    $section,
    array(
        'title'       => 'Product Thumbnails',
        'description' => $regen_description,
        'priority'    => 20,
        'panel'       => 'woocommerce',
    )
);

// https://wordpress.stackexchange.com/questions/258269/how-to-remove-customizers-section-and-move-control-straight-to-panel-using-chil
$control = $wp_customize->get_control( 'woocommerce_thumbnail_cropping' );
if ( $control ) {
    $control->section = $section;
}

// lay theme added
$wp_customize->add_setting( 'lay_woocommerce_image_type',
   array(
      'default' => 'woocommerce',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_image_type',
        array(
            'label'          => 'Thumbnail image type',
            'description'    => '"WooCommerce type" gives you options for cropping. "Lay Theme type" can potentially lead to faster loading and better image quality. "WooCommerce type" is recommended because all images should have the same aspect ratio for the design to work best.',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_image_type',
            'type'           => 'radio',
            'priority'       => -10,
            'choices' => array(
                'woocommerce' => 'WooCommerce type',
                'laytheme' => 'Lay Theme type'
            )
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_thumbnail_image_width',
    array(
    'default' => 300,
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_thumbnail_image_width',
        array(
            'label'          => 'Thumbnail resolution (width in px)',
            'description'    => 'The higher the number, the better the quality and bigger the file size. 600 is a good value.',
            'section'        => $section,
            'settings'       => 'woocommerce_thumbnail_image_width',
            'type'           => 'number',
            'priority'       => 4,
        )
    )
);

// product title textformat
$wp_customize->add_setting( 'lay_woocommerce_pt_textformat',
   array(
      'default' => 'Shop_Product_Thumbnails',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_textformat',
        array(
            'label'          => 'Title Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_textformat',
            'type'           => 'select',
            'priority'       => 10,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

// spacetop
$wp_customize->add_setting( 'lay_woocommerce_pt_spacetop',
   array(
      'default' => '12',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_spacetop',
        array(
            'label'          => 'Title Space Top (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_spacetop',
            'type'           => 'number',
            'priority'       => 20,
        )
    )
);

// product price textformat
$wp_customize->add_setting( 'lay_woocommerce_pt_price_textformat',
   array(
      'default' => 'Shop_Product_Thumbnails',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_price_textformat',
        array(
            'label'          => 'Price Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_price_textformat',
            'type'           => 'select',
            'priority'       => 30,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

// spacetop
$wp_customize->add_setting( 'lay_woocommerce_pt_price_spacetop',
   array(
      'default' => '0',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_price_spacetop',
        array(
            'label'          => 'Price Space Top (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_price_spacetop',
            'type'           => 'number',
            'priority'       => 35,
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_pt_outofstock_textformat',
   array(
      'default' => 'Shop_Small',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_outofstock_textformat',
        array(
            'label'          => '"Out of Stock" Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_outofstock_textformat',
            'type'           => 'select',
            'priority'       => 35,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

// spacetop
$wp_customize->add_setting( 'lay_woocommerce_pt_outofstock_spacetop',
   array(
      'default' => '2',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_outofstock_spacetop',
        array(
            'label'          => '"Out of stock" Space Top (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_outofstock_spacetop',
            'type'           => 'number',
            'priority'       => 37,
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_pt_show_add_to_cart_button',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_show_add_to_cart_button',
        array(
            'label'          => 'Show Add to Cart Button',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_show_add_to_cart_button',
            'type'           => 'checkbox',
            'priority'       => 50,
        )
    )
);

// spacetop
$wp_customize->add_setting( 'lay_woocommerce_pt_cart_button_spacetop',
   array(
      'default' => '15',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_cart_button_spacetop',
        array(
            'label'          => 'Add to Cart Button Space Top (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_cart_button_spacetop',
            'type'           => 'number',
            'priority'       => 51,
            'active_callback' => 'lay_show_add_to_cart_controls',
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_pt_use_custom_textformat',
   array(
      'default' => 1,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_use_custom_textformat',
        array(
            'label'          => 'Use Custom Textformat for Add to Cart Button',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_use_custom_textformat',
            'type'           => 'checkbox',
            'priority'       => 52,
            'active_callback' => 'lay_show_add_to_cart_controls',
        )
    )
);

// textformat
$wp_customize->add_setting( 'lay_woocommerce_pt_add_to_cart_textformat',
   array(
      'default' => 'Shop_Small',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_pt_add_to_cart_textformat',
        array(
            'label'          => 'Add to Cart Button Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_pt_add_to_cart_textformat',
            'type'           => 'select',
            'priority'       => 70,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => 'lay_show_add_to_cart_textformat',
        )
    )
);