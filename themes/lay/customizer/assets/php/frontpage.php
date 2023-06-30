<?php

$section = 'frontpage_options';

$wp_customize->add_section( $section,
   array(
      'title' => 'Front Page',
      'priority' => 99,
      'capability' => 'edit_theme_options',
      'active_callback' => 'LTUtility::is_frontpage'
   )
);

$wp_customize->add_setting( 'frontpage_type',
   array(
      'default' => 'category',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'frontpage_type',
        array(
            'label'          => 'Front Page displays',
            'section'        => $section,
            'settings'       => 'frontpage_type',
            'type'           => 'radio',
            'priority'       => 10,
            'choices'        => array('category' => 'Category', 'page' => 'Page', 'project' => 'Project')
        )
    )
);

$wp_customize->add_setting( 'frontpage_select_category',
   array(
      'default' => '1',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new Category_Dropdown_Custom_Control(
        $wp_customize,
        'frontpage_select_category',
        array(
            'label'          => 'Choose a Category',
            'section'        => $section,
            'settings'       => 'frontpage_select_category',
            'priority'       => 20,
        ),
        array(
            'type'                     => 'post',
            'child_of'                 => 0,
            'parent'                   => '',
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hide_empty'               => 0,
            'hierarchical'             => 1,
            'exclude'                  => '',
            'include'                  => '',
            'number'                   => '',
            'taxonomy'                 => 'category',
            'pad_counts'               => false
      )
    )
);

$wp_customize->add_setting( 'frontpage_select_page',
   array(
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new Post_Dropdown_Custom_Control(
        $wp_customize,
        'frontpage_select_page',
        array(
            'label'          => 'Choose a Page',
            'section'        => $section,
            'settings'       => 'frontpage_select_page',
            'priority'       => 30,
        ),
        array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page'   => -1,
      )
    )
);

$wp_customize->add_setting( 'frontpage_select_project',
   array(
      'default' => '',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new Post_Dropdown_Custom_Control(
        $wp_customize,
        'frontpage_select_project',
        array(
            'label'          => 'Choose a Project',
            'section'        => $section,
            'settings'       => 'frontpage_select_project',
            'priority'       => 40,
        ),
        array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page'   => -1,
        )
    )
);
