<?php

function laybutton1_mouseover_active(){
    return get_theme_mod('laybutton1_use_mouseover', false);
}

$section = 'laybutton1_mouseover';

$wp_customize->add_section( $section,
   array(
      'title' => 'Button 1 Mouseover',
      'priority' => 100,
      'capability' => 'edit_theme_options',
      'panel' => 'laybuttons_panel'
   )
);

$wp_customize->add_setting( 'laybutton1_use_mouseover',
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
        'laybutton1_use_mouseover',
        array(
            'label'          => 'Use Mouseover',
            'section'        => $section,
            'settings'       => 'laybutton1_use_mouseover',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'laybutton1_animate_mouseover',
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
        'laybutton1_animate_mouseover',
        array(
            'label'          => 'Animate Mouseover',
            'section'        => $section,
            'settings'       => 'laybutton1_animate_mouseover',
            'type'           => 'checkbox',
            'priority'       => 0,
            'active_callback' => 'laybutton1_mouseover_active',
        )
    )
);

$wp_customize->add_setting( 'laybutton1_mo_text_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton1_mo_text_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'laybutton1_mo_text_color',
      'priority'   => 10,
      'active_callback' => 'laybutton1_mouseover_active',
   )
) );


$wp_customize->add_setting( 'laybutton1_mo_border_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton1_mo_border_color',
   array(
      'label' => 'Border Color',
      'section' => $section,
      'settings' => 'laybutton1_mo_border_color',
      'priority'   => 10,
      'active_callback' => 'laybutton1_mouseover_active',
   )
) );

$wp_customize->add_setting( 'laybutton1_mo_background_transparent',
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
        'laybutton1_mo_background_transparent',
        array(
            'label'          => 'Transparent Background',
            'section'        => $section,
            'settings'       => 'laybutton1_mo_background_transparent',
            'type'           => 'checkbox',
            'priority'       => 10,
        )
    )
);

$wp_customize->add_setting( 'laybutton1_mo_background_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton1_mo_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'laybutton1_mo_background_color',
      'priority'   => 10,
      'active_callback' => 'laybutton1_mouseover_active',
   )
) );

$wp_customize->add_setting( 'laybutton1_mo_borderwidth',
   array(
      'default' => 1,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_mo_borderwidth',
   array(
      'label' => 'Border Width (px)',
      'section' => $section,
      'settings' => 'laybutton1_mo_borderwidth',
      'type'           => 'number',
      'priority' => 30,
      'active_callback' => 'laybutton1_mouseover_active',
   )
) );