<?php

function is_mobile_menubar_hidden(){
   return get_theme_mod('mobile_hide_menubar') == 1 ? false : true;
}

function is_mobile_menubar_hidden_and_blurry_active(){
   $mobile_menubar_hidden = get_theme_mod('mobile_hide_menubar') == 1 ? true : false;
   $is_blurry = get_theme_mod('mobile_menu_bar_blurry', false) == 1 ? true : false;
   if( $is_blurry == false || $mobile_menubar_hidden == true ) {
      return false;
   }
   return true;
}

$txtColor = Customizer::$defaults['mobile_menu_txt_color'];
$lighterBgColor = Customizer::$defaults['mobile_menu_light_color'];
$darker = Customizer::$defaults['mobile_menu_dark_color'];

$section = 'mobile_menu_bar';

$wp_customize->add_section( $section,
   array(
      'title' => 'Mobile Menu Bar',
      'priority' => 5,
      'capability' => 'edit_theme_options',
      'panel' => 'mobile_panel',
   )
);

$wp_customize->add_setting( 'mobile_hide_menubar',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_hide_menubar',
        array(
            'label'          => 'hide',
            'section'        => $section,
            'settings'       => 'mobile_hide_menubar',
            'type'           => 'checkbox',
            'priority'       => 5,
        )
    )
);

$wp_customize->add_setting( 'mobile_menubar_height',
   array(
      'default' => 40,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menubar_height',
        array(
            'label'          => 'Height (px)',
            'section'        => $section,
            'settings'       => 'mobile_menubar_height',
            'type'           => 'number',
            'priority'       => 10,
            'active_callback' => 'is_mobile_menubar_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_bar_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'mobile_menu_bar_opacity',
   array(
      'label' => 'Menu Bar Opacity (%)',
      'section' => $section,
      'settings' => 'mobile_menu_bar_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 20,
      'active_callback' => 'is_mobile_menubar_hidden',
   )
) );

$wp_customize->add_setting( 'mobile_menu_bar_blurry',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'mobile_menu_bar_blurry',
   array(
      'label'          => 'make Blurry',
      'section'        => $section,
      'settings'       => 'mobile_menu_bar_blurry',
      'type'           => 'checkbox',
      'priority'       => 22,
      'description' => 'Only works if menubar is a little transparent ("Opacity" less than 100)',
      'active_callback' => 'is_mobile_menubar_hidden',
   )
) );

$wp_customize->add_setting( 'mobile_menu_bar_blur_amount',
   array(
      'default' => '20',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'mobile_menu_bar_blur_amount',
   array(
      'label' => 'Blur Amount (px)',
      'section' => $section,
      'settings' => 'mobile_menu_bar_blur_amount',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 25,
      'active_callback' => 'is_mobile_menubar_hidden_and_blurry_active',
   )
) );

$wp_customize->add_setting( 'mobile_menu_bar_color',
   array(
      'default' => $lighterBgColor,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_bar_color',
   array(
      'label' => 'Menu Bar Background Color',
      'section' => $section,
      'settings' => 'mobile_menu_bar_color',
      'priority'   => 30,
      'active_callback' => 'is_mobile_menubar_hidden',
   )
) );

$wp_customize->add_setting( 'mobile_menu_bar_show_border',
   array(
      'default' => true,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_bar_show_border',
        array(
            'label'          => 'Show Menu Bar Border',
            'section'        => $section,
            'settings'       => 'mobile_menu_bar_show_border',
            'type'           => 'checkbox',
            'priority'       => 35,
            'active_callback' => 'is_mobile_menubar_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_bar_border_color',
   array(
      'default' => $darker,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_bar_border_color',
   array(
      'label' => 'Menu Bar Border Color',
      'section' => $section,
      'settings' => 'mobile_menu_bar_border_color',
      'priority'   => 40,
      'active_callback' => 'is_mobile_menubar_hidden',
   )
) );
