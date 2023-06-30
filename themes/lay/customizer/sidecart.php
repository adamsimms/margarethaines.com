<?php

// todo: use same option names or theme mod names that are being set here:
// http://laythemereact.test/wp-admin/admin.php?page=side-cart-woocommerce-settings
// this way when we change a setting here, it will also be changed in the plugin's setting screen

/*
this is how it will work.

below there's the data structure, that i get when i call the plugin's function:

public function get_style_option( $subkey = '' ){
    error_log( print_r($this->get_option( 'xoo-wsc-sy-options', $subkey ), true) );
    return $this->get_option( 'xoo-wsc-sy-options', $subkey );
}

this is how the data is saved in the plugin:

public function save_settings(){

    $formData = array();
    $parseFormData = parse_str( $_POST['form'], $formData );

    foreach ( $formData as $option_key => $option_data ) {
        update_option( $option_key, $option_data );
    }

    wp_send_json(array(
        'error' 	=> 0,
        'notice' 	=> 'Settings Saved',
    ));
}

I will do this:

all standard values should be the plugin's values

on customizer save, or publish, I will get all my data via get_theme_mod and then save that data into the appropriate option
also i will change the names of my theme mods to the corresponding names of the plugin's keys

i will remove my own css in css_output that would overwrite the plugin's css

maybe i will have extra options in the customizer for side cart that do not have corresponding plugin options

todo: I'd like to have different standard settings than the ones we currently have. to do this maybe i should do the following steps:
    1.: remove all my css for sidecart
    2.: create the style using the plugin's options
    3.: create a notification so users can click on it and set lay theme's preferred styling options

todo: one day i'll need to buy the plugin and then make it compatible with laytheme

data structure:
the ones marked with √ are the ones i want to create customizer theme mods for
probably i should just create theme_mods for almost all of these

(
    [scm-width] => 500 √
    [scm-height] => auto
    [scm-open-from] => right
    [scm-font] => \'Comic Sans\'
    [sck-enable] => always_hide
    [sck-show-count] => yes
    [sck-basket-icon] => xoo-wsc-icon-basket1
    [sck-cust-icon] => 
    [sck-position] => bottom
    [sck-offset] => 12
    [sck-hoffset] => 0
    [sck-count-pos] => top_left
    [sck-basket-color] => #000000
    [sck-basket-bg] => #ffffff
    [sck-basket-sh] => 0 1px 4px 0
    [sck-count-color] => #ffffff
    [sck-count-bg] => #000000
    [sch-head-align] => center √
    [sch-close-align] => right √
    [sch-close-icon] => xoo-wsc-icon-cross √
    [sch-close-fsize] => 16 √
    [sch-head-fsize] => 20 √
    [sch-sbcolor] => #1e73be √
    [sch-bgcolor] => #ffffff √
    [sch-txtcolor] => #000000 √
    [scb-del-icon] => xoo-wsc-icon-trash √
    [scb-fsize] => 16 √
    [scb-bgcolor] => #ffffff √
    [scb-txtcolor] => #000000 √
    [scb-empty-img] => 
    [scbp-imgw] => 30 √
    [scbp-padding] => 20px 15px √
    [scbp-display] => center √
    [scbp-qpdisplay] => one_liner √
    [scbq-style] => square √
    [scbq-width] => 75 √
    [scbq-height] => 28 √
    [scbq-bsize] => 1 √
    [scbq-input-bcolor] => #000000 √
    [scbq-box-bcolor] => #000000 √
    [scbq-input-bgcolor] => #ffffff √
    [scbq-input-txtcolor] => #000000 √
    [scbq-box-bgcolor] => #ffffff √
    [scbq-box-txtcolor] => #000000 √
    [scf-padding] => 10px 20px √
    [scf-fsize] => 18 √
    [scf-bgcolor] => #ffffff √
    [scf-txtcolor] => #000000 √
    [scf-coup-icon] => xoo-wsc-icon-coupon-8
    [scf-button-pos] => Array
        (
            [0] => continue
            [1] => cart
            [2] => checkout
        )

    [scf-btns-row] => one
    [scf-btns-theme] => theme
    [scf-btn-bgcolor] => #ffffff √
    [scf-btn-txtcolor] => #000000 √
    [scf-btn-border] => 2px solid #000000 √
    [scsp-style] => wide √
    [scsp-location] => after √
    [scsp-imgw] => 80 √
    [scsp-fsize] => 14 √
    [scsp-bgcolor] => #eee √
)

*/


// todo: make changes done in the custmizer immediately show up on sidecart
// todo: make sure all values are correctly mirrored in side cart options of plugin
// todo: when i change values in plugin's settings, set theme mods so the values are set in customizer

// for xoo sidecart plugin
class Lay_SideCart{

    public static $sidecart_style_options;

    public function __construct() {
        add_action( 'after_setup_theme', array($this, 'lay_get_sidecart_option') );
        // todo: this function is never called
        // add_action( 'wp_ajax_lay_sidecart_set_default_settings', array( $this, 'set_default_sidecart_settings' ), 5 );
        add_action( 'customize_save_after', array($this, 'lay_save_sidecart_options_into_plugin_options') );
        add_filter( 'xoo_wsc_product_args', array($this, 'force_sidecart_setting'), 10, 4 );
    }

    public static function force_sidecart_setting( $args, $_product, $cart_item, $cart_item_key ){
        // error_log(print_r($args, true));
        $args['qtyPriceDisplay'] = 'separate';
        return $args;
    }

    public static function lay_save_sidecart_options_into_plugin_options() {
        // 'sch-txtcolor', 'sch-bgcolor', 'scb-bgcolor', 'scb-txtcolor', 'scf-bgcolor', 'scf-txtcolor'
        $array = get_option( 'xoo-wsc-sy-options');
        if( is_array($array) ) {
            $new_array = array(
                'scm-width' => get_theme_mod('scm-width', Lay_SideCart::$sidecart_style_options['scm-width']),
                'scbp-imgw' => get_theme_mod('scbp-imgw', Lay_SideCart::$sidecart_style_options['scbp-imgw']),
                
                'sch-txtcolor' => get_theme_mod('scb-txtcolor', Lay_SideCart::$sidecart_style_options['scb-txtcolor']),
                'sch-bgcolor' => get_theme_mod('scb-bgcolor', Lay_SideCart::$sidecart_style_options['scb-bgcolor']),
                
                'scb-txtcolor' => get_theme_mod('scb-txtcolor', Lay_SideCart::$sidecart_style_options['scb-txtcolor']),
                'scb-bgcolor' => get_theme_mod('scb-bgcolor', Lay_SideCart::$sidecart_style_options['scb-bgcolor']),
                
                'scf-txtcolor' => get_theme_mod('scb-txtcolor', Lay_SideCart::$sidecart_style_options['scb-txtcolor']),
                'scf-bgcolor' => get_theme_mod('scb-bgcolor', Lay_SideCart::$sidecart_style_options['scb-bgcolor']),
            );
            $array_result = array_merge($array, $new_array);
            update_option('xoo-wsc-sy-options', $array_result);
        }
    }

    public static function lay_get_sidecart_option() {
        // style:
        $option_style = get_option( 'xoo-wsc-sy-options');
        $option_general = get_option( 'xoo-wsc-gl-options');
        $option_advanced = get_option( 'xoo-wsc-av-options');

        Lay_SideCart::$sidecart_style_options = $option_style;
        // return $option;
        // error_log(print_r($option_advanced, true));
    }	

    // // todo: create a button to save this
    // public static function set_default_sidecart_settings() {
    //     // style:
    //     /* 
    //         xoo-wsc-gl-options
    //         xoo-wsc-sy-options
    //         xoo-wsc-av-options
    //     */
    //     // sy = style
    //     // gl = general
    //     // av = advanced
    //     $array = array(
    //         'scm-width' => 323,
    //         'scm-height' => 'full',
    //         'scm-open-from' => 'right',
    //         'scm-font' => '',
    //         'sck-enable' => 'always_hide',
    //         'sck-show-count' => 'yes',
    //         'sck-basket-icon' => 'xoo-wsc-icon-basket1',
    //         'sck-cust-icon' => '',
    //         'sck-position' => 'bottom',
    //         'sck-offset' => 12,
    //         'sck-hoffset' => 0,
    //         'sck-count-pos' => 'top_left',
    //         'sck-basket-color' => '#000000',
    //         'sck-basket-bg' => '#ffffff',
    //         'sck-basket-sh' => '0 1px 4px 0',
    //         'sck-count-color' => '#ffffff',
    //         'sck-count-bg' => '#000000',
    //         'sch-head-align' => 'flex-start',
    //         'sch-close-align' => 'right',
    //         'sch-close-icon' => 'xoo-wsc-icon-cross',
    //         'sch-close-fsize' => 25,
    //         'sch-head-fsize' => 20,
    //         'sch-sbcolor' => '#1e73be',
    //         'sch-bgcolor' => '#ffffff',
    //         'sch-txtcolor' => '#000000', //side cart header - color
    //         'scb-del-icon' => 'xoo-wsc-icon-trash',
    //         'scb-fsize' => 16,
    //         'scb-bgcolor' => '#ffffff', //side cart body - bgcolor
    //         'scb-txtcolor' => '#000000',
    //         'scb-empty-img' => '',
    //         'scbp-imgw' => 40,
    //         'scbp-padding' => '20px 15px',
    //         'scbp-display' => 'flex-start',
    //         'scbp-qpdisplay' => 'separate',
    //         'scbq-style' => 'square',
    //         'scbq-width' => 75,
    //         'scbq-height' => 28,
    //         'scbq-bsize' => 1,
    //         'scbq-input-bcolor' => '#000000',
    //         'scbq-box-bcolor' => '#000000',
    //         'scbq-input-bgcolor' => '#ffffff',
    //         'scbq-input-txtcolor' => '#000000',
    //         'scbq-box-bgcolor' => '#ffffff',
    //         'scbq-box-txtcolor' => '#000000',
    //         'scf-padding' => '10px 20px',
    //         'scf-fsize' => 18,
    //         'scf-bgcolor' => '#ffffff', // side cart footer bg color
    //         'scf-txtcolor' => '#000000',
    //         'scf-coup-icon' => 'xoo-wsc-icon-coupon-8',
    //         'scf-button-pos' => array
    //         (
    //             '0' => 'continue',
    //             '1' => 'cart',
    //             '2' => 'checkout'
    //         ),
    //         'scf-btns-row' => 'one',
    //         'scf-btns-theme' => 'theme',
    //         'scf-btn-bgcolor' => '#ffffff',
    //         'scf-btn-txtcolor' => '#000000',
    //         'scf-btn-border' => '2px solid #000000',
    //         'scsp-style' => 'wide',
    //         'scsp-location' => 'after',
    //         'scsp-imgw' => 80,
    //         'scsp-fsize' => 14,
    //         'scsp-bgcolor' => '#eee'
    //     );
    //     update_option('xoo-wsc-sy-options', $array);

    //     // general
    //     $array2 = array(
    //         'm-auto-open' => 'yes',
    //         'm-ajax-atc' => 'yes',
    //         'm-flycart' => 'yes',
    //         'm-cart-order' => 'asc',
    //         'm-bk-count' => 'quantity',
    //         'm-cp-list' => 'all',
    //         'm-shop-url' => '',
    //         'm-hide-cart' => '',
    //         'sch-show' => array
    //             (
    //                 '0' => 'notifications',
    //                 '1' => 'shipping_bar',
    //                 '2' => 'basket',
    //                 '3' => 'close'
    //             ),
    //         'sch-notify-time' => 5000,
    //         'scb-show' => array
    //             (
    //                 '0' => 'total_sales',
    //                 '1' => 'product_image',
    //                 '2' => 'product_name',
    //                 '3' => 'product_price',
    //                 '4' => 'product_total',
    //                 '5' => 'product_meta',
    //                 '6' => 'product_link',
    //                 '7' => 'product_del'
    //             ),
    //         'scb-update-qty' => 'yes',
    //         'scb-update-delay' => 500,
    //         'scb-pname-var' => 'yes',
    //         'scf-show' => array
    //             (
    //                 '0' => 'subtotal',
    //                 '1' => 'discount',
    //                 '2' => 'tax',
    //                 '3' => 'shipping',
    //                 '4' => 'shipping_calc',
    //                 '5' => 'fee',
    //                 '6' => 'total',
    //                 '7' => 'coupon'
    //             ),
    //         'scf-pec-enable' => 'no',
    //         'scsp-enable' => 'yes',
    //         'scsp-mob-enable' => 'yes',
    //         'scsp-show' => array
    //             (
    //                 '0' => 'image',
    //                 '1' => 'title',
    //                 '2' => 'price',
    //                 '3' => 'addtocart'
    //             ),
    //         'scsp-type' => 'related',
    //         'scsp-ids' => '',
    //         'scsp-count' => 5,
    //         'scsp-random' => 'yes',
    //         'sct-cart-heading' => 'Your Cart',
    //         'sct-ft-contbtn' => '',
    //         'sct-ft-cartbtn' => 'View Cart',
    //         'sct-ft-chkbtn' => 'Checkout',
    //         'sct-empty' => 'Your cart is empty',
    //         'sct-shop-btn' => 'Return to Shop',
    //         'sct-sb-remaining' => 'You\'re %s away from free shipping.',
    //         'sct-sb-free' => 'Congrats! You get free shipping.'
    //     );
    //     update_option('xoo-wsc-sy-options', $array2);

    //     // advanced is just this, and we dont need to save it
    //     /*
    //         (
    //             [m-refresh-cart] => no
    //             [m-custom-css] => 
    //         )
    //     */

    //     wp_send_json(array(
	// 		'error' 	=> 0,
	// 		'notice' 	=> 'Settings Saved',
	// 	));
    // }

}

new Lay_SideCart();