<?php

$section = 'background_options';

$wp_customize->add_section( $section,
   array(
      'title' => 'Background',
      'priority' => 40,
      'capability' => 'edit_theme_options',
   )
);

$wp_customize->add_setting( 'bg_color',
   array(
      'default' => '#ffffff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'bg_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'bg_color',
      'priority'   => 10
   )
) );

$wp_customize->add_setting( 'bg_image',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Upload_Control(
   $wp_customize,
   'bg_image',
   array(
      'label' => 'Background Image Desktop',
      'section' => $section,
      'settings' => 'bg_image',
      'priority'   => 20
   )
) );

$wp_customize->add_setting( 'bg_position',
   array(
      'default' => 'standard',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'bg_position',
        array(
            'label'          => 'Background Image Position',
            'section'        => $section,
            'settings'       => 'bg_position',
            'type'           => 'select',
            'priority'       => 30,
            'choices'        => array('standard' => 'Standard', 'stretch' => 'Stretched and Fixed', 'center' => 'Centered and Fixed')
        )
    )
);


$wp_customize->add_setting( 'bg_video',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Upload_Control(
   $wp_customize,
   'bg_video',
   array(
      'description' => 'This video should be a .mp4 and landscape format. The video wont have sound on the website.',
      'label' => 'Background Video Desktop',
      'section' => $section,
      'settings' => 'bg_video',
      'priority'   => 40
   )
) );