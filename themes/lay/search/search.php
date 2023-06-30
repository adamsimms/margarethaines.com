<?php
require get_template_directory().'/search/results_thumbnailgrid.php';
// searches for project titles and shows project titles and thumbnails

class LaySearch{

	public function __construct(){
		add_action( 'save_post', array($this, 'search_save_post'), 10, 2 );
		// update when tag was edited 
		add_action( 'edited_post_tag', array($this, 'search_save_post'), 10, 2 );
		add_action( 'delete_post_tag', array($this, 'search_save_post'), 10, 2 );

		add_action( 'delete_post', array($this, 'search_delete_post'), 10, 2 );
		add_action( 'trash_post', array($this, 'search_delete_post'), 10, 2 );
		add_filter( 'rest_cache_skip', array($this, 'skip_search_endpoint'), 10, 4 );
        add_action( 'rest_api_init', array($this, 'add_search_route') );
        
        add_action( 'wp_ajax_get_search_result', array( $this, 'get_search_result_thumbnailgrid' ) );
        add_action( 'wp_ajax_nopriv_get_search_result', array( $this, 'get_search_result_thumbnailgrid' ) );
    }
    
    public static function get_search_result_thumbnailgrid(){
        // an array of post ids
        $found_posts = $_POST['found_posts'];
        $found_posts = json_decode($found_posts, true);

        $config = array(
            'desktop' => array('colCount' => 4, 'colGutter' => 2, 'rowGutter' => 1),
            'tablet' => array('colCount' => 3, 'colGutter' => 3, 'rowGutter' => 3),
            'phone' => array('colCount' => 1, 'colGutter' => 5, 'rowGutter' => 5),
            'layoutType' => "masonry",
            'postids' => $found_posts
        );

        // of course i dont need to wrap config in an $el array, but:
        // i mimick gridder json structure, this way i won't have to rewrite results_thumbnailgrid.php to be too different from thumbnailgrid.php
        // this is just more of an ease to use thing
        $el = array('config' => $config);
        $thumbnailgrid = new LaySearch_Thumbnailgrid($el);
        $markup = $thumbnailgrid->getMarkup();
        echo $markup;
        wp_die();
    }
	
	public static function add_search_route(){
		register_rest_route( 'laytheme', '/search/', array(
			'methods' => 'GET',
            'callback' => 'LaySearch::getSearchPostArray',
            'permission_callback' => '__return_true'
		) );
	}

	public static function skip_search_endpoint( $WP_DEBUG, $request_uri, $server, $request ){
		if ( strpos($request_uri, '/laytheme/search/') !== false ){
			return true;
		}
		return false;
	}

	public static function search_save_post( ) {
		$searchPostArray = array();
		$posts = get_posts(
            array(
                'numberposts' => -1,
                'post_status' => 'publish'
            )
        );

		if ( $posts ) {
			foreach ( $posts as $post ) {
                $cats = wp_get_post_categories($post->ID, array( 'fields' => 'names' ));
                $tags = get_the_tags($post->ID);
                $tagArray = array();
                if ($tags) {
					usort($tags, function($a, $b) {
						return $a->term_order - $b->term_order;
					});
					foreach($tags as $tag) {
						$tagArray []= $tag->name;
					}
                }
				// error_log(print_r($tags, true));
				array_push($searchPostArray, array(
                    'cats' => $cats,
                    'tags' => $tagArray,
                    'descr' => get_post_meta( $post->ID, 'lay_project_description', true ),
                    'postid' => $post->ID,
                    'title' => get_the_title($post->ID),
					'slug' => $post->post_name,
				));
			}
		}
		update_option( 'lay-search-post-array', $searchPostArray);
	}

	public static function search_delete_post( $post_id ) {
		// TODO: von der Liste löschen und option abspeichern
		// TODO: überprüfen

		$searchPostArray = get_option( 'lay-search-post-array' );
		$needUpdate = false;
		if ( $searchPostArray == false ) {
			LaySearch::search_save_post($post_id);
		}
		
		if( is_array($searchPostArray) ) {
			for ($i = 0; $i < count($searchPostArray); $i++) {
				if ($searchPostArray[$i]['postid'] == $post_id) {
					$needUpdate = true;
					array_splice($searchPostArray, $i, 1);
					break;
				}
			}
		} 

		if ($needUpdate) {
			update_option( 'lay-search-post-array', $searchPostArray);
		}
	}

	public static function getSearchPostArray() {
		$searchPostArray = get_option( 'lay-search-post-array' );
		if ( $searchPostArray == false ) {
			LaySearch::search_save_post(-1);
		}
		return $searchPostArray;
	}
}
new LaySearch();
