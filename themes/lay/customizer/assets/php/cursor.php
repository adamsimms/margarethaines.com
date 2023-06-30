<?php

$section = 'cursor';

$wp_customize->add_section( $section,
   array(
      'title' => 'Cursor',
      'priority' => 100,
      'capability' => 'edit_theme_options',
   )
);

$wp_customize->add_setting( 'lay_cursor',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Upload_Control(
   $wp_customize,
   'lay_cursor',
   array(
      'label' => 'Cursor Image',
      'description' => 'Max size: 128px * 128px',
      'section' => $section,
      'settings' => 'lay_cursor',
      'priority'   => 0
   )
) );

$wp_customize->add_setting( 'lay_cursor_x',
    array(
        'default' => '0',
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'lay_cursor_x',
    array(
       'label' => 'Cursor X Click Point',
       'section' => $section,
       'description' => 'Should be 0 or half of image width',
       'settings' => 'lay_cursor_x',
       'type' => 'number',
       'priority' => 11,
    )
) );

$wp_customize->add_setting( 'lay_cursor_y',
    array(
        'default' => '0',
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'lay_cursor_y',
    array(
       'label' => 'Cursor Y Click Point',
       'section' => $section,
       'description' => 'Should be 0 or half of image height',
       'settings' => 'lay_cursor_y',
       'type' => 'number',
       'priority' => 12,
    )
) );