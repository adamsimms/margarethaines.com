<?php

$section = 'thumbnailgrid_filter';

$wp_customize->add_section( $section,
   array(
      'title' => 'Thumbnail Grid Category Filter',
      'priority' => 10,
      'capability' => 'edit_theme_options',
      'panel' => 'projectlink_panel',
      'description' => '<p>These are settings for the Category Filter of a Thumbnail Grid Element.</p><p>How to activate the Category Filter: Check "Show Category Filter" when adding a Thumbnail Grid via "+More" &rarr; "+Thumbnail Grid" in the Gridder.</p>'
   )
);

$wp_customize->add_setting( 'tgf_transition',
   array(
      'default' => 'fade_out_fade_in_2',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tgf_transition',
        array(
            'label'          => 'Transition',
            'section'        => $section,
            'settings'       => 'tgf_transition',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => array( 'fade_out_fade_in_2' => 'Fade out fade in 2', 'fade_out_fade_in' => 'Fade out fade in', 'none' => 'None' )
        )
    )
);

$wp_customize->add_setting( 'tgf_spacebetween_2',
   array(
      'default' => '10',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tgf_spacebetween_2',
        array(
            'label'          => 'Space between (px)',
            'section'        => $section,
            'settings'       => 'tgf_spacebetween_2',
            'type'           => 'number',
            'priority'       => 2,
            'input_attrs'    => array('step' => '1', 'min' => 0),
        )
    )
);


$wp_customize->add_setting( 'tgf_spacebelow',
   array(
      'default' => '20',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tgf_spacebelow',
        array(
            'label'          => 'Space below (px)',
            'section'        => $section,
            'settings'       => 'tgf_spacebelow',
            'type'           => 'number',
            'priority'       => 5,
            'input_attrs'    => array('step' => '1', 'min' => 0),
        )
    )
);


$wp_customize->add_setting( 'tgf_textformat',
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
        'tgf_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'tgf_textformat',
            'type'           => 'select',
            'priority'       => 10,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);
$wp_customize->selective_refresh->add_partial( 'tgf_textformat', array(
    'selector' => '.lay-thumbnailgrid-filter',
    'container_inclusive' => false,
    'render_callback' => function() {
        echo LayThumnbailgridFunctions::lay_get_thumbnailgrid_category_filter_markup();
    },
) );

$wp_customize->add_setting( 'tgf_fontfamily',
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
        'tgf_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'tgf_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 35
        )
    )
);

$wp_customize->add_setting( 'tgf_fontsize_mu',
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
        'tgf_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'tgf_fontsize_mu',
            'type'           => 'select',
            'priority'       => 38,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'tgf_fontsize',
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
        'tgf_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'tgf_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 40
        )
    )
);

$wp_customize->add_setting( 'tgf_fontweight',
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
        'tgf_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'tgf_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 45
        )
    )
);

$wp_customize->add_setting( 'tgf_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'tgf_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'tgf_color',
      'priority'   => 50
   )
) );

$wp_customize->add_setting( 'tgf_letterspacing',
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
        'tgf_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'tgf_letterspacing',
            'input_attrs'    => array('step' => '0.01'),
            'type'           => 'number',
            'priority'       => 55
        )
    )
);

$wp_customize->add_setting( 'tgf_align',
   array(
      'default' => 'left',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tgf_align',
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'tgf_align',
            'type'           => 'select',
            'priority' => 57,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
        )
    )
);

$wp_customize->add_setting( 'tgf_opacity',
   array(
      'default' => 50,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'tgf_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'tgf_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 60,
   )
) );

$wp_customize->add_setting( 'tgf_mouseover_opacity',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'tgf_mouseover_opacity',
   array(
      'label' => 'Mouseover Opacity (%)',
      'section' => $section,
      'settings' => 'tgf_mouseover_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 65,
   )
) );


$wp_customize->add_setting( 'tgf_active_color',
   array(
      'default' => get_theme_mod('tgf_active_color', Customizer::$defaults['color']),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'tgf_active_color',
   array(
      'label' => 'Active Text Color',
      'section' => $section,
      'settings' => 'tgf_active_color',
      'priority'   => 70
   )
) );

$wp_customize->add_setting( 'tgf_active_opacity',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'tgf_active_opacity',
   array(
      'label' => 'Active Opacity (%)',
      'section' => $section,
      'settings' => 'tgf_active_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 70,
   )
) );

$wp_customize->add_setting( 'tgf_active_strokewidth',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'tgf_active_strokewidth',
   array(
      'label' => 'Active Underline Strokewidth',
      'description' => 'Underline Offset settings are the ones used in "Customize" → "Links in Texts"',
      'section' => $section,
      'settings' => 'tgf_active_strokewidth',
      'type'           => 'number',
      'priority' => 75,
   )
) );

$wp_customize->add_setting( 'tgf_oneline',
   array(
      'default' => get_theme_mod('tgf_oneline', 1),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tgf_oneline',
        array(
            'label'          => 'For Mobile put tags in a scrollable line',
            'section'        => $section,
            'settings'       => 'tgf_oneline',
            'type'           => 'checkbox',
            'priority'       => 80,
        )
    )
);

$wp_customize->add_setting( 'tgf_spacebetween_mobile',
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
        'tgf_spacebetween_mobile',
        array(
            'label'          => 'Mobile Space between (px)',
            'section'        => $section,
            'settings'       => 'tgf_spacebetween_mobile',
            'type'           => 'number',
            'priority'       => 90,
            'input_attrs'    => array('step' => '1', 'min' => 0),
        )
    )
);