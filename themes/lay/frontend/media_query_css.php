<?php
class MediaQueryCSS{

	public static $desktop;
	public static $phone;
	public static $woocommerce_desktop;
	public static $woocommerce_phone;

	public function __construct(){
		MediaQueryCSS::$desktop = require get_template_directory().'/frontend/style_desktop.php';
		MediaQueryCSS::$phone = require get_template_directory().'/frontend/style_phone.php';
		if( class_exists( 'WooCommerce' ) ) {
			MediaQueryCSS::$woocommerce_desktop = require get_template_directory().'/woocommerce_integration/style_desktop.php';
			MediaQueryCSS::$woocommerce_phone = require get_template_directory().'/woocommerce_integration/style_phone.php';
		}
	}
}

new MediaQueryCSS();
