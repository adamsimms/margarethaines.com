<?php
$section = 'mobile_menu_icons';

function is_icon_color_active(){
   if( get_theme_mod('burger_icon_type', 'default_thin') == 'default' ){
      return true;
   }
   if( get_theme_mod('burger_icon_type', 'default_thin') == 'default_thin' ){
      return true;
   }
   if( get_theme_mod('burger_icon_type', 'default_thin') == 'new' ){
      return true;
   }
   return false;
}
function is_burger_type_not_custom(){
   return get_theme_mod('burger_icon_type', 'default_thin') == 'custom' ? false : true;
}
function is_burger_type_custom(){
    return get_theme_mod('burger_icon_type', 'default_thin') == 'custom' ? true : false;
}
function show_space_options(){
   if( get_theme_mod('burger_icon_type', 'default_thin') == 'custom' ? true : false ) {
      return true;
   }
   if( get_theme_mod('mobile_hide_menubar') == 1 ) {
      return true;
   }
   return false;
}
$wp_customize->add_setting( 'burger_icon_type',
   array(
      'default' => 'default',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'burger_icon_type',
        array(
            'label'          => 'Burger Icon Type',
            'section'        => $section,
            'settings'       => 'burger_icon_type',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => array('default' => 'Default', 'default_thin' => 'Default Thin', 'new' => 'New', 'custom' => 'Custom')
        )
    )
);

$wp_customize->add_setting( 'mobile_burger_icon_animate',
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
        'mobile_burger_icon_animate',
        array(
            'label'          => 'Animate Burger',
            'section'        => $section,
            'settings'       => 'mobile_burger_icon_animate',
            'type'           => 'checkbox',
            'priority'       => 0,
            'active_callback'=> 'is_burger_type_not_custom'
        )
    )
);

$wp_customize->add_section( $section,
   array(
      'title' => 'Mobile Menu Icons',
      'priority' => 5,
      'capability' => 'edit_theme_options',
      'panel' => 'mobile_panel',
   )
);

$txtColor = Customizer::$defaults['mobile_menu_txt_color'];
$wp_customize->add_setting( 'mobile_menu_burger_icon_color',
   array(
      'default' => $txtColor,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_burger_icon_color',
   array(
      'label' => 'Burger Icon Color',
      'section' => $section,
      'settings' => 'mobile_menu_burger_icon_color',
      'priority'   => 1,
      'active_callback' => 'is_icon_color_active',
   )
) );

$wp_customize->add_setting( 'mobile_menu_icon_burger',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'mobile_menu_icon_burger',
  array(
    'label'      => 'Burger Icon',
    'section'    => $section,
    'settings'   => 'mobile_menu_icon_burger',
    'description' => 'Can be a SVG',
    'priority'   => 0,
    'active_callback' => 'is_burger_type_custom',
  ) )
);

$wp_customize->add_setting( 'mobile_menu_icon_burger_width',
   array(
      'default' => '25',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_icon_burger_width',
        array(
            'label'          => 'Burger Icon Width (px)',
            'section'        => $section,
            'settings'       => 'mobile_menu_icon_burger_width',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 5,
            'active_callback' => 'is_burger_type_custom',
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_icon_burger_spacetop',
   array(
      'default' => '10',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_icon_burger_spacetop',
        array(
            'label'          => 'Space Top Burger Icon (px)',
            'section'        => $section,
            'settings'       => 'mobile_menu_icon_burger_spacetop',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 10,
            'active_callback' => 'show_space_options',
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_icon_burger_spaceright',
   array(
      'default' => '10',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_icon_burger_spaceright',
        array(
            'label'          => 'Space Right Burger Icon (px)',
            'section'        => $section,
            'settings'       => 'mobile_menu_icon_burger_spaceright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 20,
            'active_callback' => 'show_space_options',
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_icon_close',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'mobile_menu_icon_close',
  array(
    'label'      => 'Close Icon',
    'section'    => $section,
    'settings'   => 'mobile_menu_icon_close',
    'description' => 'Can be a SVG',
    'priority'   => 40,
    'active_callback' => 'is_burger_type_custom',
  ) )
);

$wp_customize->add_setting( 'mobile_menu_icon_close_width',
   array(
      'default' => '25',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_icon_close_width',
        array(
            'label'          => 'Close Icon Width (px)',
            'section'        => $section,
            'settings'       => 'mobile_menu_icon_close_width',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 45,
            'active_callback' => 'is_burger_type_custom',
        )
    )
);

// $wp_customize->add_setting( 'mobile_menu_icon_close_spacetop',
//    array(
//       'default' => '10',
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'mobile_menu_icon_close_spacetop',
//         array(
//             'label'          => 'Space Top Close Icon (px)',
//             'section'        => $section,
//             'settings'       => 'mobile_menu_icon_close_spacetop',
//             'type'           => 'number',
//             'input_attrs'    => array('step' => '1'),
//             'priority'       => 50,
//             'active_callback' => 'is_burger_type_custom',
//         )
//     )
// );

// $wp_customize->add_setting( 'mobile_menu_icon_close_spaceright',
//    array(
//       'default' => '10',
//       'type' => 'theme_mod',
//       'capability' => 'edit_theme_options',
//       'transport' => 'refresh',
//    )
// );
// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'mobile_menu_icon_close_spaceright',
//         array(
//             'label'          => 'Space Right Close Icon (px)',
//             'section'        => $section,
//             'settings'       => 'mobile_menu_icon_close_spaceright',
//             'type'           => 'number',
//             'input_attrs'    => array('step' => '1'),
//             'priority'       => 60,
//             'active_callback' => 'is_burger_type_custom',
//         )
//     )
// );