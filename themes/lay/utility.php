<?php
// todo: check html classes, do i need to set html class like isTouchDevice using this php here, maybe instead of JS
require_once get_template_directory().'/assets/mobile_detect/Mobile_Detect.php';

class LTUtility{

	public static $isTouchDevice;
	public static $supportsPlaysInlineOnTouchDevice;
	public static $isPhone;

	public function __construct(){
		$detect = new Mobile_Detect;
		LTUtility::$isTouchDevice = $detect->isMobile();
		LTUtility::$isPhone = false;
		if( $detect->isMobile() && !$detect->isTablet() ){
			LTUtility::$isPhone = true;
		}

		// todo: see if this works:
		// html5 video playsinline is supported from iOS 10 WebKit and Chrome > 53
		LTUtility::$supportsPlaysInlineOnTouchDevice = false;
		if( LTUtility::$isTouchDevice ) {
			if( $detect->isiOS() && $detect->is('Safari') ) {
				if( $detect->version('Safari') >= 10 ){
					LTUtility::$supportsPlaysInlineOnTouchDevice = true;
				}
			}
			else if( $detect->isAndroidOS() && $detect->is('Chrome') ) {
				if( $detect->version('Chrome') >= 53 ){
					LTUtility::$supportsPlaysInlineOnTouchDevice = true;
				}
			}
			// be optimistic for other combinations
			LTUtility::$supportsPlaysInlineOnTouchDevice = true;
		}
	}

	public static function is_admin_page_with_a_gridder($screen){
		if ( $screen->id == 'edit-category' || $screen->id == 'post' || $screen->id == 'page' || Gridder::$active_for_news == true && $screen->id == 'lay_news'  ) {
			return true;
		}
		return false;
	}

	public static function is_sidecart_active(){
		return is_plugin_active('side-cart-woocommerce/xoo-wsc-main.php') || (function_exists('xoo_wsc_init') && class_exists('WooCommerce'));
	}

	public static function is_frontpage(){
		if( is_home() || is_front_page() ){
			return true;
		  }
		  return false;
	}

	public static function getRelativeURL($url) {
		$siteUrl = get_site_url();

		if ($url && substr($url, 0, strlen($siteUrl)) === $siteUrl) {
			return substr($url, strlen($siteUrl));
		}
		return $url;
	}

	public static function getFullURL($url){
        if( substr( $url, 0, 1 ) == '#' ) {
            return $url;
        }
		if( substr( $url, 0, 4 ) == 'http' ) {
			return LTUtility::filterURL($url);
		} else {
			return get_site_url().$url;
		}
	}

	public static function has_www(){
		if(strpos(get_site_url(), "://www.") !== false){
			return 1;
		}
		return 0;
	}

	// make sure url is https or http in case user switched from http to https or the other way around
	public static function filterURL($url){
		$is_ssl = is_ssl();
		$has_www = self::has_www();

		if($url != ""){
			$substr = substr($url, 0,5);
			if($substr == "http:" && $is_ssl == true){
				$part = substr($url, 5);
				$url = "https:".$part;
			}
			else if($substr == "https" && ($is_ssl == false || $is_ssl == "")){
				$part = substr($url, 5);
				$url = "http".$part;
			}
				
			// add www in case we're on a www domain, but the url does not contain www
			if($has_www == 1){
				if($is_ssl == true){
					// https://www.
					if(substr($url,0,12) != 'https://www.'){
						// $part is everything after https://
						$part = substr($url,8);
						$url = "https://www.".$part;
					}
				}else{
					// http://www.
					if(substr($url,0,11) != 'http://www.'){
						// $part is everything after http://
						$part = substr($url,7);
						$url = "http://www.".$part;
					}			
				}
			}else{
				// no www, see if url needs removal of www
				if($is_ssl == true){
					if(substr($url,0,12) == 'https://www.'){
						// $part is everything after https://www.
						$part = substr($url,12);
						$url = "https://".$part;
					}
				}else{
					// http://www.
					if(substr($url,0,11) == 'http://www.'){
						// $part is everything after http://www.
						$part = substr($url,11);
						$url = "http://".$part;
					}
				}
			}
        }
		return $url;
	}

}
new LTUtility();
