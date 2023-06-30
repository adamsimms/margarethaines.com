<?php

$section = 'mobile_spaces';
$descr = "";
if(get_option('misc_options_extra_gridder_for_phone', 'on') == "on"){
  $descr = 'These settings are only for automatically generated phone versions of your layouts. To change these spaces for your custom phone layouts go to "Lay Options" &rarr; "Gridder Defaults" &rarr; "Phone Gridder Defaults".';
}

$wp_customize->add_section( $section,
   array(
      'title' => 'Mobile Spaces',
      'priority' => 20,
      'capability' => 'edit_theme_options',
      'panel' => 'mobile_panel',
      'description'    => $descr
   )
);

$wp_customize->add_setting( 'mobile_space_between_elements_mu',
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
        'mobile_space_between_elements_mu',
        array(
            'label'          => 'Space between Elements in',
            'section'        => $section,
            'settings'       => 'mobile_space_between_elements_mu',
            'type'           => 'select',
            'priority'       => 19,
            'choices'        => array('px' => 'px', '%' => '%')
        )
    )
);
$wp_customize->add_setting( 'mobile_space_between_elements',
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
        'mobile_space_between_elements',
        array(
            'label'          => 'Space between Elements',
            'section'        => $section,
            'settings'       => 'mobile_space_between_elements',
            'type'           => 'number',
            'priority'       => 20
        )
    )
);

$wp_customize->add_setting( 'mobile_space_leftright_mu',
   array(
      'default' => 'vw',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_space_leftright_mu',
        array(
            'label'          => 'Space left and right of Content in',
            'section'        => $section,
            'settings'       => 'mobile_space_leftright_mu',
            'type'           => 'select',
            'priority'       => 29,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'mobile_space_leftright',
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
        'mobile_space_leftright',
        array(
            'label'          => 'Space left and right of Content',
            'section'        => $section,
            'settings'       => 'mobile_space_leftright',
            'type'           => 'number',
            'priority'       => 30
        )
    )
);

$wp_customize->add_setting( 'mobile_space_top_mu',
   array(
      'default' => 'vw',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_space_top_mu',
        array(
            'label'          => 'Space Top in',
            'section'        => $section,
            'settings'       => 'mobile_space_top_mu',
            'type'           => 'select',
            'priority'       => 39,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'mobile_space_top',
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
        'mobile_space_top',
        array(
            'label'          => 'Space Top',
            'section'        => $section,
            'settings'       => 'mobile_space_top',
            'type'           => 'number',
            'priority'       => 40
        )
    )
);

$wp_customize->add_setting( 'mobile_space_bottom_mu',
   array(
      'default' => 'vw',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_space_bottom_mu',
        array(
            'label'          => 'Space Bottom in',
            'section'        => $section,
            'settings'       => 'mobile_space_bottom_mu',
            'type'           => 'select',
            'priority'       => 49,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'mobile_space_bottom',
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
        'mobile_space_bottom',
        array(
            'label'          => 'Space Bottom',
            'section'        => $section,
            'settings'       => 'mobile_space_bottom',
            'type'           => 'number',
            'priority'       => 50
        )
    )
);

// footer

$wp_customize->add_setting( 'mobile_space_top_footer_mu',
   array(
      'default' => 'vw',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_space_top_footer_mu',
        array(
            'label'          => 'Space Top Footer in',
            'section'        => $section,
            'settings'       => 'mobile_space_top_footer_mu',
            'type'           => 'select',
            'priority'       => 55,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'mobile_space_top_footer',
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
        'mobile_space_top_footer',
        array(
            'label'          => 'Space Top Footer',
            'section'        => $section,
            'settings'       => 'mobile_space_top_footer',
            'type'           => 'number',
            'priority'       => 60
        )
    )
);

$wp_customize->add_setting( 'mobile_space_bottom_footer_mu',
   array(
      'default' => 'vw',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'mobile_space_bottom_footer_mu',
        array(
            'label'          => 'Space Bottom Footer in',
            'section'        => $section,
            'settings'       => 'mobile_space_bottom_footer_mu',
            'type'           => 'select',
            'priority'       => 65,
            'choices'        => array('px' => 'px', 'vw' => '%')
        )
    )
);
$wp_customize->add_setting( 'mobile_space_bottom_footer',
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
        'mobile_space_bottom_footer',
        array(
            'label'          => 'Space Bottom Footer',
            'section'        => $section,
            'settings'       => 'mobile_space_bottom_footer',
            'type'           => 'number',
            'priority'       => 70
        )
    )
);