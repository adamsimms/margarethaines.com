<?php

$section = 'projecttitle_options';

$wp_customize->add_section( $section,
   array(
      'title' => 'Project Title',
      'priority' => 20,
      'capability' => 'edit_theme_options',
      'panel' => 'projectlink_panel'
   )
);

$wp_customize->add_setting( 'pt_visibility',
   array(
      'default' => 'always-show',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_visibility',
        array(
            'label'          => 'Visibility',
            'section'        => $section,
            'settings'       => 'pt_visibility',
            'type'           => 'select',
            'choices'        => array('always-show' => 'always show', 'show-on-mouseover' => 'show on mouseover', 'hide' => 'hide'),
            'priority'       => 0
        )
    )
);

$wp_customize->add_setting( 'pt_animate_visibility',
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
        'pt_animate_visibility',
        array(
            'label'          => 'animate Visibility',
            'section'        => $section,
            'settings'       => 'pt_animate_visibility',
            'type'           => 'checkbox',
            'priority'       => 5,
        )
    )
);

$wp_customize->add_setting( 'pt_position',
   array(
      'default' => 'below-image',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_position',
        array(
            'label'          => 'Position',
            'section'        => $section,
            'settings'       => 'pt_position',
            'type'           => 'select',
            'choices'        => array(
                'above-image' => 'above image',
                'on-image-top-left' => 'on image top left',
                'on-image-top-right' => 'on image top right',
                'on-image' => 'on image center',
                'on-image-bottom-left' => 'on image bottom left',
                'on-image-bottom-right' => 'on image bottom right',
                'below-image' => 'below image'
            ),
            'priority' => 6
        )
    )
);

// space top
$wp_customize->add_setting( 'pt_onimage_spacetop',
    array(
    'default' => '10',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_onimage_spacetop',
        array(
            'label'          => 'Space Top (px)',
            'section'        => $section,
            'settings'       => 'pt_onimage_spacetop',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 7,
            'active_callback'=> 'pt_show_spacetop_control'
        )
    )
);
function pt_show_spacetop_control(){
    $pt_position = get_theme_mod('pt_position', 'below-image');
    if( strpos( $pt_position, 'top' ) !== false ){
        return true;
    }
    return false;
}

// space bottom
$wp_customize->add_setting( 'pt_onimage_spacebottom',
    array(
    'default' => '10',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_onimage_spacebottom',
        array(
            'label'          => 'Space Bottom (px)',
            'section'        => $section,
            'settings'       => 'pt_onimage_spacebottom',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 8,
            'active_callback'=> 'pt_show_spacebottom_control'
        )
    )
);
function pt_show_spacebottom_control(){
    $pt_position = get_theme_mod('pt_position', 'below-image');
    if( strpos( $pt_position, 'bottom' ) !== false ){
        return true;
    }
    return false;
}

// space left
$wp_customize->add_setting( 'pt_onimage_spaceleft',
    array(
    'default' => '10',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_onimage_spaceleft',
        array(
            'label'          => 'Space Left (px)',
            'section'        => $section,
            'settings'       => 'pt_onimage_spaceleft',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 9,
            'active_callback'=> 'pt_show_spaceleft_control'
        )
    )
);
function pt_show_spaceleft_control(){
    $pt_position = get_theme_mod('pt_position', 'below-image');
    if( strpos( $pt_position, 'left' ) !== false ){
        return true;
    }
    return false;
}

// right
$wp_customize->add_setting( 'pt_onimage_spaceright',
    array(
    'default' => '10',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_onimage_spaceright',
        array(
            'label'          => 'Space Right (px)',
            'section'        => $section,
            'settings'       => 'pt_onimage_spaceright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 10,
            'active_callback'=> 'pt_show_spaceright_control'
        )
    )
);
function pt_show_spaceright_control(){
    $pt_position = get_theme_mod('pt_position', 'below-image');
    if( strpos( $pt_position, 'right' ) !== false ){
        return true;
    }
    return false;
}

// pt_spacetop is only used for when title is above or below image.
// should be named space_between_pt_and_image
$wp_customize->add_setting( 'pt_spacetop',
   array(
      'default' => '5',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_spacetop',
        array(
            'label'          => 'Space between Title and Image (px)',
            'section'        => $section,
            'settings'       => 'pt_spacetop',
            'type'           => 'number',
            'priority'       => 20,
            'active_callback'=> 'pt_show_spacebetween_control' 
        )
    )
);
function pt_show_spacebetween_control(){
    $pt_position = get_theme_mod('pt_position', 'below-image');
    if( $pt_position == 'below-image' || $pt_position == 'above-image' ){
        return true;
    }
    return false;
}

$wp_customize->add_setting( 'pt_textformat',
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
        'pt_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'pt_textformat',
            'type'           => 'select',
            'priority'       => 30,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'pt_fontfamily',
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
        'pt_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'pt_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority' => 40
        )
    )
);

$wp_customize->add_setting( 'pt_fontsize_mu',
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
        'pt_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'pt_fontsize_mu',
            'type'           => 'select',
            'priority'       => 50,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'pt_fontsize',
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
        'pt_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'pt_fontsize',
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number',
            'priority' => 60
        )
    )
);

$wp_customize->add_setting( 'pt_fontweight',
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
        'pt_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'pt_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 70
        )
    )
);

$wp_customize->add_setting( 'pt_lineheight',
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
        'pt_lineheight',
        array(
            'label'          => 'Line Height',
            'section'        => $section,
            'settings'       => 'pt_lineheight',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.01'),
            'priority'       => 75
        )
    )
);

$wp_customize->add_setting( 'pt_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'pt_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'pt_color',
      'priority' => 80,
   )
) );

$wp_customize->add_setting( 'pt_letterspacing',
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
        'pt_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'pt_letterspacing',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.01'),
            'priority'       => 90
        )
    )
);

$wp_customize->add_setting( 'pt_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'pt_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'pt_opacity',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'type' => 'number',
      'priority' => 100,
   )
) );

$wp_customize->add_setting( 'pt_align',
   array(
      'default' => 'left',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pt_align',
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'pt_align',
            'type'           => 'select',
            'priority' => 110,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right')
        )
    )
);
