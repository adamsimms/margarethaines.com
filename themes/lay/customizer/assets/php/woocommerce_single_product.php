<?php

function show_image_space_settings(){
    $layout_type = get_theme_mod('lay_woocommerce_singleproduct_layout_type', 'one_image_per_row');
    
    return ($layout_type == 'one_image_per_row' || $layout_type == 'carousel') ? true : false;
}

function wc_sp_is_carousel(){
    $layout_type = get_theme_mod('lay_woocommerce_singleproduct_layout_type', 'one_image_per_row');
    return $layout_type == 'carousel';
}

$section = 'lay_woocommerce_single_product';
$descr = "";

$wp_customize->add_section( $section,
   array(
      'title' => 'Single Product',
      'priority' => 5,
      'capability' => 'edit_theme_options',
      'panel' => 'woocommerce',
      'description'    => $descr
   )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_layout_type',
   array(
      'default' => 'one_image_per_row',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh'
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_layout_type',
        array(
            'label'          => 'Layout Type',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_layout_type',
            'type'           => 'radio',
            'priority'       => 0,
            'choices'        => array(
               'two_images_per_row' => 'Two Images per Row',
               'one_image_per_row' => 'One Image per Row',
               'carousel' => 'Carousel'
            )
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_show_quantity_input',
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
        'lay_woocommerce_singleproduct_show_quantity_input',
        array(
            'label'          => 'Show Quantity Input',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_show_quantity_input',
            'type'           => 'checkbox',
            'priority'       => 2,
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_show_first_image',
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
        'lay_woocommerce_singleproduct_show_first_image',
        array(
            'label'          => 'Show First Image',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_show_first_image',
            'type'           => 'checkbox',
            'priority'       => 2,
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_quantity_type',
   array(
      'default' => 'big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_quantity_type',
        array(
            'label'          => 'Quantity Input Type',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_quantity_type',
            'type'           => 'select',
            'priority'       => 2,
            'choices'        => array(
                'big' => 'Big',
                'small' => 'Small',
                'round' => 'Round'
            )
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_show_carousel_buttons',
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
        'lay_woocommerce_singleproduct_show_carousel_buttons',
        array(
            'label'          => 'Show Carousel Prev/Next Buttons',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_show_carousel_buttons',
            'type'           => 'checkbox',
            'priority'       => 1,
            'active_callback' => 'wc_sp_is_carousel',
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_image_width',
   array(
      'default' => 48.9,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_image_width',
        array(
            'label'          => 'Image Width (%)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_image_width',
            'type'           => 'number',
            'priority'       => 2,
            'active_callback' => 'show_image_space_settings',
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_image_space_left',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_image_space_left',
        array(
            'label'          => 'Space Left (%)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_image_space_left',
            'type'           => 'number',
            'priority'       => 3,
            'active_callback' => 'show_image_space_settings',
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_text_width_2',
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
        'lay_woocommerce_singleproduct_text_width_2',
        array(
            'label'          => 'Text Width (%)',
            'description'    => 'This is the text width when your product only has text and not text in product tabs',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_text_width_2',
            'type'           => 'number',
            'priority'       => 4
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_text_spacetop',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_text_spacetop',
        array(
            'label'          => 'Text Space Top(px)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_text_spacetop',
            'type'           => 'number',
            'priority'       => 4
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_sticky',
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
        'lay_woocommerce_singleproduct_sticky',
        array(
            'label'          => 'Make Text Sticky',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_sticky',
            'type'           => 'checkbox',
            'priority'       => 5,
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_text_sticky_spacetop',
   array(
      'default' => 100,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_text_sticky_spacetop',
        array(
            'label'          => 'Text Sticky Space Top(px)',
            'description'    => 'Space between Text and top browser edge when scrolling down',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_text_sticky_spacetop',
            'type'           => 'number',
            'priority'       => 6
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_text_spaceleft',
   array(
      'default' => 2,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_text_spaceleft',
        array(
            'label'          => 'Text Space Left(%)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_text_spaceleft',
            'type'           => 'number',
            'priority'       => 7
        )
    )
);

// headline textformat
$wp_customize->add_setting( 'lay_woocommerce_singleproduct_headline_textformat',
   array(
      'default' => 'Shop_Big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_headline_textformat',
        array(
            'label'          => 'Headline Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_headline_textformat',
            'type'           => 'select',
            'priority'       => 8,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_headline_spacebelow',
   array(
      'default' => 0,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_headline_spacebelow',
        array(
            'label'          => 'Headline Space Bottom(em)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_headline_spacebelow',
            'type'           => 'number',
            'priority'       => 10
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_shortdescription_textformat',
   array(
      'default' => 'Shop_Big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_shortdescription_textformat',
        array(
            'label'          => 'Short Description Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_shortdescription_textformat',
            'type'           => 'select',
            'priority'       => 15,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_price_textformat',
   array(
      'default' => 'Shop_Big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_price_textformat',
        array(
            'label'          => 'Price Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_price_textformat',
            'type'           => 'select',
            'priority'       => 20,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_price_spacetop',
   array(
      'default' => 1.3,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_price_spacetop',
        array(
            'label'          => 'Price Space Top(em)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_price_spacetop',
            'type'           => 'number',
            'priority'       => 25
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_price_spacebelow',
   array(
      'default' => 1.3,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_price_spacebelow',
        array(
            'label'          => 'Price Space Bottom(em)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_price_spacebelow',
            'type'           => 'number',
            'priority'       => 30
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_variations_textformat',
   array(
      'default' => 'Shop_Big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_variations_textformat',
        array(
            'label'          => 'Variations Selectbox Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_variations_textformat',
            'type'           => 'select',
            'priority'       => 32,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_variations_text_textformat',
   array(
      'default' => 'Shop_Big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_variations_text_textformat',
        array(
            'label'          => 'Variations Text Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_variations_text_textformat',
            'type'           => 'select',
            'priority'       => 33,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_qty_textformat',
   array(
      'default' => 'Shop_Big',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_qty_textformat',
        array(
            'label'          => 'Quantity Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_qty_textformat',
            'type'           => 'select',
            'priority'       => 35,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_product_description_textformat',
   array(
      'default' => 'Shop_Small',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_product_description_textformat',
        array(
            'label'          => 'Product Description Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_product_description_textformat',
            'type'           => 'select',
            'priority'       => 36,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_related_products_headline_textformat',
   array(
      'default' => 'Shop_Product_Thumbnails',
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_related_products_headline_textformat',
        array(
            'label'          => '"Related Products" / "You may also like…" Headline Text Format',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_related_products_headline_textformat',
            'type'           => 'select',
            'priority'       => 40,
            'choices'        => Customizer::$textformatsSelect
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_related_text', array(
    'default'    => 'Related Products',
    'type'       => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
  )
);

$wp_customize->add_control( 'lay_woocommerce_singleproduct_related_text', array(
    'label'      => '"Related Products" text',
    'section'    => $section,
    'priority'   => 45,
    'type'       => 'text',
  )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_youmayalsolike_text', array(
    'default'    => 'You may also like',
    'type'       => 'theme_mod',
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
  )
);

$wp_customize->add_control( 'lay_woocommerce_singleproduct_youmayalsolike_text', array(
    'label'      => '"You may also like" text',
    'section'    => $section,
    'description'=> 'Headline for Upsells',
    'priority'   => 50,
    'type'       => 'text',
  )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_related_products_spacetop',
   array(
      'default' => 3,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_related_products_spacetop',
        array(
            'label'          => '"Related Products" / "You may also like…" Space Top(%)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_related_products_spacetop',
            'type'           => 'number',
            'priority'       => 55
        )
    )
);

$wp_customize->add_setting( 'lay_woocommerce_singleproduct_related_products_spacebelow',
   array(
      'default' => 1.5,
      'type' => 'theme_mod',
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
   )
);
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'lay_woocommerce_singleproduct_related_products_spacebelow',
        array(
            'label'          => '"Related Products" / "You may also like…" Space Bottom(%)',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_singleproduct_related_products_spacebelow',
            'type'           => 'number',
            'priority'       => 60
        )
    )
);