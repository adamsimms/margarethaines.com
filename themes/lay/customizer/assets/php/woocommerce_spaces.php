<?php

$section = 'lay_woocommerce_spaces';
$descr = "";

$wp_customize->add_section( $section,
   array(
      'title' => 'WooCommerce Spaces',
      'priority' => 0,
      'capability' => 'edit_theme_options',
      'panel' => 'woocommerce',
      'description'    => $descr
   )
);

$wp_customize->add_setting( 'lay_woocommerce_space_leftright_mu',
   array(
      'default' => 'vw',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_space_leftright_mu',
        array(
            'label'          => 'Space left and right of Content in',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_space_leftright_mu',
            'type'           => 'select',
            'priority'       => 29,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'lay_woocommerce_space_leftright',
   array(
      'default' => 2,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_space_leftright',
        array(
            'label'          => 'Space left and right of Content',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_space_leftright',
            'type'           => 'number',
            'priority'       => 30
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_space_top_mu',
   array(
      'default' => 'px',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_space_top_mu',
        array(
            'label'          => 'Space Top in',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_space_top_mu',
            'type'           => 'select',
            'priority'       => 39,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'lay_woocommerce_space_top',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_space_top',
        array(
            'label'          => 'Space Top',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_space_top',
            'type'           => 'number',
            'priority'       => 40
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_space_bottom_mu',
   array(
      'default' => 'px',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_space_bottom_mu',
        array(
            'label'          => 'Space Bottom in',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_space_bottom_mu',
            'type'           => 'select',
            'priority'       => 49,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'lay_woocommerce_space_bottom',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_space_bottom',
        array(
            'label'          => 'Space Bottom',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_space_bottom',
            'type'           => 'number',
            'priority'       => 50
        )
    )
);