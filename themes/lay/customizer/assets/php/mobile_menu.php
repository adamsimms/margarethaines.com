<?php

function is_mobile_menu_hidden(){
    return get_theme_mod('mobile_hide_menu', false) == 1 ? false : true;
}
function is_active_underline_color(){
   if( get_theme_mod('mobile_hide_menu', false) == 1 ){
      return false;
   }
   if( get_theme_mod('mobile_menu_style', 'style_1') == 'style_1' ){
      return true;
   }
   return false;
}
function is_active_background_opacity(){
   if( get_theme_mod('mobile_hide_menu', false) == 1 ){
        return false;
   } else {
        return true;
   }
}

function is_active_blurry(){
    if( get_theme_mod('mobile_menu_style', 'style_1') == 'style_desktop_menu' ) {
        return false;
    }
    return true;
}

$txtColor = Customizer::$defaults['mobile_menu_txt_color'];
$lighterBgColor = Customizer::$defaults['mobile_menu_light_color'];
$darker = Customizer::$defaults['mobile_menu_dark_color'];

$section = 'mobile_menu';

$wp_customize->add_section( $section,
   array(
      'title' => 'Mobile Menu',
      'priority' => 0,
      'capability' => 'edit_theme_options',
      'panel' => 'mobile_panel',
   )
);

$wp_customize->add_setting( 'mobile_hide_menu',
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
        'mobile_hide_menu',
        array(
            'label'          => 'hide',
            'section'        => $section,
            'settings'       => 'mobile_hide_menu',
            'type'           => 'checkbox',
            'priority'       => 5,
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_style',
    array(
    'default' => 'style_1',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_style',
         array(
            'label'          => 'Menu Style',
            'section'        => $section,
            'settings'       => 'mobile_menu_style',
            'type'           => 'select',
            'priority'       => 10,
            'choices'        => array('style_1' => 'Style 1', 'style_2' => 'Style 2', 'style_3' => 'Style 3', 'style_desktop_menu' => 'Desktop Menu Style'),
            'active_callback' => 'is_mobile_menu_hidden'
         )
   )
);

$wp_customize->add_setting( 'mobile_menu_isfixed',
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
        'mobile_menu_isfixed',
        array(
            'label'          => 'is fixed',
            'section'        => $section,
            'settings'       => 'mobile_menu_isfixed',
            'type'           => 'checkbox',
            'priority'       => 7,
            'active_callback' => 'is_mobile_menu_hidden',
            'description' => 'When using "Menu Style" &rarr; "Style 3", we recommend enabling this setting.'
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_do_animation',
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
        'mobile_menu_do_animation',
        array(
            'label'          => 'do Animation',
            'section'        => $section,
            'settings'       => 'mobile_menu_do_animation',
            'type'           => 'checkbox',
            'priority'       => 8,
            'active_callback' => 'is_mobile_menu_hidden'
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_arrangement',
    array(
    'default' => 'horizontal',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_arrangement',
        array(
            'label'          => 'Menu Points Arrangement',
            'section'        => $section,
            'settings'       => 'mobile_menu_arrangement',
            'type'           => 'select',
            'priority'       => 10,
            'choices'        => array('horizontal' => 'horizontal', 'vertical' => 'vertical'),
            'active_callback' => 'is_mobile_menu_hidden'
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_textformat',
    array(
    'default' => 'Default',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'mobile_menu_textformat',
            'type'           => 'select',
            'priority'       => 11,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => 'is_mobile_menu_hidden'
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_text_align',
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
        'mobile_menu_text_align',
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'mobile_menu_text_align',
            'type'           => 'select',
            'priority'       => 12,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'active_callback' => 'is_mobile_menu_hidden',
        )
    )
);


$wp_customize->add_setting( 'mobile_menu_position',
   array(
      'default' => 'right',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_position',
        array(
            'label'          => 'Position',
            'section'        => $section,
            'settings'       => 'mobile_menu_position',
            'type'           => 'select',
            'priority'       => 20,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right')
        )
    )
);

// space top
$wp_customize->add_setting( 'mobile_menu_spacetop_mu',
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
        'mobile_menu_spacetop_mu',
        array(
            'label'          => 'Space Top in',
            'section'        => $section,
            'settings'       => 'mobile_menu_spacetop_mu',
            'type'           => 'select',
            'priority'       => 21,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'mobile_menu_spacetop',
   array(
      'default' => '12',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_spacetop',
        array(
            'label'          => 'Space Top',
            'section'        => $section,
            'settings'       => 'mobile_menu_spacetop',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 22
        )
    )
);

// space left
$wp_customize->add_setting( 'mobile_menu_spaceleft_mu',
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
        'mobile_menu_spaceleft_mu',
        array(
            'label'          => 'Space Left in',
            'section'        => $section,
            'settings'       => 'mobile_menu_spaceleft_mu',
            'type'           => 'select',
            'priority'       => 23,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);
$wp_customize->add_setting( 'mobile_menu_spaceleft',
   array(
      'default' => '5',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_spaceleft',
        array(
            'label'          => 'Space Left',
            'section'        => $section,
            'settings'       => 'mobile_menu_spaceleft',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 24
        )
    )
);

// spaceright
$wp_customize->add_setting( 'mobile_menu_spaceright_mu',
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
        'mobile_menu_spaceright_mu',
        array(
            'label'          => 'Space Right in',
            'section'        => $section,
            'settings'       => 'mobile_menu_spaceright_mu',
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);
$wp_customize->add_setting( 'mobile_menu_spaceright',
   array(
      'default' => '5',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_spaceright',
        array(
            'label'          => 'Space Right',
            'section'        => $section,
            'settings'       => 'mobile_menu_spaceright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 26
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_spacebetween',
   array(
      'default' => '5',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menu_spacebetween',
        array(
            'label'          => 'Space Between (px)',
            'section'        => $section,
            'settings'       => 'mobile_menu_spacebetween',
            'type'           => 'number',
            'priority'       => 35
        )
    )
);

//
$wp_customize->add_setting( 'mobile_menu_fontsize',
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
        'mobile_menu_fontsize',
        array(
            'label'          => 'Font Size Menu Points',
            'section'        => $section,
            'settings'       => 'mobile_menu_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 15,
            'active_callback' => 'is_mobile_menu_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menupoint_lineheight',
   array(
      'default' => '1',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menupoint_lineheight',
        array(
            'label'          => 'Menu Point Line Height',
            'section'        => $section,
            'settings'       => 'mobile_menupoint_lineheight',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.01'),
            'priority'       => 16,
            'active_callback' => 'is_mobile_menu_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menupoint_paddingtop',
   array(
      'default' => '10',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menupoint_paddingtop',
        array(
            'label'          => 'Menu Point Padding Top (px)',
            'section'        => $section,
            'settings'       => 'mobile_menupoint_paddingtop',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 17,
            'active_callback' => 'is_mobile_menu_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menupoint_paddingleft',
   array(
      'default' => '10',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menupoint_paddingleft',
        array(
            'label'          => 'Menu Point Padding Left (px)',
            'section'        => $section,
            'settings'       => 'mobile_menupoint_paddingleft',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 18,
            'active_callback' => 'is_mobile_menu_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menupoint_paddingbottom',
   array(
      'default' => '10',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menupoint_paddingbottom',
        array(
            'label'          => 'Menu Point Padding Bottom (px)',
            'section'        => $section,
            'settings'       => 'mobile_menupoint_paddingbottom',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 19,
            'active_callback' => 'is_mobile_menu_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menupoint_paddingright',
   array(
      'default' => '10',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_menupoint_paddingright',
        array(
            'label'          => 'Menu Point Padding Right (px)',
            'section'        => $section,
            'settings'       => 'mobile_menupoint_paddingright',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 20,
            'active_callback' => 'is_mobile_menu_hidden',
        )
    )
);

$wp_customize->add_setting( 'mobile_menu_background_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'mobile_menu_background_opacity',
   array(
      'label' => 'Menu Points Background Opacity (%)',
      'section' => $section,
      'settings' => 'mobile_menu_background_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 55,
      'active_callback' => 'is_active_background_opacity',
   )
) );

$wp_customize->add_setting( 'mobile_menu_blurry',
   array(
      'default' => false,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'mobile_menu_blurry',
   array(
      'label'          => 'make blurry',
      'section'        => $section,
      'settings'       => 'mobile_menu_blurry',
      'type'           => 'checkbox',
      'priority'       => 56,
      'description' => 'Only works if background is a little transparent ("Opacity" less than 100)',
      'active_callback' => 'is_active_blurry'
   )
) );

$wp_customize->add_setting( 'mobile_menu_blur_amount',
   array(
      'default' => '20',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'mobile_menu_blur_amount',
   array(
      'label' => 'Blur Amount (px)',
      'section' => $section,
      'settings' => 'mobile_menu_blur_amount',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 57,
      'active_callback' => 'is_active_blurry'
   )
) );

$wp_customize->add_setting( 'mobile_menu_background_color',
   array(
      'default' => $lighterBgColor,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_background_color',
   array(
      'label' => 'Menu Background Color',
      'section' => $section,
      'settings' => 'mobile_menu_background_color',
      'priority'   => 60,
      'active_callback' => 'is_mobile_menu_hidden',
   )
) );

$wp_customize->add_setting( 'mobile_menu_text_color',
   array(
      'default' => $txtColor,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_text_color',
   array(
      'label' => 'Menu Points Text Color',
      'section' => $section,
      'settings' => 'mobile_menu_text_color',
      'priority'   => 65,
      'active_callback' => 'is_mobile_menu_hidden',
   )
) );

$wp_customize->add_setting( 'mobile_menu_points_underline_color',
   array(
      'default' => $darker,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_points_underline_color',
   array(
      'label' => 'Menu Points Lines Color',
      'section' => $section,
      'settings' => 'mobile_menu_points_underline_color',
      'priority'   => 70,
      'active_callback' => 'is_active_underline_color',
   )
) );

$wp_customize->add_setting( 'mobile_menu_current_menu_item_color',
   array(
      'default' => $txtColor,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_current_menu_item_color',
   array(
      'label' => 'Active Menu Point Color',
      'section' => $section,
      'settings' => 'mobile_menu_current_menu_item_color',
      'priority'   => 75,
      'active_callback' => 'is_mobile_menu_hidden',
   )
) );

$wp_customize->add_setting( 'mobile_menu_current_menu_item_background_color',
   array(
      'default' => $darker,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'mobile_menu_current_menu_item_background_color',
   array(
      'label' => 'Active Menu Point Background Color',
      'section' => $section,
      'settings' => 'mobile_menu_current_menu_item_background_color',
      'priority'   => 80,
      'active_callback' => 'is_mobile_menu_hidden',
   )
) );
