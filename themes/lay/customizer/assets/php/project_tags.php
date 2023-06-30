<?php

$section = 'projecttags_options';

$wp_customize->add_section( $section, 
   array(
      'title' => 'Project Tags',
      'priority' => 29,
      'capability' => 'edit_theme_options',
      'panel' => 'projectlink_panel'
   ) 
);

$wp_customize->add_setting( 'ptags_visibility',
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
        'ptags_visibility',
        array(
            'label'          => 'Visibility',
            'section'        => $section,
            'settings'       => 'ptags_visibility',
            'type'           => 'select',
            'choices'        => array('always-show' => 'always show', 'hide' => 'hide'),
            'priority'       => 0
        )
    )
);

$wp_customize->add_setting( 'ptags_spacetop',
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
        'ptags_spacetop',
        array(
            'label'          => 'Space Top (px)',
            'section'        => $section,
            'settings'       => 'ptags_spacetop',
            'type'           => 'number',
            'priority' => 10,
        )
    )
);

$wp_customize->add_setting( 'ptags_spacebottom',
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
        'ptags_spacebottom',
        array(
            'label'          => 'Space Bottom (px)',
            'section'        => $section,
            'settings'       => 'ptags_spacebottom',
            'type'           => 'number',
            'priority' => 20,
        )
    )
);



$wp_customize->add_setting( 'ptags_textformat',
   array(
      'default' => 'Default',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'ptags_textformat',
            'type'           => 'select',
            'priority'       => 30,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'ptags_fontfamily',
   array(
      'default' => Customizer::$defaults['fontfamily'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'ptags_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority' => 40
        )
    )
);

$wp_customize->add_setting( 'ptags_fontsize_mu',
   array(
      'default' => 'px',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'ptags_fontsize_mu',
            'type'           => 'select',
            'priority'       => 50,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'ptags_fontsize',
   array(
      'default' => Customizer::$defaults['fontsize'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'ptags_fontsize',
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number',
            'priority' => 60
        )
    )
);

$wp_customize->add_setting( 'ptags_fontweight',
   array(
      'default' => Customizer::$defaults['fontweight'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'ptags_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 70
        )
    )
);

$wp_customize->add_setting( 'ptags_lineheight',
   array(
      'default' => Customizer::$defaults['lineheight'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_lineheight',
        array(
            'label'          => 'Line Height',
            'section'        => $section,
            'settings'       => 'ptags_lineheight',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.01'),
            'priority'       => 75
        )
    )
);

$wp_customize->add_setting( 'ptags_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'ptags_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'ptags_color',
      'priority' => 80,
   )
) );

$wp_customize->add_setting( 'ptags_letterspacing',
   array(
      'default' => Customizer::$defaults['letterspacing'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'ptags_letterspacing',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.01'),
            'priority'       => 90
        )
    )
);

$wp_customize->add_setting( 'ptags_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'ptags_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'ptags_opacity',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'type' => 'number',
      'priority' => 100,
   )
) );

$wp_customize->add_setting( 'ptags_align',
   array(
      'default' => 'left',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'ptags_align',
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'ptags_align',
            'type'           => 'select',
            'priority' => 110,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right')
        )
    )
);