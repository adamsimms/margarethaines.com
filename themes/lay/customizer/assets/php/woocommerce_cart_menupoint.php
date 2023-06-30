<?php
$section = 'lay_woocommerce_cart_menupoint';


$wp_customize->add_section( $section,
   array(
      'title' => 'Cart Menupoint',
      'priority' => 16,
      'capability' => 'edit_theme_options',
      'panel' => 'woocommerce',
      'description' => '<a target="_blank" href="https://laytheme.com/documentation/shop-setup.html#cart-menu-point">How to add a Cart Menupoint</a>',
   )
);

$wp_customize->add_setting( 'lay_woocommerce_cart_menupoint_hide_empty',
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
        'lay_woocommerce_cart_menupoint_hide_empty',
        array(
            'label'          => 'Hide when empty',
            'section'        => $section,
            'settings'       => 'lay_woocommerce_cart_menupoint_hide_empty',
            'type'           => 'checkbox',
            'priority'       => 0,
        )
    )
);