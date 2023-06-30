<?php

$section = 'projectdescr_options';

$wp_customize->add_section( $section, 
   array(
      'title' => 'Project Description',
      'priority' => 30,
      'capability' => 'edit_theme_options',
      'panel' => 'projectlink_panel'
   ) 
);

$wp_customize->add_setting( 'pd_position',
   array(
      'default' => 'below-image',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pd_position',
        array(
            'label'          => 'Position',
            'description'    => 'The "on image" Position depends on the "on image" position of your Project Title. In "Customize" &rarr; "Project Thumbnails" &rarr; "Project Title" the position can be for example "on image bottom left" or "on image top left". This way your Project Description also be "on image bottom left".',
            'section'        => $section,
            'settings'       => 'pd_position',
            'type'           => 'select',
            'choices'        => array('above-image' => 'above image', 'on-image' => 'on image, grouped with Project Title Position', 'below-image' => 'below image'),
            'priority' => 10
        )
    )
);
 

$wp_customize->add_setting( 'pd_visibility',
   array(
      'default' => 'always-show',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pd_visibility',
        array(
            'label'          => 'Visibility',
            'section'        => $section,
            'settings'       => 'pd_visibility',
            'type'           => 'select',
            'choices'        => array('always-show' => 'always show', 'show-on-mouseover' => 'show on mouseover'),
            'priority'       => 0
        )
    )
);

$wp_customize->add_setting( 'pd_animate_visibility',
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
        'pd_animate_visibility',
        array(
            'label'          => 'animate Visibility',
            'section'        => $section,
            'settings'       => 'pd_animate_visibility',
            'type'           => 'checkbox',
            'priority'       => 5,
        )
    )
);

$wp_customize->add_setting( 'pd_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'pd_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'pd_opacity',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'type' => 'number',
      'priority' => 100,
   )
) );

$wp_customize->add_setting( 'pd_spacetop',
   array(
      'default' => '0',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pd_spacetop',
        array(
            'label'          => 'Space Top (px)',
            'section'        => $section,
            'settings'       => 'pd_spacetop',
            'type'           => 'number',
            'priority' => 110,
        )
    )
);

$wp_customize->add_setting( 'pd_spacebottom',
   array(
      'default' => '0',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pd_spacebottom',
        array(
            'label'          => 'Space Bottom (px)',
            'section'        => $section,
            'settings'       => 'pd_spacebottom',
            'type'           => 'number',
            'priority' => 120,
        )
    )
);