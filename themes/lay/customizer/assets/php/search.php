<?php
function is_autosuggest_shown(){
    $is_hidden = get_theme_mod('search_autosuggest_hide', false);
    $is_shown = !$is_hidden;
    return $is_shown;
}

function show_search_textformat(){
    $v = get_theme_mod('search_use_textformat', false);
    if( $v == 1 ) {
        return true;
    }
    return false;
}

function show_search_fontfamily(){
    $v = get_theme_mod('search_use_textformat', false);
    if( $v == 1 ) {
        return false;
    }
    return true;
}

$section = 'search_section';

$wp_customize->add_section( $section,
   array(
      'title' => 'Search',
      'priority' => 50,
      'capability' => 'edit_theme_options',
      'description' => 'How to use the Search feature: Create a "Custom Link" menu point with a URL of "#search" (without "") in Appearance → Menus. When clicking on that link, the search overlay you see here will appear.'
   )
);

$wp_customize->add_setting( 'search_placeholder_text', array(
   'default'    => 'Type your search…',
   'type'       => 'theme_mod',
   'capability' => 'edit_theme_options',
   'transport'  => 'postMessage',
 )
);
$wp_customize->add_control( 'search_placeholder_text', array(
   'label'      => 'Placeholder Text',
   'type'       => 'text',
   'section'    => $section,
   'priority'   => 0
 )
);


$wp_customize->add_setting( 'search_fontfamily',
   array(
      'default' => Customizer::$defaults['fontfamily'],
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
// http://codex.wordpress.org/Class_Reference/WP_Customize_Control
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'search_fontfamily',
        array(
            'label'          => 'Font Family for Input and Auto Suggestions',
            'section'        => $section,
            'settings'       => 'search_fontfamily',
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 0,
            // 'active_callback'=> 'show_search_fontfamily'
        )
    )
);

$wp_customize->add_setting( 'search_use_textformat',
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
        'search_use_textformat',
        array(
            'label'          => 'Use Textformat for Input',
            'section'        => $section,
            'settings'       => 'search_use_textformat',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'search_textformat',
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
        'search_textformat',
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'search_textformat',
            'type'           => 'select',
            'priority'       => 0,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => 'show_search_textformat'
        )
    )
);

$wp_customize->add_setting( 'search_background_color',
   array(
      'default' => '#ffffff',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'search_background_color',
   array(
      'label' => 'Background Color',
      'section' => $section,
      'settings' => 'search_background_color',
      'priority'   => 0,
   )
) );

$wp_customize->add_setting( 'search_background_opacity',
   array(
      'default' => '85',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   ) 
);      
$wp_customize->add_control( new WP_Customize_Control(
   $wp_customize,
   'search_background_opacity',
   array(
      'label' => 'Background Opacity (%)',
      'section' => $section,
      'settings' => 'search_background_opacity',
      'type' => 'number',
      'input_attrs' => array('min' => '0', 'max' => '100'),
      'priority' => 0,
   )
) );

$wp_customize->add_setting( 'search_background_blurry',
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
        'search_background_blurry',
        array(
            'label'          => 'Blurry background',
            'section'        => $section,
            'settings'       => 'search_background_blurry',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'search_close_color',
   array(
      'default' => '#000000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'search_close_color',
   array(
      'label' => '"X" Icon Color',
      'section' => $section,
      'settings' => 'search_close_color',
      'priority'   => 0,
   )
) );

$wp_customize->add_setting( 'search_bar_placeholder_color',
   array(
      'default' => '#ccc',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'search_bar_placeholder_color',
   array(
      'label' => '"Type your search…" Text Color',
      'section' => $section,
      'settings' => 'search_bar_placeholder_color',
      'priority'   => 0,
   )
) );

$wp_customize->add_setting( 'search_text_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'search_text_color',
   array(
      'label' => 'Entered Search Text Color',
      'section' => $section,
      'settings' => 'search_text_color',
      'priority'   => 0,
   )
) );

$wp_customize->add_setting( 'search_text_selection_color',
   array(
      'default' => '#f5f5f5',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'search_text_selection_color',
   array(
      'label' => 'Search Text Selection Background Color (Double-click on entered text in search bar. The background color is this color.)',
      'section' => $section,
      'settings' => 'search_text_selection_color',
      'priority'   => 0,
   )
) );

$wp_customize->add_setting( 'search_autosuggest_hide',
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
        'search_autosuggest_hide',
        array(
            'label'          => 'Hide Auto-Suggestions',
            'section'        => $section,
            'settings'       => 'search_autosuggest_hide',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'search_autosuggest_text_color',
   array(
      'default' => '#aaa',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'postMessage',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'search_autosuggest_text_color',
   array(
      'label' => 'Autosuggest Text Color (suggestion list when searching for something)',
      'section' => $section,
      'settings' => 'search_autosuggest_text_color',
      'priority'   => 0,
      'active_callback' => 'is_autosuggest_shown',
   )
) );

$wp_customize->add_setting( 'search_autosuggest_mouseover_text_color',
   array(
      'default' => '#000',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
   $wp_customize,
   'search_autosuggest_mouseover_text_color',
   array(
      'label' => 'Autosuggest Text Mouseover Color',
      'section' => $section,
      'settings' => 'search_autosuggest_mouseover_text_color',
      'priority'   => 0,
      'active_callback' => 'is_autosuggest_shown'
   )
) );