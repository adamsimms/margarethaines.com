<?php
$section = 'lay_woocommerce_cart';


$wp_customize->add_section( $section,
   array(
      'title' => 'Cart',
      'priority' => 15,
      'capability' => 'edit_theme_options',
      'panel' => 'woocommerce',
   )
);

// Body
// $wp_customize->add_setting( 'scb-bgcolor',
//    array(
//       'default' => Lay_SideCart::$sidecart_style_options['scb-bgcolor'],
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control( new WP_Customize_Color_Control(
//    $wp_customize,
//    'scb-bgcolor',
//    array(
//       'label' => 'Cart Background Color',
//       'section' => $section,
//       'settings' => 'scb-bgcolor',
//       'priority'   => 30
//    )
// ) );

// $wp_customize->add_setting( 'scb-txtcolor',
//    array(
//       'default' => Lay_SideCart::$sidecart_style_options['scb-txtcolor'],
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control( new WP_Customize_Color_Control(
//    $wp_customize,
//    'scb-txtcolor',
//    array(
//       'label' => 'Cart Text Color',
//       'section' => $section,
//       'settings' => 'scb-txtcolor',
//       'priority'   => 40
//    )
// ) );

$wp_customize->add_setting( 'lay_woocommerce_normal_cart_remove_item_color',
   array(
      'default' => '#aeaeae',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_normal_cart_remove_item_color',
   array(
      'label' => '"Remove" Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_normal_cart_remove_item_color',
      'priority'   => 42
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_cart_product_image_width',
   array(
      'default' => 120,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_cart_product_image_width',
        array(
            'label'          => 'Product Image Width (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_cart_product_image_width',
            'input_attrs'    => array('step' => '1', 'min' => '0', 'max' => '100'),
            'type'           => 'number',
            'priority'       => 45
        )
    )
);

// lines
$wp_customize->add_setting( 'lay_woocommerce_cart_line_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_cart_line_color',
   array(
      'label' => 'Line Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_cart_line_color',
      'priority'   => 50
   )
) );

// products textformat
$wp_customize->add_setting( 'lay_woocommerce_cart_product_textformat',
   array(
      'default' => 'Shop_Cart',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_cart_product_textformat',
        array(
            'label'          => 'Product List Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_cart_product_textformat',
            'type'           => 'select',
            'priority'       => 60,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

// totals textformat
$wp_customize->add_setting( 'lay_woocommerce_cart_collaterals_textformat',
   array(
      'default' => 'Shop_Big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_cart_collaterals_textformat',
        array(
            'label'          => 'Product Totals Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_cart_collaterals_textformat',
            'type'           => 'select',
            'priority'       => 60,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

