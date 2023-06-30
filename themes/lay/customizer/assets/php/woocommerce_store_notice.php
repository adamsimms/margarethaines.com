<?php
$section = 'woocommerce_store_notice';

function lay_is_dismiss_button_active(){
   if( lay_storenotice_shown() == false ){
      return false;
   }
   return get_theme_mod('lay_woocommerce_show_dismiss_button', 1) == 1 ? true : false; 
}

function lay_storenotice_shown(){
   $demostore = get_option( 'woocommerce_demo_store', 'no' );
   $return = $demostore == 'no' || $demostore == '' ? false : true;
   // error_log(print_r($return, true));
   return $return;
}

$wp_customize->add_setting( 'lay_woocommerce_show_dismiss_button',
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
        'lay_woocommerce_show_dismiss_button',
        array(
            'label'          => 'Show Close Button',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_show_dismiss_button',
            'priority'       => 10,
            'type'           => 'checkbox',
            'active_callback' => 'lay_storenotice_shown'
        )
    )
);

// $wp_customize->add_setting( 'lay_woocommerce_dismiss_button_text',
//    array(
//       'default' => 'Close',
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'lay_woocommerce_dismiss_button_text',
//         array(
//             'label'          => 'Close Button Text',
//             'section'        => $section,
//             'settings'       => 'lay_woocommerce_dismiss_button_text',
//             'priority'       => 10,
//             'type'           => 'text',
//             'active_callback' => 'lay_is_dismiss_button_active'
//         )
//     )
// );

// spaceright
$wp_customize->add_setting( 'lay_woocommerce_store_notice_spaceright_mu',
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
        'lay_woocommerce_store_notice_spaceright_mu',
        array(
            'label'          => 'Close Button Space Right in',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_store_notice_spaceright_mu',
            'type'           => 'select',
            'priority'       => 11,
            'choices'        => array('%' => '%', 'px' => 'px'),
            'active_callback' => 'lay_is_dismiss_button_active'
        )
    )
);
$wp_customize->add_setting( 'lay_woocommerce_store_notice_spaceright',
   array(
      'default' => 12,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_store_notice_spaceright',
        array(
            'label'          => 'Close Button Space Right',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_store_notice_spaceright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 12,
            'active_callback' => 'lay_is_dismiss_button_active'
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_store_notice_background_color',
   array(
      'default' => '#e4e6e6',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_store_notice_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_store_notice_background_color',
      'priority'   => 14,
      'active_callback' => 'lay_storenotice_shown'
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_store_notice_textformat',
   array(
      'default' => 'Shop_Medium',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_store_notice_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_store_notice_textformat',
            'type'           => 'select',
            'priority'       => 20,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => 'lay_storenotice_shown'
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_store_notice_text_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_store_notice_text_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_store_notice_text_color',
      'priority'   => 30,
      'active_callback' => 'lay_storenotice_shown'
   )
) );

$wp_customize->add_setting( 'lay_woocommerce_store_notice_bottom_border_width',
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
        'lay_woocommerce_store_notice_bottom_border_width',
        array(
            'label'          => 'Border Width (px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_store_notice_bottom_border_width',
            'priority'       => 40,
            'input_attrs'    => array('step' => '1', 'min' => 0),
            'type'           => 'number',
            'active_callback' => 'lay_storenotice_shown'
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_store_notice_bottom_border_color',
   array(
      'default' => '#e4e6e6',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'lay_woocommerce_store_notice_bottom_border_color',
   array(
      'label' => 'Border Color',
      'section' => $section,
      'settings' => 'lay_woocommerce_store_notice_bottom_border_color',
      'priority'   => 50,
      'active_callback' => 'lay_storenotice_shown'
   )
) );