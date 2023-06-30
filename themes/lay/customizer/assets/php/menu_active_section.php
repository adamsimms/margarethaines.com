<?php

$section = 'navigation_active_options';

$wp_customize->add_section( $section, 
    array(
        'title' => 'Menu Point Active',
        'priority' => 40,
        'capability' => 'edit_theme_options',
        'panel' => 'navigation_panel',
        'description' => 'Menu point of current "Project", "Page" or "Category"'
    )
);

$wp_customize->add_setting( 'navactive_color',
    array(
        'default' => Customizer::$defaults['color'],
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize,
    'navactive_color',
    array(
        'label' => 'Text Color',
        'section' => $section,
        'settings' => 'navactive_color',
        'priority'   => 40
    )
) );

$wp_customize->add_setting( 'navactive_opacity',
    array(
        'default' => '100',
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'navactive_opacity',
    array(
        'label' => 'Opacity (%)',
        'section' => $section,
        'settings' => 'navactive_opacity',
        'type'           => 'number',
        'input_attrs' => array('min' => '0', 'max' => '100'),
        'priority' => 41,
    )
) );

$wp_customize->add_setting( 'navactive_fontweight',
    array(
        'default' => Customizer::$defaults['fontweight'],
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    )
);      
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'navactive_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'navactive_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 55
        )
    )
);

$wp_customize->add_setting( 'navactive_underline_strokewidth',
    array(
        'default' => Customizer::$defaults['underline_width'],
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    )
);      
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'navactive_underline_strokewidth',
    array(
        'label' => 'Underline Strokewidth',
        'section' => $section,
        'settings' => 'navactive_underline_strokewidth',
        'type'           => 'number',
        'input_attrs' => array('min' => '1'),
        'priority' => 80,
    )
) );
?>