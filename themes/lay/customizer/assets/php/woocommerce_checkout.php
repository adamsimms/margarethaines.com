<?php
$section = 'woocommerce_checkout';

// textformat
$wp_customize->add_setting( 'lay_woocommerce_checkout_product_textformat',
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
        'lay_woocommerce_checkout_product_textformat',
        array(
            'label'          => 'Checkout Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_checkout_product_textformat',
            'type'           => 'select',
            'priority'       => 20,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);


$wp_customize->add_setting( 'lay_woocommerce_checkout_order_review',
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
        'lay_woocommerce_checkout_order_review',
        array(
            'label'          => 'Checkout Totals Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_checkout_order_review',
            'type'           => 'select',
            'priority'       => 30,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);


$wp_customize->add_setting( 'lay_woocommerce_checkout_payment',
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
        'lay_woocommerce_checkout_payment',
        array(
            'label'          => 'Checkout Payment Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_checkout_payment',
            'type'           => 'select',
            'priority'       => 40,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);