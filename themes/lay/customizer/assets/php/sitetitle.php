<?php

$section = 'sitetitle_options';

$wp_customize->add_section( $section,
   array(
      'title' => 'Site Title',
      'priority' => 10,
      'capability' => 'edit_theme_options',
      'panel' => 'sitetitle_panel'
   )
);

$wp_customize->add_setting( 'st_hide',
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
        'st_hide',
        array(
            'label'          => 'hide',
            'section'        => $section,
            'settings'       => 'st_hide',
            'type'           => 'checkbox',
            'priority'       => 4,
        )
    )
);

$wp_customize->add_setting( 'st_txt_or_img',
   array(
      'default' => 'text',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_txt_or_img',
        array(
            'label'          => 'Text, Image or HTML',
            'section'        => $section,
            'settings'       => 'st_txt_or_img',
            'type'           => 'select',
            'priority'       => 5,
            'choices'        => array('text' => 'Text', 'image' => 'Image', 'html' => 'HTML')
        )
    )
);

$wp_customize->add_setting( 'st_image',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'st_image',
  array(
    'label'      => 'Image',
    'section'    => $section,
    'settings'   => 'st_image',
    'description' => 'Use a small image',
    'priority'   => 10
  ) )
);

$wp_customize->add_setting( 'blogname', array(
    'default'    => get_option( 'blogname' ),
    'type'       => 'option',
    'capability' => 'manage_options',
    'transport' => 'postMessage',
  )
);

$wp_customize->add_control( 'blogname', array(
    'label'      => 'Site Title',
    'type'       => 'text',
    'section'    => $section,
    'priority'   => 10
  )
);

$wp_customize->add_setting( 'site_title_html', array(
    'default'    => '',
    'type'       => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport'  => 'postMessage',
  )
);
$wp_customize->add_control( 'site_title_html', array(
    'label'      => 'Site Title HTML',
    'type'       => 'textarea',
    'section'    => $section,
    'priority'   => 10
  )
);

$wp_customize->add_setting( 'st_img_width_mu',
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
        'st_img_width_mu',
        array(
            'label'          => 'Image Width in',
            'section'        => $section,
            'settings'       => 'st_img_width_mu',
            'type'           => 'select',
            'priority'       => 11,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);

$wp_customize->add_setting( 'st_img_width',
   array(
      'default' => Customizer::$defaults['st_img_width'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_img_width',
        array(
            'label'          => 'Image Width',
            'section'        => $section,
            'settings'       => 'st_img_width',
            'type'           => 'number',
            'priority'       => 13
        )
    )
);

$wp_customize->add_setting( 'st_image_alignment_in_relation_to_tagline',
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
        'st_image_alignment_in_relation_to_tagline',
        array(
            'label'          => 'Image alignment in relation to tagline',
            'section'        => $section,
            'settings'       => 'st_image_alignment_in_relation_to_tagline',
            'type'           => 'select',
            'priority'       => 14,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
        )
    )
);

$wp_customize->add_setting( 'st_isfixed',
   array(
      'default' => true,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_isfixed',
        array(
            'label'          => 'is fixed',
            'section'        => $section,
            'settings'       => 'st_isfixed',
            'type'           => 'checkbox',
            'priority'       => 15,
        )
    )
);

$wp_customize->add_setting( 'st_hidewhenscrolling',
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
        'st_hidewhenscrolling',
        array(
            'label'          => 'move away when scrolling down',
            'section'        => $section,
            'settings'       => 'st_hidewhenscrolling',
            'type'           => 'checkbox',
            'priority'       => 17,
        )
    )
);

$wp_customize->add_setting( 'st_fadeout_whenscrolling',
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
        'st_fadeout_whenscrolling',
        array(
            'label'          => 'fade out when scrolling down',
            'section'        => $section,
            'settings'       => 'st_fadeout_whenscrolling',
            'type'           => 'checkbox',
            'priority'       => 17,
        )
    )
);

$wp_customize->add_setting( 'st_position',
   array(
      'default' => 'top-left',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_position',
        array(
            'label'          => 'Position',
            'section'        => $section,
            'settings'       => 'st_position',
            'type'           => 'select',
            'priority'       => 21,
            'choices'        => array('top-left' => 'top left', 'top-center' => 'top center', 'top-right' => 'top right', 'center' => 'center', 'bottom-left' => 'bottom left', 'bottom-center' => 'bottom center', 'bottom-right' => 'bottom right')
        )
    )
);

// space top
$wp_customize->add_setting( 'st_spacetop_mu',
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
        'st_spacetop_mu',
        array(
            'label'          => 'Space Top in',
            'section'        => $section,
            'settings'       => 'st_spacetop_mu',
            'type'           => 'select',
            'priority'       => 22,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'st_spacetop',
   array(
      'default' => Customizer::$defaults['st_spacetop'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_spacetop',
        array(
            'label'          => 'Space Top',
            'section'        => $section,
            'settings'       => 'st_spacetop',
            'priority'       => 23,
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number'
        )
    )
);

// space bottom
$wp_customize->add_setting( 'st_spacebottom_mu',
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
        'st_spacebottom_mu',
        array(
            'label'          => 'Space Bottom in',
            'section'        => $section,
            'settings'       => 'st_spacebottom_mu',
            'type'           => 'select',
            'priority'       => 22,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'st_spacebottom',
   array(
      'default' => Customizer::$defaults['st_spacebottom'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_spacebottom',
        array(
            'label'          => 'Space Bottom',
            'section'        => $section,
            'settings'       => 'st_spacebottom',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 23
        )
    )
);

// spaceleft
$wp_customize->add_setting( 'st_spaceleft_mu',
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
        'st_spaceleft_mu',
        array(
            'label'          => 'Space Left in',
            'section'        => $section,
            'settings'       => 'st_spaceleft_mu',
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);
$wp_customize->add_setting( 'st_spaceleft',
   array(
      'default' => Customizer::$defaults['st_spaceleft'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_spaceleft',
        array(
            'label'          => 'Space Left',
            'section'        => $section,
            'settings'       => 'st_spaceleft',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 26
        )
    )
);

// spaceright
$wp_customize->add_setting( 'st_spaceright_mu',
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
        'st_spaceright_mu',
        array(
            'label'          => 'Space Right in',
            'section'        => $section,
            'settings'       => 'st_spaceright_mu',
            'type'           => 'select',
            'priority'       => 27,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);
$wp_customize->add_setting( 'st_spaceright',
   array(
      'default' => Customizer::$defaults['st_spaceright'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'st_spaceright',
        array(
            'label'          => 'Space Right',
            'section'        => $section,
            'settings'       => 'st_spaceright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 28
        )
    )
);

$wp_customize->add_setting( 'st_textformat',
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
        'st_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'st_textformat',
            'type'           => 'select',
            'priority'       => 31,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'st_fontfamily',
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
        'st_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'st_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 35
        )
    )
);

$wp_customize->add_setting( 'st_fontsize_mu',
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
        'st_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'st_fontsize_mu',
            'type'           => 'select',
            'priority'       => 38,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'st_fontsize',
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
        'st_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'st_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 40
        )
    )
);

$wp_customize->add_setting( 'st_fontweight',
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
        'st_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'st_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 45
        )
    )
);

$wp_customize->add_setting( 'st_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'st_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'st_color',
      'priority'   => 50
   )
) );

$wp_customize->add_setting( 'st_letterspacing',
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
        'st_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'st_letterspacing',
            'input_attrs'    => array('step' => '0.01'),
            'type'           => 'number',
            'priority'       => 55
        )
    )
);

$wp_customize->add_setting( 'st_align',
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
        'st_align',
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'st_align',
            'type'           => 'select',
            'priority' => 57,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'description'   => 'Text-align is only important if you use multiline text for your site title.'
        )
    )
);

$wp_customize->add_setting( 'st_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'st_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'st_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 60,
   )
) );

$wp_customize->add_setting( 'st_underline_strokewidth',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'st_underline_strokewidth',
   array(
      'label' => 'Underline Strokewidth',
      'description' => 'Underline Offset settings are the ones used in "Customize" → "Links in Texts"',
      'section' => $section,
      'settings' => 'st_underline_strokewidth',
      'type' => 'number',
      'priority' => 70,
   )
) );
