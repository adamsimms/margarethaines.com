<?php

$section = 'links_in_texts_options';
$panel = 'linksintexts_panel';

$wp_customize->add_section( $section,
   array(
      'title' => 'Links in Texts',
      'priority' => 10,
      'capability' => 'edit_theme_options',
      'panel' => $panel
   )
);

$wp_customize->add_setting( 'link_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'link_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'link_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'link_underline_strokewidth',
   array(
      'default' => 1,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'link_underline_strokewidth',
   array(
      'label' => 'Underline Strokewidth',
      'section' => $section,
      'settings' => 'link_underline_strokewidth',
      'type'           => 'number',
      'priority' => 20,
   )
) );

$wp_customize->add_setting( 'link_underline_offset_mu',
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
        'link_underline_offset_mu',
        array(
            'label'          => 'Underline Offset in',
            'section'        => $section,
            'settings'       => 'link_underline_offset_mu',
            'description'    => '"Em" is based on font size.',
            'type'           => 'select',
            'priority'       => 20,
            'choices'        => array('px' => 'px', 'em' => 'em')
        )
    )
);

$wp_customize->add_setting( 'link_underline_offset',
   array(
      'default' => 3,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'link_underline_offset',
   array(
      'label' => 'Underline Offset',
      'section' => $section,
      'settings' => 'link_underline_offset',
      'type'           => 'number',
      'priority' => 20,
   )
) );


$wp_customize->add_setting( 'link_fontweight',
   array(
      'default' => 'default',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'link_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'link_fontweight',
            'type'           => 'select',
            'priority'       => 20,
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