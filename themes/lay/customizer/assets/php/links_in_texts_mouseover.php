<?php

$section = 'links_in_texts_mouseover_options';
$panel = 'linksintexts_panel';

$wp_customize->add_section( $section, 
   array(
      'title' => 'Links in Texts Mouseover',
      'priority' => 10,
      'capability' => 'edit_theme_options',
      'panel' => $panel
   ) 
);

$wp_customize->add_setting( 'link_hover_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'link_hover_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'link_hover_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'link_hover_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'link_hover_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'link_hover_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 20,
   )
) );

$wp_customize->add_setting( 'link_hover_underline_strokewidth',
   array(
      'default' => get_theme_mod('link_underline_strokewidth', 1),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'link_hover_underline_strokewidth',
   array(
      'label' => 'Underline Strokewidth',
      'section' => $section,
      'settings' => 'link_hover_underline_strokewidth',
      'type'           => 'number',
      'priority' => 30,
   )
) );

$wp_customize->add_setting( 'link_hover_fontweight',
   array(
      'default' => get_theme_mod('link_fontweight', 'default'),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'link_hover_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'link_hover_fontweight',
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array(
                'default' => 'Default',
                '100' => 'Thin (100)',
                '200' => 'Extra Light (200)',
                '300' => 'Light (300)',
                '400' => 'Normal (400)',
                '500' => 'Medium (500)',
                '600' => 'Semi Bold (600)',
                '700' => 'Bold (700)',
                '800' => 'Extra Bold (800)',
                '900' => 'Black (900)'
            )
        )
    )
);