<?php
// todo: see if default values are ok
$section = 'lay_woocommerce_sidecart';


$wp_customize->add_section( $section,
   array(
      'title' => 'Side Cart',
      'priority' => 20,
      'capability' => 'edit_theme_options',
      'panel' => 'woocommerce',
   )
);

$wp_customize->add_setting( 'scm-width',
   array(
      'default' => Lay_SideCart::$sidecart_style_options['scm-width'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'scm-width',
        array(
            'label'          => 'Width (px)',
            'section'        => $section,
            'settings'       => 'scm-width',
            'input_attrs'    => array('step' => '1', 'min' => '0'),
            'type'           => 'number',
            'priority'       => 0
        )
    )
);

// Header
// $wp_customize->add_setting( 'sch-txtcolor',
//    array(
//       'default' => Lay_SideCart::$sidecart_style_options['sch-txtcolor'],
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control( new WP_Customize_Color_Control(
//    $wp_customize,
//    'sch-txtcolor',
//    array(
//       'label' => 'Header Text Color',
//       'section' => $section,
//       'settings' => 'sch-txtcolor',
//       'priority'   => 10
//    )
// ) );

// $wp_customize->add_setting( 'sch-bgcolor',
//    array(
//       'default' => Lay_SideCart::$sidecart_style_options['sch-bgcolor'],
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control( new WP_Customize_Color_Control(
//    $wp_customize,
//    'sch-bgcolor',
//    array(
//       'label' => 'Header Background Color',
//       'section' => $section,
//       'settings' => 'sch-bgcolor',
//       'priority'   => 20
//    )
// ) );

// Body
$wp_customize->add_setting( 'scb-bgcolor',
   array(
      'default' => Lay_SideCart::$sidecart_style_options['scb-bgcolor'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'scb-bgcolor',
   array(
      'label' => 'Cart Background Color',
      'section' => $section,
      'settings' => 'scb-bgcolor',
      'priority'   => 30
   )
) );

$wp_customize->add_setting( 'scb-txtcolor',
   array(
      'default' => Lay_SideCart::$sidecart_style_options['scb-txtcolor'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'scb-txtcolor',
   array(
      'label' => 'Cart Text Color',
      'section' => $section,
      'settings' => 'scb-txtcolor',
      'priority'   => 40
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_remove_item_color',
   array(
      'default' => '#aeaeae',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_remove_item_color',
   array(
      'label' => '"Remove" Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_remove_item_color',
      'priority'   => 42
   )
) );

$wp_customize->add_setting( 'scbp-imgw',
   array(
      'default' => Lay_SideCart::$sidecart_style_options['scbp-imgw'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'scbp-imgw',
        array(
            'label'          => 'Product Image Width (%)',
            'section'        => $section,
            'settings'       => 'scbp-imgw',
            'input_attrs'    => array('step' => '1', 'min' => '0', 'max' => '100'),
            'type'           => 'number',
            'priority'       => 45
        )
    )
);

// lines
$wp_customize->add_setting( 'lay_woocommerce_sidecart_line_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_sidecart_line_color',
   array(
      'label' => 'Line Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_sidecart_line_color',
      'priority'   => 50
   )
) );

// header textformat
// $wp_customize->add_setting( 'lay_woocommerce_sidecart_header_textformat',
//    array(
//       'default' => 'Default',
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'lay_woocommerce_sidecart_header_textformat',
//         array(
//             'label'          => 'Header Text Format',
//             'section'        => $section,
//             'settings'       => 'lay_woocommerce_sidecart_header_textformat',
//             'type'           => 'select',
//             'priority'       => 60,
//             'choices'        => Customizer::$textformatsSelect
//         )
//     )
// );

// body textformat
$wp_customize->add_setting( 'lay_woocommerce_sidecart_body_textformat',
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
        'lay_woocommerce_sidecart_body_textformat',
        array(
            'label'          => 'Body Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_sidecart_body_textformat',
            'type'           => 'select',
            'priority'       => 60,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

// footer textformat
$wp_customize->add_setting( 'lay_woocommerce_sidecart_footer_textformat',
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
        'lay_woocommerce_sidecart_footer_textformat',
        array(
            'label'          => 'Subtotal Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_sidecart_footer_textformat',
            'type'           => 'select',
            'priority'       => 60,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_sidecart_background_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_sidecart_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_sidecart_background_color',
      'priority'   => 70
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_sidecart_background_opacity',
   array(
      'default' => 30,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_sidecart_background_opacity',
        array(
            'label'          => 'Background Opacity',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_sidecart_background_opacity',
            'input_attrs'    => array('step' => '1', 'min' => '0', 'max' => '100'),
            'type'           => 'number',
            'priority'       => 80
        )
    )
);