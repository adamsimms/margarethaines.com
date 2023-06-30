<?php

function laybutton3_mouseover_active(){
    return get_theme_mod('laybutton3_use_mouseover', false);
}
$section = 'laybutton3_mouseover';

$wp_customize->add_section( $section,
   array(
      'title' => 'Button 3 Mouseover',
      'priority' => 100,
      'capability' => 'edit_theme_options',
      'panel' => 'laybuttons_panel'
   )
);

$wp_customize->add_setting( 'laybutton3_use_mouseover',
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
        'laybutton3_use_mouseover',
        array(
            'label'          => 'Use Mouseover',
            'section'        => $section,
            'settings'       => 'laybutton3_use_mouseover',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'laybutton3_animate_mouseover',
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
        'laybutton3_animate_mouseover',
        array(
            'label'          => 'Animate Mouseover',
            'section'        => $section,
            'settings'       => 'laybutton3_animate_mouseover',
            'type'           => 'checkbox',
            'priority'       => 0,
            'active_callback' => 'laybutton3_mouseover_active',
        )
    )
);

// button 3
$wp_customize->add_setting( 'laybutton3_mo_text_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton3_mo_text_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'laybutton3_mo_text_color',
      'priority'   => 10,
      'active_callback' => 'laybutton3_mouseover_active',
   )
) );


$wp_customize->add_setting( 'laybutton3_mo_border_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton3_mo_border_color',
   array(
      'label' => 'Border Color',
      'section' => $section,
      'settings' => 'laybutton3_mo_border_color',
      'priority'   => 10,
      'active_callback' => 'laybutton3_mouseover_active',
   )
) );

$wp_customize->add_setting( 'laybutton3_mo_background_transparent',
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
        'laybutton3_mo_background_transparent',
        array(
            'label'          => 'Transparent Background',
            'section'        => $section,
            'settings'       => 'laybutton3_mo_background_transparent',
            'type'           => 'checkbox',
            'priority'       => 10,
        )
    )
);

$wp_customize->add_setting( 'laybutton3_mo_background_color',
   array(
      'default' => '#eeeeee',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton3_mo_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'laybutton3_mo_background_color',
      'priority'   => 10,
      'active_callback' => 'laybutton3_mouseover_active',
   )
) );

$wp_customize->add_setting( 'laybutton3_mo_borderwidth',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_mo_borderwidth',
   array(
      'label' => 'Border Width (px)',
      'section' => $section,
      'settings' => 'laybutton3_mo_borderwidth',
      'type'           => 'number',
      'priority' => 30,
      'active_callback' => 'laybutton3_mouseover_active',
   )
) );