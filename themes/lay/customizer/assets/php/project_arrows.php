<?php

function lay_is_project_and_project_arrows_active(){
  $return = false;
  if(is_single()){
    $return = true;
  }
  else if( is_home() || is_front_page() ){
    $type = get_theme_mod('frontpage_type', 'category');
    if($type == 'project'){
      $return = true;
    }
  }
  $val = get_option('misc_options_show_project_arrows', '');
  if($val != 'on' || MiscOptions::$locked){
    $return = false;
  }
  return $return;
}

$section = 'projectarrows_options';

$wp_customize->add_section( $section,
   array(
      'title' => 'Project Arrows',
      'priority' => 80,
      'capability' => 'edit_theme_options',
      'active_callback' => 'lay_is_project_and_project_arrows_active',
      'description' => 'When "Arrow Type" is "Text" underline settings of "Links in Texts" will be used'
   )
);

$wp_customize->add_setting( 'pa_hide_on_phone',
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
        'pa_hide_on_phone',
        array(
            'label'          => 'Hide for phone layout',
            'section'        => $section,
            'settings'       => 'pa_hide_on_phone',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'pa_hide_prev',
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
        'pa_hide_prev',
        array(
            'label'          => 'Hide Previous Arrow',
            'section'        => $section,
            'settings'       => 'pa_hide_prev',
            'type'           => 'checkbox',
            'priority'       => 4,
        )
    )
);

$wp_customize->add_setting( 'pa_type',
   array(
      'default' => 'icon',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pa_type',
        array(
            'label'          => 'Arrow Type',
            'section'        => $section,
            'settings'       => 'pa_type',
            'type'           => 'select',
            'choices'        =>
            array(
              'icon' => 'Icon',
              'text' => 'Text',
              'custom-image' => 'Custom Image',
              'project-thumbnails' => 'Project Thumbnails',
          ),
            'priority' => 5
        )
    )
);

$wp_customize->add_setting( 'pa_icon',
   array(
      'default' => '&#9654;',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pa_icon',
        array(
            'label'          => 'Arrow',
            'section'        => $section,
            'settings'       => 'pa_icon',
            'type'           => 'select',
            'choices'        =>
            array(
              '&#9654;' => '&#9654;',
              '&#9656;' => '&#9656;',
              '&#9655;' => '&#9655;',
              '&#9657;' => '&#9657;',
              '&#9659;' => '&#9659;',
              '&#10095;' => '&#10095;',
              '&#9002;' => '&#9002;',
              '&rsaquo;' => '&rsaquo;',
              '&#9679;' => '&#9679;',
              '&#8226;' => '&#8226;',
              '&#9673;' => '&#9673;',
              '&#9678;' => '&#9678;',
              '&#8413;' => '&#8413;',
              '&#9676;' => '&#9676;',
              '&#9675;' => '&#9675;',
              '&#10686;' => '&#10686;',
              '&#10687;' => '&#10687;',
              '&#9898;' => '&#9898;',
              '&#128309;' => '&#128309;',
              '&#128308;' => '&#128308;',
              '&#9899;' => '&#9899;',
              '&#9755;' => '&#9755;',
              '&#9758;' => '&#9758;',
              '&#128073;' => '&#128073;',
          ),
            'priority' => 12
        )
    )
);


$wp_customize->add_setting( 'pa_next_text', array(
    'default'    => 'Next',
    'type'       => 'theme_mod',
    'capability' => 'manage_options',
    'transport' => 'postMessage',
  )
);
$wp_customize->add_control( 'pa_next_text', array(
    'label'      => 'Next Text',
    'section'    => $section,
    'priority'   => 12
  )
);

$wp_customize->add_setting( 'pa_prev_text', array(
    'default'    => 'Previous',
    'type'       => 'theme_mod',
    'capability' => 'manage_options',
    'transport' => 'postMessage',
  )
);
$wp_customize->add_control( 'pa_prev_text', array(
    'label'      => 'Previous Text',
    'section'    => $section,
    'priority'   => 12
  )
);


$wp_customize->add_setting( 'pa_image',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
  new WP_Customize_Upload_Control(
  $wp_customize,
  'pa_image',
  array(
    'label'      => 'Image',
    'section'    => $section,
    'settings'   => 'pa_image',
    'description' => 'Use an arrow pointing to the right.',
    'priority'   => 12
  ) )
);

$wp_customize->add_setting( 'pa_position',
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
        'pa_position',
        array(
            'label'          => 'Position',
            'section'        => $section,
            'settings'       => 'pa_position',
            'type'           => 'select',
            'priority'       => 15,
            'choices'        => array('top' => 'top', 'center' => 'center', 'bottom' => 'bottom')
        )
    )
);

// space top/bottom
$wp_customize->add_setting( 'pa_spacetopbottom_mu',
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
        'pa_spacetopbottom_mu',
        array(
            'label'          => 'Space Top/Bottom in',
            'section'        => $section,
            'settings'       => 'pa_spacetopbottom_mu',
            'type'           => 'select',
            'priority'       => 16,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'pa_spacetopbottom',
   array(
      'default' => 20,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pa_spacetopbottom',
        array(
            'label'          => 'Space Top/Bottom',
            'section'        => $section,
            'settings'       => 'pa_spacetopbottom',
            'priority'       => 17,
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number'
        )
    )
);

// space left/right
$wp_customize->add_setting( 'pa_spaceleftright_mu',
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
        'pa_spaceleftright_mu',
        array(
            'label'          => 'Space Left/Right in',
            'section'        => $section,
            'settings'       => 'pa_spaceleftright_mu',
            'type'           => 'select',
            'priority'       => 18,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'pa_spaceleftright',
   array(
      'default' => 20,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pa_spaceleftright',
        array(
            'label'          => 'Space Left/Right',
            'section'        => $section,
            'settings'       => 'pa_spaceleftright',
            'priority'       => 19,
            'input_attrs'    => array('step' => '0.1'),
            'type'           => 'number'
        )
    )
);

$wp_customize->add_setting( 'pa_icon_size',
   array(
      'default' => '20',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pa_icon_size',
        array(
            'label'          => 'Icon Size (px)',
            'section'        => $section,
            'settings'       => 'pa_icon_size',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 22
        )
    )
);

$wp_customize->add_setting( 'pa_padding',
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
        'pa_padding',
        array(
            'label'          => 'Clickable Space around (px)',
            'section'        => $section,
            'settings'       => 'pa_padding',
            'type'           => 'number',
            'input_attrs'    => array('step' => '1'),
            'priority'       => 24
        )
    )
);

$wp_customize->add_setting( 'pa_icon_color',
   array(
      'default' => '#000000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'pa_icon_color',
   array(
      'label' => 'Icon Color',
      'section' => $section,
      'settings' => 'pa_icon_color',
      'priority'   => 25
   )
) );

$wp_customize->add_setting( 'pa_width_mu',
   array(
      'default' => '%',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pa_width_mu',
        array(
            'label'          => 'Width in',
            'section'        => $section,
            'settings'       => 'pa_width_mu',
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array('%' => '%', 'px' => 'px')
        )
    )
);

$wp_customize->add_setting( 'pa_width',
   array(
      'default' => 10,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'pa_width',
        array(
            'label'          => 'Width',
            'section'        => $section,
            'settings'       => 'pa_width',
            'type'           => 'number',
            'priority'       => 30
        )
    )
);

// text
$wp_customize->add_setting( 'pa_textformat',
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
        'pa_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'pa_textformat',
            'type'           => 'select',
            'priority'       => 31,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'pa_fontfamily',
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
        'pa_fontfamily',
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'pa_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 35
        )
    )
);

$wp_customize->add_setting( 'pa_fontsize_mu',
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
        'pa_fontsize_mu',
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'pa_fontsize_mu',
            'type'           => 'select',
            'priority'       => 38,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);

$wp_customize->add_setting( 'pa_fontsize',
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
        'pa_fontsize',
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'pa_fontsize',
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 40
        )
    )
);

$wp_customize->add_setting( 'pa_fontweight',
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
        'pa_fontweight',
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'pa_fontweight',
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 45
        )
    )
);

$wp_customize->add_setting( 'pa_color',
   array(
      'default' => Customizer::$defaults['color'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'pa_color',
   array(
      'label' => 'Text Color',
      'section' => $section,
      'settings' => 'pa_color',
      'priority'   => 50
   )
) );

$wp_customize->add_setting( 'pa_letterspacing',
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
        'pa_letterspacing',
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'settings'       => 'pa_letterspacing',
            'input_attrs'    => array('step' => '0.01'),
            'type'           => 'number',
            'priority'       => 55
        )
    )
);

// #text

$wp_customize->add_setting( 'pa_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'pa_opacity',
   array(
      'label' => 'Opacity (%)',
      'section' => $section,
      'settings' => 'pa_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 80,
   )
) );

$wp_customize->add_setting( 'pa_mouseover_color',
   array(
      'default' => '#000000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'pa_mouseover_color',
   array(
      'label' => 'Mouseover Color',
      'section' => $section,
      'settings' => 'pa_mouseover_color',
      'priority'   => 90
   )
) );

$wp_customize->add_setting( 'pa_mouseover_opacity',
   array(
      'default' => '100',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'pa_mouseover_opacity',
   array(
      'label' => 'Mouseover Opacity (%)',
      'section' => $section,
      'settings' => 'pa_mouseover_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 100,
   )
) );
