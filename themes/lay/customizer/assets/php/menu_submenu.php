<?php

$section = 'menu_submenu';

function lay_show_menu_submenu_keep_open(){
   $mod = get_theme_mod('menu_submenu_show_on', 'hover');
   return $mod == 'click';
}

$wp_customize->add_section( $section, 
   array(
      'title' => 'Submenus',
      'priority' => 60,
      'capability' => 'edit_theme_options',
      'panel' => 'navigation_panel',
      'description' => 'Create a submenu in "Appearances" &rarr; "Menus" by drag and dropping menu points.'
   ) 
);

$wp_customize->add_setting( 'menu_submenu_textformat',
    array(
    'default' => get_theme_mod('nav_textformat', 'Default'),
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'menu_submenu_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'menu_submenu_textformat',
            'type'           => 'select',
            'priority'       => -1,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => 'is_mobile_menu_hidden'
        )
    )
);

$wp_customize->add_setting( 'menu_submenu_show_on',
   array(
      'default' => 'hover',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'menu_submenu_show_on',
        array(
            'label'          => 'Show submenu on',
            'section'        => $section,
            'settings'       => 'menu_submenu_show_on',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => array('hover' => 'mouse over', 'click' => 'click', 'always' => 'always show'),
        )
    )
);

$wp_customize->add_setting( 'menu_submenu_keep_open',
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
        'menu_submenu_keep_open',
        array(
            'label'          => 'Keep Submenu open on submenu link click',
            'section'        => $section,
            'settings'       => 'menu_submenu_keep_open',
            'type'           => 'checkbox',
            'priority'       => 1,
            'active_callback' => 'lay_show_menu_submenu_keep_open',
        )
    )
);

$wp_customize->add_setting( 'menu_submenu_type',
   array(
      'default' => 'vertical',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'menu_submenu_type',
        array(
            'label'          => 'Submenu Type',
            'section'        => $section,
            'settings'       => 'menu_submenu_type',
            'type'           => 'select',
            'priority'       => 5,
            'choices'        => array('vertical' => 'vertical', 'horizontal' => 'horizonal'),
            'description' => 'If the menu points alignment of your menu is "vertical", the submenu type will always be vertical too.'
        )
    )
);

$wp_customize->add_setting( 'menu_submenu_spacetop',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'menu_submenu_spacetop',
   array(
      'label' => 'Space between Submenu and Menu (px)',
      'section' => $section,
      'settings' => 'menu_submenu_spacetop',
      'type'           => 'number',
      'input_attrs' => array('min' => '0', 'step' => 1),
      'priority' => 10,
   )
) );

$wp_customize->add_setting( 'menu_submenu_spacearound',
   array(
      'default' => 10,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'menu_submenu_spacearound',
   array(
      'label' => 'Space Around (px)',
      'section' => $section,
      'settings' => 'menu_submenu_spacearound',
      'type'           => 'number',
      'input_attrs' => array('min' => '1', 'step' => 1),
      'priority' => 20,
   )
) );

$wp_customize->add_setting( 'menu_submenu_space_between_submenu_points',
   array(
      'default' => 4,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'menu_submenu_space_between_submenu_points',
   array(
      'label' => 'Space between Submenu Points (px)',
      'section' => $section,
      'settings' => 'menu_submenu_space_between_submenu_points',
      'type'           => 'number',
      'input_attrs' => array('min' => '0', 'step' => 1),
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'menu_submenu_show_background',
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
        'menu_submenu_show_background',
        array(
            'label'          => 'Show Background',
            'section'        => $section,
            'settings'       => 'menu_submenu_show_background',
            'type'           => 'checkbox',
            'priority'       => 40,
        )
    )
);

$wp_customize->add_setting( 'menu_submenu_background_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'menu_submenu_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'menu_submenu_background_color',
      'priority'   => 50
   )
) );

$wp_customize->add_setting( 'menu_submenu_background_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'menu_submenu_background_opacity',
   array(
      'label' => 'Background Opacity (%)',
      'section' => $section,
      'settings' => 'menu_submenu_background_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 60,
   )
) );

$wp_customize->add_setting( 'menu_submenu_blurry',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'menu_submenu_blurry',
   array(
      'label'          => 'make blurry',
      'section'        => $section,
      'settings'       => 'menu_submenu_blurry',
      'type'           => 'checkbox',
      'priority'       => 70,
      'description' => 'Only works if background is a little transparent ("Opacity" less than 100)'
   )
) );

$wp_customize->add_setting( 'menu_submenu_blur_amount',
   array(
      'default' => '20',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'menu_submenu_blur_amount',
   array(
      'label' => 'Blur Amount (px)',
      'section' => $section,
      'settings' => 'menu_submenu_blur_amount',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 80,
   )
) );