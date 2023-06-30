<?php

$section = 'featuredimage_options';

$wp_customize->add_section( $section,
   array(
      'title' => 'Project Thumbnail Mouseover',
      'priority' => 21,
      'capability' => 'edit_theme_options',
      'panel' => 'projectlink_panel'
   )
);


// brightness
$wp_customize->add_setting( 'fi_mo_change_brightness',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_mo_change_brightness',
        array(
            'label'          => 'change Brightness',
            'section'        => $section,
            'settings'       => 'fi_mo_change_brightness',
            'type'           => 'checkbox',
            'priority'       => 1,
            'description' => '(works better than &ldquo;show Background Color&rdquo;)'
        )
    )
);

$wp_customize->add_setting( 'fi_mo_brightness',
   array(
      'default' => '50',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'fi_mo_brightness',
   array(
    'label' => 'Brightness (%)',
    'section' => $section,
    'settings' => 'fi_mo_brightness',
    'input_attrs' => array('min' => '0', 'max' => '200'),
    'description' => 'Can be a value between 0-200',
    'type' => 'number',
    'priority' => 2,
   )
) );

$wp_customize->add_setting( 'fi_mo_animate_brightness',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_mo_animate_brightness',
        array(
            'label'          => 'animate Brightness',
            'section'        => $section,
            'settings'       => 'fi_mo_animate_brightness',
            'type'           => 'checkbox',
            'priority'       => 3,
        )
    )
);
// #brightness

$wp_customize->add_setting( 'fi_mo_show_color',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_mo_show_color',
        array(
            'label'          => 'show Background Color',
            'section'        => $section,
            'settings'       => 'fi_mo_show_color',
            'type'           => 'checkbox',
            'priority'       => 10,
        )
    )
);

$wp_customize->add_setting( 'fi_mo_background_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'fi_mo_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'fi_mo_background_color',
      'priority'   => 15
   )
) );

$wp_customize->add_setting( 'fi_mo_color_opacity',
   array(
      'default' => '50',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'fi_mo_color_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'fi_mo_color_opacity',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'type' => 'number',
      'priority' => 20,
   )
) );

$wp_customize->add_setting( 'fi_animate_color',
   array(
      'default' => true,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_animate_color',
        array(
            'label'          => 'animate Background Color',
            'section'        => $section,
            'settings'       => 'fi_animate_color',
            'type'           => 'checkbox',
            'priority'       => 22,
        )
    )
);

$wp_customize->add_setting( 'fi_mo_do_zoom',
   array(
      'default' => 'none',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh'
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_mo_do_zoom',
        array(
            'label'          => 'Zoom',
            'section'        => $section,
            'settings'       => 'fi_mo_do_zoom',
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array('none' => 'none', '1' => 'zoom in', 'zoom-out' => 'zoom out')
        )
    )
);

$wp_customize->add_setting( 'fi_mo_do_blur',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_mo_do_blur',
        array(
            'label'          => 'blur',
            'section'        => $section,
            'settings'       => 'fi_mo_do_blur',
            'type'           => 'checkbox',
            'priority'       => 30,
        )
    )
);

$wp_customize->add_setting( 'fi_animate_blur',
   array(
      'default' => true,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_animate_blur',
        array(
            'label'          => 'animate blur',
            'section'        => $section,
            'settings'       => 'fi_animate_blur',
            'type'           => 'checkbox',
            'priority'       => 35,
            'description'    => '(pretty slow on most browsers)'
        )
    )
);

$wp_customize->add_setting( 'fi_mo_touchdevice_behaviour',
   array(
      'default' => 'mo_dont_show',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh'
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'fi_mo_touchdevice_behaviour',
        array(
            'label'          => 'Behaviour on Mobile Devices',
            'description'    => 'You need to use a mobile device to test this.',
            'section'        => $section,
            'settings'       => 'fi_mo_touchdevice_behaviour',
            'type'           => 'radio',
            'priority'       => 40,
            'choices'        => array(
               'mo_dont_show' => 'Do not show mouseover state',
               'mo_on_tap_alt' => 'When touching thumbnail, show mouseover state',
               'mo_always' => 'Always show mouseover state',
               'mo_on_tap' => 'Show mouseover state on touch or tap, tap again to enter project'
            )
        )
    )
);

$val = get_option('misc_options_thumbnail_video', '');
if($val == "on" && !MiscOptions::$locked){
    $wp_customize->add_setting( 'fi_mo_video_behaviour',
    array(
       'default' => 'autoplay',
       'type' => 'theme_mod',
       'capability' => 'edit_theme_options',
       'transport' => 'refresh'
    )
 );
 $wp_customize->add_control(
     new WP_Customize_Control(
         $wp_customize,
         'fi_mo_video_behaviour',
         array(
             'label'          => 'Video Thumbnail Behaviour',
             'section'        => $section,
             'settings'       => 'fi_mo_video_behaviour',
             'type'           => 'radio',
             'priority'       => 45,
             'choices'        => array('autoplay' => 'Autoplay', 'play_on_mouseover' => 'Play on mouseover')
         )
     )
 );
}

$val = get_option('misc_options_thumbnail_mouseover_image', '');
if($val == "on"){
    $wp_customize->add_setting( 'thumb_mo_image_has_transition',
    array(
       'default' => false,
       'type' => 'theme_mod',
       'capability' => 'edit_theme_options',
       'transport' => 'refresh'
    )
 );
 $wp_customize->add_control(
     new WP_Customize_Control(
         $wp_customize,
         'thumb_mo_image_has_transition',
         array(
             'label'          => 'Mouseover Image fade on mouseover',
             'section'        => $section,
             'settings'       => 'thumb_mo_image_has_transition',
             'type'           => 'checkbox',
             'priority'       => 50,
         )
     )
 );
}