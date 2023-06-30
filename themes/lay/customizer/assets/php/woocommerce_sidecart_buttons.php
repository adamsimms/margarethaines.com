<?php
$section = 'lay_woocommerce_sidecart_buttons';

function lay_sidecart_show_button_border_width(){
   return get_theme_mod('lay_woocommerce_sidecart_button_style', 'filled') == 'outlines' ? true : false;
}

$wp_customize->add_section(
    $section,
    array(
        'title'       => 'Side Cart Buttons',
        'priority'    => 21,
        'panel'       => 'woocommerce',
    )
);

$wp_customize->add_setting( 'lay_woocommerce_sidecart_button_textformat',
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
        'lay_woocommerce_sidecart_button_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_sidecart_button_textformat',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

// $wp_customize->add_setting( 'lay_woocommerce_sidecart_button_style',
//    array(
//       'default' => 'filled',
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh'
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'lay_woocommerce_sidecart_button_style',
//         array(
//             'label'          => 'Button Style',
//             'section'        => $section,
//             'settings'       => 'lay_woocommerce_sidecart_button_style',
//             'type'           => 'radio',
//             'priority'       => 5,
//             'choices'        => array(
//                'filled' => 'Filled',
//                'outlines' => 'Outlines'
//             )
//         )
//     )
// );

// $wp_customize->add_setting( 'lay_woocommerce_sidecart_button_border_width',
//    array(
//       'default' => 2,
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'lay_woocommerce_sidecart_button_border_width',
//         array(
//             'label'          => 'Border Width (px)',
//             'section'        => $section,
//             'settings'       => 'lay_woocommerce_sidecart_button_border_width',
//             'priority'       => 6,
//             'input_attrs'    => array('step' => '1', 'min' => 0),
//             'type'           => 'number',
//             'active_callback' => 'lay_sidecart_show_button_border_width'
//         )
//     )
// );

// $wp_customize->add_setting( 'lay_woocommerce_sidecart_button_border_radius',
//    array(
//       'default' => 0,
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'lay_woocommerce_sidecart_button_border_radius',
//         array(
//             'label'          => 'Border Roundness (px)',
//             'section'        => $section,
//             'settings'       => 'lay_woocommerce_sidecart_button_border_radius',
//             'priority'       => 7,
//             'input_attrs'    => array('step' => '1', 'min' => 0),
//             'type'           => 'number'
//         )
//     )
// );

$wp_customize->add_setting( 'lay_woocommerce_sidecart_button_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_sidecart_button_color',
   array(
      'label' => 'Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_sidecart_button_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_sidecart_mouseover_button_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_sidecart_mouseover_button_color',
   array(
      'label' => 'Mouseover Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_sidecart_mouseover_button_color',
      'priority'   => 20
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_sidecart_animate_mouseover_button_color',
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
        'lay_woocommerce_sidecart_animate_mouseover_button_color',
        array(
            'label'          => 'Animate Mouseover Color',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_sidecart_animate_mouseover_button_color',
            'type'           => 'checkbox',
            'priority'       => 30,
        )
    )
);

// $wp_customize->add_setting( 'lay_woocommerce_sidecart_button_padding_left_right',
//    array(
//       'default' => 20,
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'lay_woocommerce_sidecart_button_padding_left_right',
//         array(
//             'label'          => 'Padding Left/Right (px)',
//             'section'        => $section,
//             'settings'       => 'lay_woocommerce_sidecart_button_padding_left_right',
//             'priority'       => 40,
//             'input_attrs'    => array('step' => '1', 'min' => 0),
//             'type'           => 'number'
//         )
//     )
// );

$wp_customize->add_setting( 'lay_woocommerce_sidecart_button_padding_top_bottom',
   array(
      'default' => 17,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_sidecart_button_padding_top_bottom',
        array(
            'label'          => 'Padding Top/Bottom (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_sidecart_button_padding_top_bottom',
            'priority'       => 50,
            'input_attrs'    => array('step' => '1', 'min' => 0),
            'type'           => 'number'
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_sidecart_button_text_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_sidecart_button_text_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_sidecart_button_text_color',
      'priority'   => 60
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_sidecart_button_mouseover_text_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_sidecart_button_mouseover_text_color',
   array(
      'label' => 'Mouseover Text Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_sidecart_button_mouseover_text_color',
      'priority'   => 70
   )
) );
