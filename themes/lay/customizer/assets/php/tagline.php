<?php

function is_tagline_hidden(){
    return get_theme_mod('tagline_hide') == 1 ? false : true;
}

$section = 'tagline_options';

$wp_customize->add_section( $section,
   array(
      'title' => 'Site Tagline',
      'priority' => 20,
      'capability' => 'edit_theme_options',
      'panel' => 'sitetitle_panel'
   )
);

$wp_customize->add_setting( 'tagline_hide',
   array(
      'default' => "1",
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tagline_hide',
        array(
            'label'          => 'hide',
            'section'        => $section,
            'settings'       => 'tagline_hide',
            'type'           => 'checkbox',
            'priority'       => 4,
        )
    )
);

$wp_customize->add_setting( 'blogdescription', array(
    'default'    => get_option( 'blogdescription' ),
    'type'       => 'option',
    'capability' => 'manage_options',
    'transport' => 'refresh',
  )
);

$wp_customize->add_control( 'blogdescription', array(
    'label'      => 'Tagline',
    'section'    => $section,
    'priority'   => 10,
    'type'       => 'textarea',
    'active_callback' => 'is_tagline_hidden'
  )
);

// space top
$wp_customize->add_setting( 'tagline_spacetop',
   array(
      'default' => 5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tagline_spacetop',
        array(
            'label'          => 'Space Top (px)',
            'section'        => $section,
            'settings'       => 'tagline_spacetop',
            'priority'       => 23,
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number',
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_textformat',
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
        'tagline_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'tagline_textformat',
            'type'           => 'select',
            'priority'       => 31,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_fontfamily',
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
        'tagline_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'tagline_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 35,
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_fontsize_mu',
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
        'tagline_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'tagline_fontsize_mu',
            'type'           => 'select',
            'priority'       => 38,
            'choices'        => array('px' => 'px', 'vw' => '%'),
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_fontsize',
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
        'tagline_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'tagline_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 40,
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_fontweight',
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
        'tagline_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'tagline_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 45,
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'tagline_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'tagline_color',
      'priority'   => 50,
      'active_callback' => 'is_tagline_hidden'
   )
) );

$wp_customize->add_setting( 'tagline_letterspacing',
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
        'tagline_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'tagline_letterspacing',
            'input_attrs'    => array('step' => '0.01'),
            'type'           => 'number',
            'priority'       => 55,
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_align',
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
        'tagline_align',
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'tagline_align',
            'type'           => 'select',
            'priority' => 57,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'active_callback' => 'is_tagline_hidden'
        )
    )
);

$wp_customize->add_setting( 'tagline_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'tagline_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'tagline_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 60,
      'active_callback' => 'is_tagline_hidden'
   )
) );
