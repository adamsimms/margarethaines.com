<?php
// for primary menu, section name is 'menu' (for backwards compatibility)
// other section names are: "menu_".$menu_type

$section = 'menu_'.$this->menu_type;
if( $this->menu_type == PRIMARY_MENU ){
    $section = 'menu';
}

$title = LayMenuManager::get_description_by_location($this->menu_type);

$wp_customize->add_section( $section,
    array(
    'title' => $title,
    'priority' => 5,
    'capability' => 'edit_theme_options',
    'panel' => 'navigation_panel'
    )
);

// NO SUFFIX but name in between for backwards compatibility
$wp_customize->add_setting( 'hide_'.$this->menu_type.'_menu',
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
        'hide_'.$this->menu_type.'_menu',
        array(
            'label'          => 'hide Menu for Desktop Version',
            'section'        => $section,
            'settings'       => 'hide_'.$this->menu_type.'_menu',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);

$wp_customize->add_setting( 'nav_arrangement'.$this->suffix,
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
        'nav_arrangement'.$this->suffix,
        array(
            'label'          => 'Menu Points Arrangement',
            'section'        => $section,
            'settings'       => 'nav_arrangement'.$this->suffix,
            'type'           => 'select',
            'priority'       => 5,
            'choices'        => array('horizontal' => 'horizontal', 'vertical' => 'vertical'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_textalign'.$this->suffix,
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
        'nav_textalign'.$this->suffix,
        array(
            'label'          => 'Text Align',
            'section'        => $section,
            'settings'       => 'nav_textalign'.$this->suffix,
            'type'           => 'select',
            'priority'       => 10,
            'choices'        => array('left' => 'left', 'center' => 'center', 'right' => 'right'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_isfixed'.$this->suffix,
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
        'nav_isfixed'.$this->suffix,
        array(
            'label'          => 'is fixed',
            'section'        => $section,
            'settings'       => 'nav_isfixed'.$this->suffix,
            'type'           => 'checkbox',
            'priority'       => 14,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_hidewhenscrolling'.$this->suffix,
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
        'nav_hidewhenscrolling'.$this->suffix,
        array(
            'label'          => 'move away when scrolling down',
            'section'        => $section,
            'settings'       => 'nav_hidewhenscrolling'.$this->suffix,
            'type'           => 'checkbox',
            'priority'       => 17,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_fadeout_whenscrolling'.$this->suffix,
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
        'nav_fadeout_whenscrolling'.$this->suffix,
        array(
            'label'          => 'fade out when scrolling down',
            'section'        => $section,
            'settings'       => 'nav_fadeout_whenscrolling'.$this->suffix,
            'type'           => 'checkbox',
            'priority'       => 17,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_hidewhenscrolling_show_on_mouseover'.$this->suffix,
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
        'nav_hidewhenscrolling_show_on_mouseover'.$this->suffix,
        array(
            'label'          => 'show menu again on mouseover',
            'section'        => $section,
            'settings'       => 'nav_hidewhenscrolling_show_on_mouseover'.$this->suffix,
            'type'           => 'checkbox',
            'priority'       => 18,
            'active_callback' => array($this, 'show_nav_hidewhenscrolling_show_on_mouseover')
        )
    )
);

$wp_customize->add_setting( 'nav_position'.$this->suffix,
    array(
    'default' => 'top-right',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'nav_position'.$this->suffix,
        array(
            'label'          => 'Position',
            'section'        => $section,
            'settings'       => 'nav_position'.$this->suffix,
            'type'           => 'select',
            'priority'       => 20,
            'choices'        => array('top-left' => 'top left', 'top-center' => 'top center', 'top-right' => 'top right', 'bottom-left' => 'bottom left', 'bottom-center' => 'bottom center', 'bottom-right' => 'bottom right'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

// space top
$wp_customize->add_setting( 'nav_spacetop_mu'.$this->suffix,
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
        'nav_spacetop_mu'.$this->suffix,
        array(
            'label'          => 'Space Top in',
            'section'        => $section,
            'settings'       => 'nav_spacetop_mu'.$this->suffix,
            'type'           => 'select',
            'priority'       => 21,
            'choices'        => array('px' => 'px', 'vw' => '%'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);
$wp_customize->add_setting( 'nav_spacetop'.$this->suffix,
    array(
    'default' => '20',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'nav_spacetop'.$this->suffix,
        array(
            'label'          => 'Space Top',
            'section'        => $section,
            'settings'       => 'nav_spacetop'.$this->suffix,
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 22,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

// space bottom
$wp_customize->add_setting( 'nav_spacebottom_mu'.$this->suffix,
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
        'nav_spacebottom_mu'.$this->suffix,
        array(
            'label'          => 'Space Bottom in',
            'section'        => $section,
            'settings'       => 'nav_spacebottom_mu'.$this->suffix,
            'type'           => 'select',
            'priority'       => 21,
            'choices'        => array('px' => 'px', 'vw' => '%'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);
$wp_customize->add_setting( 'nav_spacebottom'.$this->suffix,
    array(
    'default' => '20',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'nav_spacebottom'.$this->suffix,
        array(
            'label'          => 'Space Bottom',
            'section'        => $section,
            'settings'       => 'nav_spacebottom'.$this->suffix,
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 22,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

// space left
$wp_customize->add_setting( 'nav_spaceleft_mu'.$this->suffix,
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
        'nav_spaceleft_mu'.$this->suffix,
        array(
            'label'          => 'Space Left in',
            'section'        => $section,
            'settings'       => 'nav_spaceleft_mu'.$this->suffix,
            'type'           => 'select',
            'priority'       => 23,
            'choices'        => array('%' => '%', 'px' => 'px'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);
$wp_customize->add_setting( 'nav_spaceleft'.$this->suffix,
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
        'nav_spaceleft'.$this->suffix,
        array(
            'label'          => 'Space Left',
            'section'        => $section,
            'settings'       => 'nav_spaceleft'.$this->suffix,
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 24,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

// spaceright
$wp_customize->add_setting( 'nav_spaceright_mu'.$this->suffix,
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
        'nav_spaceright_mu'.$this->suffix,
        array(
            'label'          => 'Space Right in',
            'section'        => $section,
            'settings'       => 'nav_spaceright_mu'.$this->suffix,
            'type'           => 'select',
            'priority'       => 25,
            'choices'        => array('%' => '%', 'px' => 'px'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);
$wp_customize->add_setting( 'nav_spaceright'.$this->suffix,
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
        'nav_spaceright'.$this->suffix,
        array(
            'label'          => 'Space Right',
            'section'        => $section,
            'settings'       => 'nav_spaceright'.$this->suffix,
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 26,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_spacebetween'.$this->suffix,
    array(
    'default' => '20',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'nav_spacebetween'.$this->suffix,
        array(
            'label'          => 'Space Between (px)',
            'section'        => $section,
            'settings'       => 'nav_spacebetween'.$this->suffix,
            'type'           => 'number',
            'priority'       => 35,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_textformat'.$this->suffix,
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
        'nav_textformat'.$this->suffix,
        array(
            'label'          => 'Text Format',
            'section'        => $section,
            'settings'       => 'nav_textformat'.$this->suffix,
            'type'           => 'select',
            'priority'       => 36,
            'choices'        => Customizer::$textformatsSelect,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_fontfamily'.$this->suffix,
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
        'nav_fontfamily'.$this->suffix,
        array(
            'label'          => 'Font Family',
            'section'        => $section,
            'settings'       => 'nav_fontfamily'.$this->suffix,
            'type'           => 'select',
            'choices'        => Customizer::$fonts,
            'priority'       => 40,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_fontsize_mu'.$this->suffix,
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
        'nav_fontsize_mu'.$this->suffix,
        array(
            'label'          => 'Font Size in',
            'section'        => $section,
            'settings'       => 'nav_fontsize_mu'.$this->suffix,
            'type'           => 'select',
            'priority'       => 41,
            'choices'        => array('px' => 'px', 'vw' => '%'),
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_fontsize'.$this->suffix,
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
        'nav_fontsize'.$this->suffix,
        array(
            'label'          => 'Font Size',
            'section'        => $section,
            'settings'       => 'nav_fontsize'.$this->suffix,
            'type'           => 'number',
            'input_attrs'    => array('step' => '0.1'),
            'priority'       => 45,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_fontweight'.$this->suffix,
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
        'nav_fontweight'.$this->suffix,
        array(
            'label'          => 'Font Weight',
            'section'        => $section,
            'settings'       => 'nav_fontweight'.$this->suffix,
            'type'           => 'select',
            'choices'        => array_flip(FormatsManager::$fontWeights),
            'priority'       => 50,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_color'.$this->suffix,
    array(
    'default' => Customizer::$defaults['color'],
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'postMessage',
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize,
    'nav_color'.$this->suffix,
    array(
    'label' => 'Text Color',
    'section' => $section,
    'settings' => 'nav_color'.$this->suffix,
    'priority'   => 60,
    'active_callback' => array($this, 'is_menu_hidden')
    )
) );

$wp_customize->add_setting( 'nav_letterspacing'.$this->suffix,
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
        'nav_letterspacing'.$this->suffix,
        array(
            'label'          => 'Letter Spacing (em)',
            'section'        => $section,
            'input_attrs'    => array('step' => '0.01'),
            'settings'       => 'nav_letterspacing'.$this->suffix,
            'type'           => 'number',
            'priority'       => 65,
            'active_callback' => array($this, 'is_menu_hidden')
        )
    )
);

$wp_customize->add_setting( 'nav_opacity'.$this->suffix,
    array(
    'default' => '100',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'nav_opacity'.$this->suffix,
    array(
    'label' => 'Opacity (%)',
    'section' => $section,
    'settings' => 'nav_opacity'.$this->suffix,
    'type'           => 'number',
    'input_attrs' => array('min' => '0', 'max' => '100'),
    'priority' => 70,
    'active_callback' => array($this, 'is_menu_hidden')
    )
) );

$wp_customize->add_setting( 'nav_underline_strokewidth'.$this->suffix,
    array(
    'default' => 0,
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'nav_underline_strokewidth'.$this->suffix,
    array(
    'label' => 'Underline Strokewidth',
    'description' => 'Underline Offset settings are the ones used in "Customize" → "Links in Texts"',
    'section' => $section,
    'settings' => 'nav_underline_strokewidth'.$this->suffix,
    'type' => 'number',
    'priority' => 80,
    'active_callback' => array($this, 'is_menu_hidden')
    )
) );
?>