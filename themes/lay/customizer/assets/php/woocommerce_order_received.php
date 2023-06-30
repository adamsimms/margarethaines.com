<?php

// note: when adding default shopformats here, they also need to be added to array in row_view.js of formatsmanager
// and in formatsmanager.php so they are added even if they dont exist in the json yet

$section = 'lay_woocommerce_order_received';
$descr = "";

$wp_customize->add_section( $section,
   array(
      'title' => 'Order Received Page',
      'priority' => 99,
      'capability' => 'edit_theme_options',
      'panel' => 'woocommerce',
      'description'    => $descr
   )
);


$wp_customize->add_setting( 'lay_woocommerce_orderpage_thankyou',
   array(
      'default' => 'Shop_Order_Received',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_orderpage_thankyou',
        array(
            'label'          => 'Thank You Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_orderpage_thankyou',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);


$wp_customize->add_setting( 'lay_woocommerce_orderpage_titles',
   array(
      'default' => 'Shop_Order_Received',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_orderpage_titles',
        array(
            'label'          => 'Titles Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_orderpage_titles',
            'type'           => 'select',
            'priority'       => 5,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_orderpage',
   array(
      'default' => 'Shop_Order_Received',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_orderpage',
        array(
            'label'          => 'Copy Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_orderpage',
            'type'           => 'select',
            'priority'       => 5,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);