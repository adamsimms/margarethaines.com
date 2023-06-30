<?php

function is_mobile_sitetitle_hidden(){
    return get_theme_mod('m_st_hide') == 1 ? false : true;
}

$section = 'mobile_sitetitle';

$wp_customize->add_section( $section,
   array(
      'title' => 'Mobile Site Title',
      'priority' => 10,
      'capability' => 'edit_theme_options',
      'panel' => 'mobile_panel'
   )
);

$wp_customize->add_setting( 'm_st_hide',
   array(
      'default' => get_theme_mod('st_hide', 0),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_hide',
        array(
            'label'          => 'hide',
            'section'        => $section,
            'settings'       => 'm_st_hide',
            'type'           => 'checkbox',
            'priority'       => 1,
        )
    )
);

// only makes sense to show/use this control when mobile menu is hidden
$wp_customize->add_setting( 'm_st_isfixed',
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
        'm_st_isfixed',
        array(
            'label'          => 'is fixed',
            'section'        => $section,
            'settings'       => 'm_st_isfixed',
            'type'           => 'checkbox',
            'priority'       => 3,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'm_st_txt_or_img',
   array(
      'default' => get_theme_mod('st_txt_or_img', 'text'),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_txt_or_img',
        array(
            'label'          => 'Text or Image',
            'section'        => $section,
            'settings'       => 'm_st_txt_or_img',
            'type'           => 'select',
            'priority'       => 5,
            'choices'        => array('text' => 'Text', 'image' => 'Image'),
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'm_st_image',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'm_st_image',
  array(
    'label'      => 'Image',
    'section'    => $section,
    'settings'   => 'm_st_image',
    'description' => 'Use a small image',
    'priority'   => 10,
    'active_callback' => 'is_mobile_sitetitle_hidden',
  ) )
);

$wp_customize->add_setting( 'm_st_img_height',
   array(
      'default' => 30,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_img_height',
        array(
            'label'          => 'Image Height (px)',
            'section'        => $section,
            'settings'       => 'm_st_img_height',
            'type'           => 'number',
            'priority'       => 13,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'm_st_position',
   array(
      'default' => 'center',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_position',
        array(
            'label'          => 'Position',
            'section'        => $section,
            'settings'       => 'm_st_position',
            'type'           => 'select',
            'priority'       => 21,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

// space top
$wp_customize->add_setting( 'm_st_spacetop_mu',
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
        'm_st_spacetop_mu',
        array(
            'label'          => 'Space Top in',
            'section'        => $section,
            'settings'       => 'm_st_spacetop_mu',
            'type'           => 'select',
            'priority'       => 22,
            'choices'        => array('px' => 'px', 'vw' => '%'),
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);
$wp_customize->add_setting( 'm_st_spacetop',
   array(
      'default' => 12,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_spacetop',
        array(
            'label'          => 'Space Top',
            'section'        => $section,
            'settings'       => 'm_st_spacetop',
            'priority'       => 23,
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number',
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);
// spaceleft
$wp_customize->add_setting( 'm_st_spaceleft_mu',
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
        'm_st_spaceleft_mu',
        array(
            'label'          => 'Space Left in',
            'section'        => $section,
            'settings'       => 'm_st_spaceleft_mu',
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array('%' => '%', 'px' => 'px'),
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);
$wp_customize->add_setting( 'm_st_spaceleft',
   array(
      'default' => 5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_spaceleft',
        array(
            'label'          => 'Space Left',
            'section'        => $section,
            'settings'       => 'm_st_spaceleft',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 26,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);
// spaceright
$wp_customize->add_setting( 'm_st_spaceright_mu',
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
        'm_st_spaceright_mu',
        array(
            'label'          => 'Space Right in',
            'section'        => $section,
            'settings'       => 'm_st_spaceright_mu',
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array('%' => '%', 'px' => 'px'),
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);
$wp_customize->add_setting( 'm_st_spaceright',
   array(
      'default' => 5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_spaceright',
        array(
            'label'          => 'Space Right',
            'section'        => $section,
            'settings'       => 'm_st_spaceright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 26,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);
//

$wp_customize->add_setting( 'm_st_textformat',
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
        'm_st_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'm_st_textformat',
            'type'           => 'select',
            'priority'       => 32,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'm_st_fontfamily',
   array(
      'default' => get_theme_mod('st_fontfamily', Customizer::$defaults['fontfamily']),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'm_st_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 35,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'm_st_fontsize_mu',
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
        'm_st_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'm_st_fontsize_mu',
            'type'           => 'select',
            'priority'       => 38,
            'choices'        => array('px' => 'px', 'vw' => '%'),
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_sitetitle_fontsize',
   array(
      'default' => Customizer::$defaults['mobile_menu_fontsize'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_sitetitle_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'mobile_menu_sitetitle_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 40,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'm_st_fontweight',
   array(
      'default' => get_theme_mod('st_fontweight', Customizer::$defaults['fontweight']),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'm_st_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 45,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);

$wp_customize->add_setting( 'm_st_color',
   array(
      'default' => get_theme_mod('st_color', Customizer::$defaults['color']),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'm_st_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'm_st_color',
      'priority'   => 50,
      'active_callback' => 'is_mobile_sitetitle_hidden',
   )
) );

$wp_customize->add_setting( 'm_st_letterspacing',
   array(
      'default' => get_theme_mod('st_letterspacing' , Customizer::$defaults['letterspacing']),
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'm_st_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'm_st_letterspacing',
            'input_attrs'    => array('step' => '0.01'),
            'type'           => 'number',
            'priority'       => 55,
            'active_callback' => 'is_mobile_sitetitle_hidden',
        )
    )
);
