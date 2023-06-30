<?php

$panel = 'lay_css';
      
$wp_customize->add_section( 'desktop_css',
   array(
      'title' => 'Desktop CSS',
      'priority' => 10,
      'capability' => 'edit_theme_options',
      'panel' => $panel
   )
);

$wp_customize->add_setting( 'misc_options_desktop_css',
   array(
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Code_Editor_Control(
        $wp_customize,
        'misc_options_desktop_css',
        array(
            'section'        => 'desktop_css',
            'code_type'      => 'text/css',
        )
    )
);

$wp_customize->add_section( 'mobile_css',
   array(
      'title' => 'Mobile CSS',
      'priority' => 20,
      'capability' => 'edit_theme_options',
      'panel' => $panel
   )
);

$wp_customize->add_setting( 'misc_options_mobile_css',
   array(
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);

$wp_customize->add_control(
    new WP_Customize_Code_Editor_Control(
        $wp_customize,
        'misc_options_mobile_css',
        array(
            'section'        => 'mobile_css',
            'code_type'      => 'text/css',
        )
    )
);

// move wordpress core custom css section into my panel
$custom_css_section = $wp_customize->get_section('custom_css');
$custom_css_section->panel = $panel;
$custom_css_section->title = 'CSS';
$custom_css_section->priority = 0;