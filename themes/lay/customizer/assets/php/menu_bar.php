<?php

$section = 'navigationbar_options';

$wp_customize->add_section( $section, 
   array(
      'title' => 'Menu Bar',
      'priority' => 60,
      'capability' => 'edit_theme_options',
      'panel' => 'navigation_panel',
      'description' => 'These options are for a fixed background bar for the primary menu.'
   ) 
);

$wp_customize->add_setting( 'navbar_hide',
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
        'navbar_hide',
        array(
            'label'          => 'hide',
            'section'        => $section,
            'settings'       => 'navbar_hide',
            'type'           => 'checkbox',
            'priority'       => 4,
        )
    )
);

// navbar hide on scroll down
// for backwards compatibility, default is: $mod = get_theme_mod('nav_hidewhenscrolling', "");
$navbar_hidewhenscrolling_default = get_theme_mod('nav_hidewhenscrolling', "");
$wp_customize->add_setting( 'navbar_hidewhenscrolling',
   array(
      'default' => $navbar_hidewhenscrolling_default,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'navbar_hidewhenscrolling',
        array(
            'label'          => 'move away when scrolling down',
            'section'        => $section,
            'settings'       => 'navbar_hidewhenscrolling',
            'type'           => 'checkbox',
            'priority'       => 7,
        )
    )
);

$navbar_fadeout_whenscrolling_default = get_theme_mod('fadeout_whenscrolling', "");
$wp_customize->add_setting( 'navbar_fadeout_whenscrolling',
   array(
      'default' => $navbar_fadeout_whenscrolling_default,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'navbar_fadeout_whenscrolling',
        array(
            'label'          => 'fade out when scrolling down',
            'section'        => $section,
            'settings'       => 'navbar_fadeout_whenscrolling',
            'type'           => 'checkbox',
            'priority'       => 7,
        )
    )
);

$wp_customize->add_setting( 'navbar_height_mu',
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
        'navbar_height_mu',
        array(
            'label'          => 'Height in',
            'section'        => $section,
            'settings'       => 'navbar_height_mu',
            'type'           => 'select',
            'priority'       => 11,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'navbar_height',
   array(
      'default' => '60',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'navbar_height',
        array(
            'label'          => 'Height',
            'section'        => $section,
            'settings'       => 'navbar_height',
            'type'           => 'number',
            'priority'       => 21,
            'input_attrs'    => array('step' => '0.1')
        )
    )
);

$wp_customize->add_setting( 'navbar_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'navbar_color',
   array(
      'label' => 'Color',
      'section' => $section,
      'settings' => 'navbar_color',
      'priority'   => 40
   )
) );

$wp_customize->add_setting( 'navbar_opacity',
   array(
      'default' => '90',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'navbar_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'navbar_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 41,
   )
) );

$wp_customize->add_setting( 'navbar_blurry',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'navbar_blurry',
   array(
      'label'          => 'make blurry',
      'section'        => $section,
      'settings'       => 'navbar_blurry',
      'type'           => 'checkbox',
      'priority'       => 43,
      'description' => 'Only works if menubar is a little transparent ("Opacity" less than 100)'
   )
) );

$wp_customize->add_setting( 'navbar_blur_amount',
   array(
      'default' => '20',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'navbar_blur_amount',
   array(
      'label' => 'Blur Amount (px)',
      'section' => $section,
      'settings' => 'navbar_blur_amount',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 44,
   )
) );

$wp_customize->add_setting( 'navbar_show_border',
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
        'navbar_show_border',
        array(
            'label'          => 'show border',
            'section'        => $section,
            'settings'       => 'navbar_show_border',
            'type'           => 'checkbox',
            'priority'       => 50,
        )
    )
);

$wp_customize->add_setting( 'navbar_border_color',
   array(
      'default' => '#ccc',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'navbar_border_color',
   array(
      'label' => 'Border color',
      'section' => $section,
      'settings' => 'navbar_border_color',
      'priority'   => 55
   )
) );