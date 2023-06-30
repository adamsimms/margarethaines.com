<?php
class LayShortcodes{

	/*whenever a post/page/category is saved, this will loop through the content to find any shortcodes,
	then it will save the occurences of shortcodes in this format:

	array(
		"cont" => $el["cont"],
		"shortcodeid" => $el["shortcodeid"],
		"info" => array(
			"type" => "post",
			"layouttype" => "desktop",
			"id" => $post_id
		)
	);

	["info"]["type"] will always be either post or category. so projects and pages are of type post
	*/

	public static $shortcodes_array = array();

	public function __construct(){
		add_action( 'init', array($this, 'get_cached_shortcode_occurences') );
		add_filter( 'save_post', array($this, 'cache_shortcode_occurences'), 10, 0 );
		add_filter( 'wp_trash_post', array($this, 'cache_shortcode_occurences'), 10, 0 );
		add_filter( 'edited_category', array($this, 'cache_shortcode_occurences'), 10, 0 );
		add_filter( 'delete_category', array($this, 'cache_shortcode_occurences'), 10, 0 );
	}

	public static function get_cached_shortcode_occurences(){
		$jsonstring = get_option('lay_shortcode_occurences', false);
		if($jsonstring != false && $jsonstring != ""){
			LayShortcodes::$shortcodes_array = json_decode($jsonstring, true);
		}
	}

	public static function cache_shortcode_occurences(){
		LayShortcodes::$shortcodes_array = array();

		// all projects, pages
		$query = new WP_Query(
		    array(
		        'post_type' => array('post', 'page', 'lay_news'),
		        'post_status' => 'publish',
		        'posts_per_page' => -1,
		        'fields' => 'ids',
		    )
		);

		if ( $query->have_posts() ) {
            foreach ($query->posts as $key => $post_id){

				$desktopJson = get_post_meta( $post_id, '_gridder_json', true );
				if($desktopJson != ""){
					$desktopObj = json_decode($desktopJson, true);
					$array = array(
						"obj" => $desktopObj,
						"info" => array(
							"type" => "post",
							"layouttype" => "desktop",
							"id" => $post_id
						)
					);
					LayShortcodes::maybeAddToShortcodesArray($array);
				}

				$phoneJson = get_post_meta( $post_id, '_phone_gridder_json', true );
				if($phoneJson != "" && MiscOptions::$phoneLayoutActive){
					$phoneObj = json_decode($phoneJson, true);
					$array = array(
						"obj" => $phoneObj,
						"info" => array(
							"type" => "post",
							"layouttype" => "phone",
							"id" => $post_id
						)
					);
					LayShortcodes::maybeAddToShortcodesArray($array);
				}
			}
		}

		// all categories
		$terms = get_terms(array(
			'taxonomy' => 'category',
			'hide_empty' => false,
			'fields' => 'ids'
		));

		foreach ($terms as $term_id) {

			$desktopJson = get_option($term_id."_category_gridder_json", false);
			if($desktopJson != "" && $desktopJson != false){
				$desktopObj = json_decode($desktopJson, true);
				$array = array(
					"obj" => $desktopObj,
					"info" => array(
						"type" => "category",
						"layouttype" => "desktop",
						"id" => $term_id
					)
				);
				LayShortcodes::maybeAddToShortcodesArray($array);
			}

			$phoneJson = get_option($term_id."_phone_category_gridder_json", false);
			if($phoneJson != "" && $phoneJson != false && MiscOptions::$phoneLayoutActive){
				$phoneObj = json_decode($phoneJson, true);
				$array = array(
					"obj" => $phoneObj,
					"info" => array(
						"type" => "category",
						"layouttype" => "phone",
						"id" => $term_id
					)
				);
				LayShortcodes::maybeAddToShortcodesArray($array);
			}

		}

		$json_string = json_encode(LayShortcodes::$shortcodes_array);
		update_option('lay_shortcode_occurences', $json_string);
	}

	public static function maybeAddToShortcodesArray($array){
		$obj = $array["obj"];

		$shortcode_els = array();

		if( is_array($obj) ){

			for($i=0; $i<count($obj['cont']); $i++){
				$el = $obj['cont'][$i];
				if($el["type"] == "shortcode"){
					$shortcode_els []= $el;
				}
				if($el["type"] == "stack"){
					$stack_cont = $el['cont'];

					foreach($stack_cont as $stack_inner_el){
						if($stack_inner_el["type"] == "shortcode"){
							$shortcode_els []= $stack_inner_el;
						}
					}
				}
			}

			foreach($shortcode_els as $shortcode_el){
				// shortcode string, unique id of shortcode, info array
				$shortcode_array = array(
					"cont" => $shortcode_el["cont"],
					"shortcodeid" => $shortcode_el["shortcodeid"],
					"info" => $array["info"]
				);
				LayShortcodes::$shortcodes_array []= $shortcode_array;
			}


		}

	}

}
new LayShortcodes();
