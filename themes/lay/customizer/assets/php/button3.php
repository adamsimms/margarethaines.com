<?php
// button 3

$section = 'laybutton3';

$wp_customize->add_section( $section,
   array(
      'title' => 'Button 3',
      'priority' => 100,
      'capability' => 'edit_theme_options',
      'panel' => 'laybuttons_panel'
   )
);

$wp_customize->add_setting( 'laybutton3_textformat',
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
        'laybutton3_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'laybutton3_textformat',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'laybutton3_text_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton3_text_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'laybutton3_text_color',
      'priority'   => 10
   )
) );


$wp_customize->add_setting( 'laybutton3_border_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton3_border_color',
   array(
      'label' => 'Border Color',
      'section' => $section,
      'settings' => 'laybutton3_border_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'laybutton3_background_transparent',
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
        'laybutton3_background_transparent',
        array(
            'label'          => 'Transparent Background',
            'section'        => $section,
            'settings'       => 'laybutton3_background_transparent',
            'type'           => 'checkbox',
            'priority'       => 10,
        )
    )
);

$wp_customize->add_setting( 'laybutton3_background_color',
   array(
      'default' => '#eeeeee',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'laybutton3_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'laybutton3_background_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'laybutton3_borderwidth',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_borderwidth',
   array(
      'label' => 'Border Width (px)',
      'section' => $section,
      'settings' => 'laybutton3_borderwidth',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton3_borderradius',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_borderradius',
   array(
      'label' => 'Border Radius (px)',
      'section' => $section,
      'settings' => 'laybutton3_borderradius',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton3_paddingleftright',
   array(
      'default' => 20,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_paddingleftright',
   array(
      'label' => 'Inner Space Left/Right (px)',
      'section' => $section,
      'settings' => 'laybutton3_paddingleftright',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton3_paddingtop',
   array(
      'default' => 5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_paddingtop',
   array(
      'label' => 'Inner Space Top (px)',
      'section' => $section,
      'settings' => 'laybutton3_paddingtop',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton3_paddingbottom',
   array(
      'default' => 5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_paddingbottom',
   array(
      'label' => 'Inner Space Bottom (px)',
      'section' => $section,
      'settings' => 'laybutton3_paddingbottom',
      'type'           => 'number',
      'priority' => 30,
   )
) );


// outer space
$wp_customize->add_setting( 'laybutton3_marginleftright',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_marginleftright',
   array(
      'label' => 'Outer Space Left/Right (px)',
      'section' => $section,
      'settings' => 'laybutton3_marginleftright',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton3_margintop',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_margintop',
   array(
      'label' => 'Outer Space Top (px)',
      'section' => $section,
      'settings' => 'laybutton3_margintop',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'laybutton3_marginbottom',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'laybutton3_marginbottom',
   array(
      'label' => 'Outer Space Bottom (px)',
      'section' => $section,
      'settings' => 'laybutton3_marginbottom',
      'type'           => 'number',
      'priority' => 30,
   )
) );