<?php

$section = 'mobile_background';

$wp_customize->add_section( $section,
   array(
      'title' => 'Mobile Background',
      'priority' => 40,
      'capability' => 'edit_theme_options',
      'panel' => 'mobile_panel'
   )
);

$wp_customize->add_setting( 'mobile_bg_image',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Upload_Control(
   $wp_customize,
   'mobile_bg_image',
   array(
      'label' => 'Background Image',
      'section' => $section,
      'settings' => 'mobile_bg_image',
      'priority'   => 20
   )
) );

$wp_customize->add_setting( 'mobile_bg_position',
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
        'mobile_bg_position',
        array(
            'label'          => 'Background Image Position',
            'section'        => $section,
            'settings'       => 'mobile_bg_position',
            'type'           => 'select',
            'priority'       => 30,
            'choices'        => array('standard' => 'Standard', 'stretch' => 'Stretched', 'center' => 'Centered'),
            'description'    => 'Note that on iPhone Safari <a href="https://stackoverflow.com/questions/23236158/how-to-replicate-background-attachment-fixed-on-ios" target="_blank">background images cannot be fixed</a>.'
        )
    )
);

$wp_customize->add_setting( 'bg_video_mobile',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Upload_Control(
   $wp_customize,
   'bg_video_mobile',
   array(
      'description' => 'This video should be a .mp4 and portrait format. The video wont have sound on the website.',
      'label' => 'Background Video Mobile',
      'section' => $section,
      'settings' => 'bg_video_mobile',
      'priority'   => 40
   )
) );