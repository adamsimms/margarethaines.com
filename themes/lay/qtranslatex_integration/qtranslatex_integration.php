<?php

// todo: i think polylang is the better alternative because it is in active development, you can have different images for each language,
// it does not require extra coding from my part, maybe the language switcher menu point can like actually be at the right position (order of menu points)
// so one day, i should just not mention qtranslate on laytheme.com anymore and just suggest polylang and i'll just keep this here for backwards compatibility

class LayQtranslateIntegration {
	public static function init(){
		add_filter( 'wp_get_nav_menu_items', 'LayQtranslateIntegration::qtranxf_wp_get_nav_menu_items', 30, 3 );
		add_action( 'rest_api_init', 'LayQtranslateIntegration::add_qtranslate_langswitcher_urls_rest_route' );

		// prevents invalid json
		// if some text element doesn't have a translated text, qtranslate would display a language prefix before json.
		// json would be invalid
		if (get_option( 'qtranslate_show_displayed_language_prefix', '1' ) == '1') {
			update_option( 'qtranslate_show_displayed_language_prefix', '0' );
		}
	}

	public static function add_qtranslate_langswitcher_urls_rest_route(){
		register_rest_route( 'laytheme/v1', '/get_qtranslate_langswitcher_urls', array(
			'methods' => 'GET',
			'callback' => 'LayQtranslateIntegration::get_langswitcher_urls',
			'permission_callback' => '__return_true'
		) );
	}

	public static function get_langswitcher_urls( WP_REST_Request $request ){
		global $q_config;

		$currentUrl = $request->get_param( 'url' );

		$result = array();

		foreach($q_config['enabled_languages'] as $lang) {
			if(!empty($q_config['locale_html'][$lang])){
				$hreflang = $q_config['locale_html'][$lang];
			}else{
				$hreflang = $lang;
			}
			// qtranxf_convertURLs($url, $lang='', $forceadmin = false, $showDefaultLanguage = false) {
			$result []= array( $hreflang, qtranxf_convertURL($currentUrl,$lang,false,true) );
		}

		return json_encode($result);
	}

	// modify qtranslate menu points
	public static function qtranxf_wp_get_nav_menu_items( $items, $menu, $args ){
		// is this a qtranslate menupoint?
		// make sure qtranslate menu is not parent-menu and submenu items:
		$parent_menupoint_index = false;
		global $q_config;

		foreach ($items as $item) {

			foreach( $item->classes as $class ){
				if($class == 'qtranxs-lang-menu-item'){
					// set title
					$item->title = $item->attr_title;
					$item->post_title = $item->attr_title;

					// add "current menu item" class to mark currently chosen language
					if( $item->item_lang == $q_config['language'] ){
						$item->classes []= 'current-menu-item';
					}

				}
				if($class == 'qtranxs-lang-menu'){
					// remove parent
					$parent_menupoint_index = array_search($item, $items);
				}
			}
		}

		if( is_int($parent_menupoint_index) ){
			unset($items[$parent_menupoint_index]);
			// set right indices
			$items = array_values($items);
		}
		return $items;
	}

}

LayQtranslateIntegration::init();