<?php

$section = 'intro_section';

// seems that option "intro_use_svg_overlay" is only saved, when "update" is clicked in customizer 
// so it seems like i cannot use "active callback" with the function below, because it won't actually show/hide controls unless "update" is clicked in the customizer
// i just changed to to be a theme mod instead of an option
function lay_is_intro_svg_overlay_active(){
    return get_theme_mod('intro_use_svg_overlay', 0) == 1 ? true : false;
}

$wp_customize->add_section( $section,
   array(
      'title' => 'Intro',
      'priority' => 45,
      'capability' => 'edit_theme_options',
      'active_callback' => 'LTUtility::is_frontpage',
      'description' => 'The Intro will only show up if you either use a text overlay, image overlay or use a "Media"'
   )
);


$honp_default = true;
if( get_theme_mod('intro_hide_on_phone', 'not_set') == 'not_set' ) {
    $honp_default = false;
}

$wp_customize->add_setting( 'intro_hide_on_phone',
    array(
        'default' => $honp_default,
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_hide_on_phone',
        array(
            'label'          => 'Hide on Phone',
            'section'        => $section,
            'settings'       => 'intro_hide_on_phone',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'intro_movement',
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
        'intro_movement',
        array(
            'label'          => 'Follow mouse movement',
            'section'        => $section,
            'settings'       => 'intro_movement',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'intro_background_opacity',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'intro_background_opacity',
   array(
      'label' => 'Background Opacity (%)',
      'section' => $section,
      'settings' => 'intro_background_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => 0, 'max' => 100),
      'priority' => 8,
   )
) );

$wp_customize->add_setting( 'intro_background_color',
   array(
      'default' => '#fff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize,
    'intro_background_color',
    array(
        'label' => 'Background Color',
        'section' => $section,
        'settings' => 'intro_background_color',
        'priority' => 9,
    )
) );

$wp_customize->add_setting( 'intro_opacity',
   array(
      'default' => '100',
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'intro_opacity',
   array(
      'label' => 'Intro Opacity (%)',
      'section' => $section,
      'settings' => 'intro_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 10,
   )
) );

$wp_customize->add_setting( 'intro_media_brightness',
    array(
        'default' => '100',
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'intro_media_brightness',
    array(
       'label' => 'Media Brightness (%)',
       'section' => $section,
       'settings' => 'intro_media_brightness',
       'type' => 'number',
       'input_attrs' => array('min' => '0', 'max' => '200'),
       'priority' => 11,
    )
) );

$wp_customize->add_setting( 'intro_transition',
   array(
      'default' => 'zoom',
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_transition',
        array(
            'label'          => 'Transition',
            'section'        => $section,
            'settings'       => 'intro_transition',
            'type'           => 'select',
            'priority'       => 15,
            'choices'        => array('zoom' => 'Zoom out and fade out', 'fade' => 'Fade out', 'up' => 'Go up', 'upfade' => 'Go up and Fade out'),
        )
    )
);

$wp_customize->add_setting( 'intro_transition_duration',
   array(
      'default' => 500,
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_transition_duration',
        array(
            'label'          => 'Transition duration (milliseconds)',
            'section'        => $section,
            'settings'       => 'intro_transition_duration',
            'type'           => 'number',
            'priority'       => 20,
        )
    )
);

$wp_customize->add_setting( 'intro_hide_after',
   array(
      'default' => 4000,
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_hide_after',
        array(
            'label'          => 'Hide after waiting (milliseconds)',
            'section'        => $section,
            'description'    => 'Set to 0 to turn off',
            'settings'       => 'intro_hide_after',
            'type'           => 'number',
            'priority'       => 25,
        )
    )
);

// should be called intro_desktop, but it is this name for backwards compatibility
$wp_customize->add_setting( 'intro_image',
   array(
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'intro_image',
  array(
    'label'      => 'Landscape Intro Media',
    'description' => 'for Desktop (image or .mp4)',
    'section'    => $section,
    'settings'   => 'intro_image',
    'priority'   => 30
  ) )
);

$wp_customize->add_setting( 'phone_intro',
   array(
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'phone_intro',
  array(
    'label'      => 'Portrait Intro Media',
    'description' => 'for Smartphones (image or .mp4)',
    'section'    => $section,
    'settings'   => 'phone_intro',
    'priority'   => 35
  ) )
);

$wp_customize->add_setting( 'intro_use_svg_overlay',
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
        'intro_use_svg_overlay',
        array(
            'label'          => 'Image Overlay',
            'section'        => $section,
            'settings'       => 'intro_use_svg_overlay',
            'type'           => 'checkbox',
            'priority'       => 40,
        )
    )
);

$wp_customize->add_setting( 'intro_svg_overlay',
   array(
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'intro_svg_overlay',
  array(
    'label'      => 'Overlay Image',
    'section'    => $section,
    'settings'   => 'intro_svg_overlay',
    'description' => 'you can use a .svg file',
    'priority'   => 45,
    'active_callback' => 'lay_is_intro_svg_overlay_active',
  ) )
);

// option can be % (deprecated)
// overlay width
$wp_customize->add_setting( 'intro_svg_overlay_width_in',
   array(
      'default' => 'vw',
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_svg_overlay_width_in',
        array(
            'label'          => 'Image overlay width in',
            'section'        => $section,
            'settings'       => 'intro_svg_overlay_width_in',
            'type'           => 'select',
            'priority'       => 50,
            'choices'        => array('px' => 'px', '%' => '%'),
            'active_callback' => 'lay_is_intro_svg_overlay_active',
        )
    )
);

$wp_customize->add_setting( 'intro_svg_overlay_width',
   array(
      'default' => '30',
      'type' => 'option',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'intro_svg_overlay_width',
   array(
      'label' => 'Image overlay width',
      'section' => $section,
      'settings' => 'intro_svg_overlay_width',
      'type' => 'number',
      'input_attrs' => array('min' => '0'),
      'priority' => 55,
      'active_callback' => 'lay_is_intro_svg_overlay_active',
   )
) );


// text!

$wp_customize->add_setting( 'intro_use_text_overlay',
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
        'intro_use_text_overlay',
        array(
            'label'          => 'Text Overlay',
            'section'        => $section,
            'settings'       => 'intro_use_text_overlay',
            'type'           => 'checkbox',
            'priority'       => 60,
        )
    )
);

$wp_customize->add_setting( 'intro_text', array(
    'default'    => '',
    'type'       => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
  )
);

$wp_customize->add_control( 'intro_text', array(
    'label'      => 'Intro Text',
    'section'    => $section,
    'priority'   => 62,
    'type'       => 'textarea',
  )
);

// text position

$wp_customize->add_setting( 'intro_text_position',
   array(
      'default' => 'center-left',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_position',
        array(
            'label'          => 'Position',
            'section'        => $section,
            'settings'       => 'intro_text_position',
            'type'           => 'select',
            'priority'       => 65,
            'choices'        => array('top-left' => 'top left', 'top-center' => 'top center', 'top-right' => 'top right', 'center-left' => 'center left', 'center' => 'center', 'center-right' => 'center right', 'bottom-left' => 'bottom left', 'bottom-center' => 'bottom center', 'bottom-right' => 'bottom right')
        )
    )
);

// space top
$wp_customize->add_setting( 'intro_text_spacetop_mu',
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
        'intro_text_spacetop_mu',
        array(
            'label'          => 'Space Top in',
            'section'        => $section,
            'settings'       => 'intro_text_spacetop_mu',
            'type'           => 'select',
            'priority'       => 70,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'intro_text_spacetop',
   array(
      'default' => Customizer::$defaults['intro_text_spacetop'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_spacetop',
        array(
            'label'          => 'Space Top',
            'section'        => $section,
            'settings'       => 'intro_text_spacetop',
            'priority'       => 75,
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number'
        )
    )
);

// space bottom
$wp_customize->add_setting( 'intro_text_spacebottom_mu',
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
        'intro_text_spacebottom_mu',
        array(
            'label'          => 'Space Bottom in',
            'section'        => $section,
            'settings'       => 'intro_text_spacebottom_mu',
            'type'           => 'select',
            'priority'       => 80,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'intro_text_spacebottom',
   array(
      'default' => Customizer::$defaults['intro_text_spacebottom'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_spacebottom',
        array(
            'label'          => 'Space Bottom',
            'section'        => $section,
            'settings'       => 'intro_text_spacebottom',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 85
        )
    )
);

// spaceleft
$wp_customize->add_setting( 'intro_text_spaceleft_mu',
   array(
      'default' => '%',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_spaceleft_mu',
        array(
            'label'          => 'Space Left in',
            'section'        => $section,
            'settings'       => 'intro_text_spaceleft_mu',
            'type'           => 'select',
            'priority'       => 90,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);
$wp_customize->add_setting( 'intro_text_spaceleft',
   array(
      'default' => Customizer::$defaults['intro_text_spaceleft'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_spaceleft',
        array(
            'label'          => 'Space Left',
            'section'        => $section,
            'settings'       => 'intro_text_spaceleft',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 95
        )
    )
);

// spaceright
$wp_customize->add_setting( 'intro_text_spaceright_mu',
   array(
      'default' => '%',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_spaceright_mu',
        array(
            'label'          => 'Space Right in',
            'section'        => $section,
            'settings'       => 'intro_text_spaceright_mu',
            'type'           => 'select',
            'priority'       => 100,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);
$wp_customize->add_setting( 'intro_text_spaceright',
   array(
      'default' => Customizer::$defaults['intro_text_spaceright'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_spaceright',
        array(
            'label'          => 'Space Right',
            'section'        => $section,
            'settings'       => 'intro_text_spaceright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 110
        )
    )
);

$wp_customize->add_setting( 'intro_text_textformat',
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
        'intro_text_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'intro_text_textformat',
            'type'           => 'select',
            'priority'       => 120,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'intro_text_fontfamily',
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
        'intro_text_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'intro_text_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 130
        )
    )
);

$wp_customize->add_setting( 'intro_text_fontsize_mu',
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
        'intro_text_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'intro_text_fontsize_mu',
            'type'           => 'select',
            'priority'       => 140,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'intro_text_fontsize',
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
        'intro_text_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'intro_text_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 150
        )
    )
);

$wp_customize->add_setting( 'intro_text_fontweight',
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
        'intro_text_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'intro_text_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 160
        )
    )
);

$wp_customize->add_setting( 'intro_text_lineheight',
   array(
      'default' => Customizer::$defaults['lineheight'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'intro_text_lineheight',
        array(
            'label'          => 'Line Height',
            'section'        => $section,
            'settings'       => 'intro_text_lineheight',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.01'),
            'priority'       => 165
        )
    )
);

$wp_customize->add_setting( 'intro_text_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'intro_text_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'intro_text_color',
      'priority'   => 170
   )
) );

$wp_customize->add_setting( 'intro_text_letterspacing',
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
        'intro_text_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'intro_text_letterspacing',
            'input_attrs'    => array('step' => '0.01'),
            'type'           => 'number',
            'priority'       => 180
        )
    )
);

$wp_customize->add_setting( 'intro_text_align',
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
        'intro_text_align',
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'intro_text_align',
            'type'           => 'select',
            'priority' => 190,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
        )
    )
);
