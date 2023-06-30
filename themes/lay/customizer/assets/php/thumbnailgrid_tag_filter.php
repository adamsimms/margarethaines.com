<?php

$section = 'thumbnailgrid_tag_filter';

$wp_customize->add_section( $section,
   array(
      'title' => 'Thumbnail Grid Tag Filter',
      'priority' => 11,
      'capability' => 'edit_theme_options',
      'panel' => 'projectlink_panel',
      'description' => '<p>These are settings for the Tag Filter of a Thumbnail Grid Element.</p><p>How to activate the Tag Filter: Check "Show Tag Filter" when adding a Thumbnail Grid via "+More" &rarr; "+Thumbnail Grid" in the Gridder.</p>'
   )
);

$wp_customize->add_setting( 'tgtf_spacebetween',
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
        'tgtf_spacebetween',
        array(
            'label'          => 'Space between Tags (px)',
            'section'        => $section,
            'settings'       => 'tgtf_spacebetween',
            'type'           => 'number',
            'priority'       => 2,
            'input_attrs'    => array('step' => '1', 'min' => 0),
        )
    )
);

$wp_customize->add_setting( 'tgtf_spacebelow',
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
        'tgtf_spacebelow',
        array(
            'label'          => 'Space below (px)',
            'section'        => $section,
            'settings'       => 'tgtf_spacebelow',
            'type'           => 'number',
            'priority'       => 5,
            'input_attrs'    => array('step' => '1', 'min' => 0),
        )
    )
);


$wp_customize->add_setting( 'tgtf_textformat',
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
        'tgtf_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'tgtf_textformat',
            'type'           => 'select',
            'priority'       => 10,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);
$wp_customize->selective_refresh->add_partial( 'tgtf_textformat', array(
    'selector' => '.lay-thumbnailgrid-tagfilter',
    'container_inclusive' => false,
    'render_callback' => function() {
        echo LayThumnbailgridFunctions::lay_get_thumbnailgrid_tagfilter_markup();
    },
) );

$wp_customize->add_setting( 'tgtf_fontfamily',
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
        'tgtf_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'tgtf_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 35
        )
    )
);

$wp_customize->add_setting( 'tgtf_fontsize_mu',
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
        'tgtf_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'tgtf_fontsize_mu',
            'type'           => 'select',
            'priority'       => 38,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'tgtf_fontsize',
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
        'tgtf_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'tgtf_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 40
        )
    )
);

$wp_customize->add_setting( 'tgtf_fontweight',
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
        'tgtf_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'tgtf_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 45
        )
    )
);

$wp_customize->add_setting( 'tgtf_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'tgtf_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'tgtf_color',
      'priority'   => 50
   )
) );

$wp_customize->add_setting( 'tgtf_letterspacing',
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
        'tgtf_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'tgtf_letterspacing',
            'input_attrs'    => array('step' => '0.01'),
            'type'           => 'number',
            'priority'       => 55
        )
    )
);

$wp_customize->add_setting( 'tgtf_bubble_color',
   array(
      'default' => '#eeeeee',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'tgtf_bubble_color',
   array(
      'label' => 'Bubble Color',
      'section' => $section,
      'settings' => 'tgtf_bubble_color',
      'priority'   => 60
   )
) );

$wp_customize->add_setting( 'tgtf_bubble_active_color',
   array(
      'default' => '#d0d0d0',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'tgtf_bubble_active_color',
   array(
      'label' => 'Active/Mouseover Bubble Color',
      'section' => $section,
      'settings' => 'tgtf_bubble_active_color',
      'priority'   => 65
   )
) );

$wp_customize->add_setting( 'tgtf_bubble_border_radius',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tgtf_bubble_border_radius',
        array(
            'label'          => 'Bubble Border Radius',
            'section'        => $section,
            'settings'       => 'tgtf_bubble_border_radius',
            'type'           => 'number',
            'input_attrs'    => array('min' => '0', 'step' => '1'),
            'priority'       => 70
        )
    )
);

$wp_customize->add_setting( 'tgtf_oneline',
   array(
      'default' => get_theme_mod('tgtf_oneline', 1),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'tgtf_oneline',
        array(
            'label'          => 'For Mobile put tags in a scrollable line',
            'section'        => $section,
            'settings'       => 'tgtf_oneline',
            'type'           => 'checkbox',
            'priority'       => 80,
        )
    )
);

$wp_customize->add_setting( 'tgtf_spacebetween_mobile',
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
        'tgtf_spacebetween_mobile',
        array(
            'label'          => 'Mobile Space between Tags (px)',
            'section'        => $section,
            'settings'       => 'tgtf_spacebetween_mobile',
            'type'           => 'number',
            'priority'       => 90,
            'input_attrs'    => array('step' => '1', 'min' => 0),
        )
    )
);