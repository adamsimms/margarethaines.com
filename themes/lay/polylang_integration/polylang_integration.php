<?php

class LayPolylangIntegration {
	public static function init(){
		add_action( 'rest_api_init', 'LayPolylangIntegration::add_polylang_langswitcher_urls_rest_route' );
	}

	public static function add_polylang_langswitcher_urls_rest_route(){
		register_rest_route( 'laytheme/v1', '/get_polylang_langswitcher_urls', array(
			'methods' => 'GET',
			'callback' => 'LayPolylangIntegration::get_langswitcher_urls',
			'permission_callback' => '__return_true'
		) );
	}

	public static function get_langswitcher_urls( WP_REST_Request $request ){
        // error_log(print_r($request, true));
        if( class_exists( 'PLL_Switcher' ) ){
            $currentId = $request->get_param( 'id' );
			$currentType = $request->get_param( 'type' );
            
            $result = array();

            $available_languages = pll_languages_list(array('fields' => 'slug'));
            foreach ($available_languages as $slug) {
				if( $currentType == 'category' ) {
					$termid = pll_get_term($currentId, $slug);
					$permalink = get_term_link($termid);
					array_push( $result, array($permalink, $slug) );
				} else {
					$postid = pll_get_post($currentId, $slug);
					$permalink = get_permalink($postid);
					array_push( $result, array($permalink, $slug) );
				}
            }
            // error_log(print_r($result, true));
            return json_encode($result);
        }
	}

}

LayPolylangIntegration::init();