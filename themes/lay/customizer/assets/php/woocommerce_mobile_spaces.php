<?php

$section = 'lay_woocommerce_mobile_spaces';
$descr = "";

$wp_customize->add_section( $section,
   array(
      'title' => 'WooCommerce Mobile Spaces',
      'priority' => 1,
      'capability' => 'edit_theme_options',
      'panel' => 'woocommerce',
      'description'    => $descr
   )
);

$wp_customize->add_setting( 'lay_woocommerce_mobile_space_leftright',
   array(
      'default' => 15,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_mobile_space_leftright',
        array(
            'label'          => 'Space left and right of Content (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_mobile_space_leftright',
            'type'           => 'number',
            'priority'       => 30
        )
    )
);


$wp_customize->add_setting( 'lay_woocommerce_mobile_space_top',
   array(
      'default' => 15,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_mobile_space_top',
        array(
            'label'          => 'Space Top (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_mobile_space_top',
            'type'           => 'number',
            'priority'       => 40
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_mobile_space_bottom',
   array(
      'default' => 25,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_mobile_space_bottom',
        array(
            'label'          => 'Space Bottom (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_mobile_space_bottom',
            'type'           => 'number',
            'priority'       => 50
        )
    )
);