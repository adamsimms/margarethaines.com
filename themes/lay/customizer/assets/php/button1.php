<?php

$section = 'laybutton1';

$wp_customize->add_section( $section,
   array(
      'title' => 'Button 1',
      'priority' => 100,
      'capability' => 'edit_theme_options',
      'panel' => 'laybuttons_panel'
   )
);

// button 1

$wp_customize->add_setting( 'laybutton1_textformat',
   array(
      'default' => 'Default',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'laybutton1_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'laybutton1_textformat',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'laybutton1_text_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton1_text_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'laybutton1_text_color',
      'priority'   => 10
   )
) );


$wp_customize->add_setting( 'laybutton1_border_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton1_border_color',
   array(
      'label' => 'Border Color',
      'section' => $section,
      'settings' => 'laybutton1_border_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'laybutton1_background_transparent',
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
        'laybutton1_background_transparent',
        array(
            'label'          => 'Transparent Background',
            'section'        => $section,
            'settings'       => 'laybutton1_background_transparent',
            'type'           => 'checkbox',
            'priority'       => 10,
        )
    )
);

$wp_customize->add_setting( 'laybutton1_background_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton1_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'laybutton1_background_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'laybutton1_borderwidth',
   array(
      'default' => 1,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_borderwidth',
   array(
      'label' => 'Border Width (px)',
      'section' => $section,
      'settings' => 'laybutton1_borderwidth',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton1_borderradius',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_borderradius',
   array(
      'label' => 'Border Radius (px)',
      'section' => $section,
      'settings' => 'laybutton1_borderradius',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton1_paddingleftright',
   array(
      'default' => 15,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_paddingleftright',
   array(
      'label' => 'Inner Space Left/Right (px)',
      'section' => $section,
      'settings' => 'laybutton1_paddingleftright',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton1_paddingtop',
   array(
      'default' => 5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_paddingtop',
   array(
      'label' => 'Inner Space Top (px)',
      'section' => $section,
      'settings' => 'laybutton1_paddingtop',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton1_paddingbottom',
   array(
      'default' => 5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_paddingbottom',
   array(
      'label' => 'Inner Space Bottom (px)',
      'section' => $section,
      'settings' => 'laybutton1_paddingbottom',
      'type'           => 'number',
      'priority' => 30,
   )
) );

// outer space
$wp_customize->add_setting( 'laybutton1_marginleftright',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_marginleftright',
   array(
      'label' => 'Outer Space Left/Right (px)',
      'section' => $section,
      'settings' => 'laybutton1_marginleftright',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton1_margintop',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_margintop',
   array(
      'label' => 'Outer Space Top (px)',
      'section' => $section,
      'settings' => 'laybutton1_margintop',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton1_marginbottom',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton1_marginbottom',
   array(
      'label' => 'Outer Space Bottom (px)',
      'section' => $section,
      'settings' => 'laybutton1_marginbottom',
      'type'           => 'number',
      'priority' => 30,
   )
) );