<?php
// updates imagelinks whenever a project, page or category is updated

class LayUpdateImageLinks{

	public function __construct(){
		// update post and page imagelinks
		add_filter( 'post_updated', 'LayUpdateImageLinks::update_post_imagelinks_everywhere', 9, 3 );
		// update category imagelinks
		add_action( 'edited_category', 'LayUpdateImageLinks::update_category_imagelinks_everywhere', 10, 1 );

		// remove post and page imagelinks
		add_filter( 'trash_post', 'LayUpdateImageLinks::remove_post_imagelinks_everywhere', 10, 1 );
		// remove category imagelinks
		add_action( 'delete_category', 'LayUpdateImageLinks::remove_category_imagelinks_everywhere', 10, 1 );
	}

	public static function update_imagelink_in_post_json($metaname, $linktype_to_update, $post_id, $permalink, $title, $id){
		$jsonString = get_post_meta( $id, $metaname, true );
		if($jsonString != ""){
			$needsUpdate = false;
			$jsonObject = json_decode($jsonString, true);

			if ($jsonObject) {
				LayUpdateRowBgLinks::update_row_bg_link($jsonObject['rowAttrs'], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);

				if(is_array($jsonObject['cont'])){
					for($i=0; $i<count($jsonObject['cont']); $i++){
						LayUpdateImageLinks::update_obj($jsonObject['cont'][$i], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);
						// update linked images in stack element
						if($jsonObject['cont'][$i]['type'] == 'stack'){
							$stack_cont = &$jsonObject['cont'][$i]['cont'];
							for($ix_s=0; $ix_s<count($stack_cont); $ix_s++){
								LayUpdateImageLinks::update_obj($stack_cont[$ix_s], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);
							}
						}
						// update linked images in carousel element
						if($jsonObject['cont'][$i]['type'] == 'carousel'){
							$carousel_cont = &$jsonObject['cont'][$i]['carousel'];
							for($ix_c=0; $ix_c<count($carousel_cont); $ix_c++){
								LayUpdateImageLinks::update_obj($carousel_cont[$ix_c], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);
							}
						}
					}
				}
			}

			if($needsUpdate){
				// save json back to db
				// http://stackoverflow.com/a/22208945/3159159
				$jsonString = json_encode($jsonObject);
				if($jsonString != false && $jsonString != ""){
					$jsonString = wp_slash( $jsonString );
					update_post_meta( $id, $metaname, $jsonString );
				}
			}
		}
	}

	public static function remove_imagelink_in_post_json($metaname, $linktype_to_update, $post_id, $id){
		$jsonString = get_post_meta( $id, $metaname, true );
		if($jsonString != ""){
			$needsUpdate = false;
			$jsonObject = json_decode($jsonString, true);

			if ($jsonObject) {
				LayUpdateRowBgLinks::remove_row_bg_link($jsonObject['rowAttrs'], $needsUpdate, $linktype_to_update, $post_id);

				if(is_array($jsonObject['cont'])){
					for($i=0; $i<count($jsonObject['cont']); $i++){
						LayUpdateImageLinks::remove_from_obj($jsonObject['cont'][$i], $needsUpdate, $linktype_to_update, $post_id);
						// update linked images in stack element
						if($jsonObject['cont'][$i]['type'] == 'stack'){
							$stack_cont = &$jsonObject['cont'][$i]['cont'];
							for($ix_s=0; $ix_s<count($stack_cont); $ix_s++){
								LayUpdateImageLinks::remove_from_obj($stack_cont[$ix_s], $needsUpdate, $linktype_to_update, $post_id);
							}
						}
						// update linked images in carousel element
						if($jsonObject['cont'][$i]['type'] == 'carousel'){
							$carousel_cont = &$jsonObject['cont'][$i]['carousel'];
							for($ix_c=0; $ix_c<count($carousel_cont); $ix_c++){
								LayUpdateImageLinks::remove_from_obj($carousel_cont[$ix_c], $needsUpdate, $linktype_to_update, $post_id);
							}
						}
					}
				}
			}

			if($needsUpdate){
				// save json back to db
				// http://stackoverflow.com/a/22208945/3159159
				$jsonString = json_encode($jsonObject);
				if($jsonString != false && $jsonString != ""){
					$jsonString = wp_slash( $jsonString );
					update_post_meta( $id, $metaname, $jsonString );
				}
			}
		}
	}

	public static function update_imagelink_in_category_json($option_name, $linktype_to_update, $post_id, $permalink, $title){
		$jsonString = get_option( $option_name, false );
		if($jsonString){
			$jsonObject = json_decode($jsonString, true);
			$needsUpdate = false;

			if ($jsonObject) {
				LayUpdateRowBgLinks::update_row_bg_link($jsonObject['rowAttrs'], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);

				if(is_array($jsonObject['cont'])){
					for($i=0; $i<count($jsonObject['cont']); $i++){
						LayUpdateImageLinks::update_obj($jsonObject['cont'][$i], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);
						// update linked images in stack element
						if($jsonObject['cont'][$i]['type'] == 'stack'){
							$stack_cont = &$jsonObject['cont'][$i]['cont'];
							for($ix_s=0; $ix_s<count($stack_cont); $ix_s++){
								LayUpdateImageLinks::update_obj($stack_cont[$ix_s], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);
							}
						}
						// update linked images in carousel element
						if($jsonObject['cont'][$i]['type'] == 'carousel'){
							$carousel_cont = &$jsonObject['cont'][$i]['carousel'];
							for($ix_c=0; $ix_c<count($carousel_cont); $ix_c++){
								LayUpdateImageLinks::update_obj($carousel_cont[$ix_c], $needsUpdate, $linktype_to_update, $post_id, $permalink, $title);
							}
						}
					}
				}
			}

			if($needsUpdate){
				$jsonString = json_encode($jsonObject);
				if($jsonString != false && $jsonString != ""){
					update_option( $option_name, $jsonString );
				}
			}
		}		
	}

	public static function remove_imagelink_in_category_json($option_name, $linktype_to_update, $post_id){
		$jsonString = get_option( $option_name, false );
		if($jsonString){
			$jsonObject = json_decode($jsonString, true);
			$needsUpdate = false;

			if ($jsonObject) {
				LayUpdateRowBgLinks::remove_row_bg_link($jsonObject['rowAttrs'], $needsUpdate, $linktype_to_update, $post_id);

				if(is_array($jsonObject['cont'])){
					for($i=0; $i<count($jsonObject['cont']); $i++){
						LayUpdateImageLinks::remove_from_obj($jsonObject['cont'][$i], $needsUpdate, $linktype_to_update, $post_id);
						// update linked images in stack element
						if($jsonObject['cont'][$i]['type'] == 'stack'){
							$stack_cont = &$jsonObject['cont'][$i]['cont'];
							for($ix_s=0; $ix_s<count($stack_cont); $ix_s++){
								LayUpdateImageLinks::remove_from_obj($stack_cont[$ix_s], $needsUpdate, $linktype_to_update, $post_id);
							}
						}
						// update linked images in carousel element
						if($jsonObject['cont'][$i]['type'] == 'carousel'){
							$carousel_cont = &$jsonObject['cont'][$i]['carousel'];
							for($ix_c=0; $ix_c<count($carousel_cont); $ix_c++){
								LayUpdateImageLinks::remove_from_obj($carousel_cont[$ix_c], $needsUpdate, $linktype_to_update, $post_id);
							}
						}
					}
				}
			}

			if($needsUpdate){
				$jsonString = json_encode($jsonObject);
				if($jsonString != false && $jsonString != ""){
					update_option( $option_name, $jsonString );
				}
			}
		}		
	}

	private static function update_obj(&$obj, &$needsUpdate, $linktype_to_update, $post_id, $permalink, $title){
		// element with type of thumbnail has 'postid' attribute .. but it's actual element type is still 'img'
		if( !array_key_exists( 'postid', $obj ) ){
			// make sure this is an element with type img and make sure it has imagelink attr
			if( $obj['type'] == 'img' && array_key_exists( 'imagelink', $obj ) ){
				// make sure imagelink is an array, 
				if( is_array($obj['imagelink']) ){
					// make sure the imagelink is of type $linktype_to_update
					if( in_array($obj['imagelink']['type'], $linktype_to_update) ){
						// make sure that the post id linked to is id of current post being saved
						if( $obj['imagelink']['id'] == $post_id ){
							$needsUpdate = true;
							$obj['imagelink']['url'] = $permalink;
							$obj['imagelink']['title'] = $title;

							// if image links to a project, update the catid too
							if($obj['imagelink']['type'] == "project"){
								$categories = get_the_category($post_id);
								$catid = array();
								foreach($categories as $cat){
									$catid []= $cat->term_id;
								}
								$obj['imagelink']['catid'] = $catid;
							}
						}
					}
				}
			}
		}
	}

	private static function remove_from_obj(&$obj, &$needsUpdate, $linktype_to_update, $post_id){
		// element with type of thumbnail has 'postid' attribute .. but it's actual element type is still 'img'
		if( !array_key_exists( 'postid', $obj ) ){
			// make sure this is an element with type img and make sure it has imagelink attr
			if( $obj['type'] == 'img' && array_key_exists( 'imagelink', $obj ) ){
				// make sure imagelink is an array, 
				if( is_array($obj['imagelink']) ){
					// make sure the imagelink is of type $linktype_to_update
					if( in_array($obj['imagelink']['type'], $linktype_to_update) ){
						// make sure that the post id linked to is id of current post being saved
						if( $obj['imagelink']['id'] == $post_id ){
							unset($obj['imagelink']);
							$needsUpdate = true;
						}
					}
				}
			}
		}
	}

	public static function update_post_imagelinks_everywhere($post_id, $post_after, $post_before){
		$linktype_to_update = array("page", "project");

		$poststatus = get_post_status($post_id);
		if( $poststatus == 'publish' ){
		    // check for posttype. cause post_updated also gets triggered when nav_menu_item updates / a navigation menu is saved
		    $posttype = get_post_type( $post_id );
		    if( $posttype == 'page' || $posttype == "post" ){

		    	// attributes to update:
		    	$permalink = LTUtility::getRelativeURL(get_permalink($post_id));
					$title = stripslashes($post_after->post_title);

		    	// update category json

		    	$allCategoryIds = get_terms(array('taxonomy' => 'category', 'hide_empty' => false, 'fields' => 'ids'));

		    	foreach($allCategoryIds as $categoryId){
		    	    LayUpdateImageLinks::update_imagelink_in_category_json( $categoryId."_category_gridder_json", $linktype_to_update, $post_id, $permalink, $title  );
		    	    LayUpdateImageLinks::update_imagelink_in_category_json( $categoryId."_phone_category_gridder_json", $linktype_to_update, $post_id, $permalink, $title  );
		    	}

		    	// update post's and page's json
		    	$query = new WP_Query( 
		    	    array(
		    	        'post_type' => array('post', 'page', 'lay_news'),
		    	        'post_status' => 'publish',
		    	        'posts_per_page' => -1,
		    	        'fields' => 'ids',
		    	    )
		    	);
		    	
		    	if ( $query->have_posts() ) {
		    	    foreach ($query->posts as $key => $id){
		    	        LayUpdateImageLinks::update_imagelink_in_post_json( '_gridder_json', $linktype_to_update, $post_id, $permalink, $title, $id );
		    	        LayUpdateImageLinks::update_imagelink_in_post_json( '_phone_gridder_json', $linktype_to_update, $post_id, $permalink, $title, $id );
		    	    }
		    	}

		    }
		}
	}

	public static function remove_post_imagelinks_everywhere($post_id){
		$linktype_to_update = array("page", "project");

		$poststatus = get_post_status($post_id);
		if( $poststatus != 'publish' ){
		    // check for posttype. cause post_updated also gets triggered when nav_menu_item updates / a navigation menu is saved
		    $posttype = get_post_type( $post_id );
		    if( $posttype == 'page' || $posttype == "post" ){
		    	// update category json

		    	$allCategoryIds = get_terms(array('taxonomy' => 'category', 'hide_empty' => false, 'fields' => 'ids'));

		    	foreach($allCategoryIds as $categoryId){
		    	    LayUpdateImageLinks::remove_imagelink_in_category_json( $categoryId."_category_gridder_json", $linktype_to_update, $post_id );
		    	    LayUpdateImageLinks::remove_imagelink_in_category_json( $categoryId."_phone_category_gridder_json", $linktype_to_update, $post_id );
		    	}

		    	// update post's and page's json
		    	$query = new WP_Query( 
		    	    array(
		    	        'post_type' => array('post', 'page', 'lay_news'),
		    	        'post_status' => 'publish',
		    	        'posts_per_page' => -1,
		    	        'fields' => 'ids',
		    	    )
		    	);
		    	
		    	if ( $query->have_posts() ) {
		    	    foreach ($query->posts as $key => $id){
		    	        LayUpdateImageLinks::remove_imagelink_in_post_json( '_gridder_json', $linktype_to_update, $post_id, $id );
		    	        LayUpdateImageLinks::remove_imagelink_in_post_json( '_phone_gridder_json', $linktype_to_update, $post_id, $id );
		    	    }
		    	}

		    }
		}
	}

	public static function update_category_imagelinks_everywhere($term_id){
		$linktype_to_update = array("category");

		$term = get_term($term_id, "category");
		// attributes to update:
		$permalink = LTUtility::getRelativeURL(get_term_link($term_id, "category"));
		$title = $term->name;

		$allCategoryIds = get_terms(array('taxonomy' => 'category', 'hide_empty' => false, 'fields' => 'ids'));

		foreach($allCategoryIds as $categoryId){
		    LayUpdateImageLinks::update_imagelink_in_category_json( $categoryId."_category_gridder_json", $linktype_to_update, $term_id, $permalink, $title  );
		    LayUpdateImageLinks::update_imagelink_in_category_json( $categoryId."_phone_category_gridder_json", $linktype_to_update, $term_id, $permalink, $title  );
		}

		// update post's and page's json
		$query = new WP_Query( 
		    array(
		        'post_type' => array('post', 'page', 'lay_news'),
		        'post_status' => 'publish',
		        'posts_per_page' => -1,
		        'fields' => 'ids',
		    ) 
		);
		
		if ( $query->have_posts() ) {
		    foreach ($query->posts as $key => $id){
		        LayUpdateImageLinks::update_imagelink_in_post_json( '_gridder_json', $linktype_to_update, $term_id, $permalink, $title, $id );
		        LayUpdateImageLinks::update_imagelink_in_post_json( '_phone_gridder_json', $linktype_to_update, $term_id, $permalink, $title, $id );
		    }
		}
	}

	public static function remove_category_imagelinks_everywhere($term_id){
		$linktype_to_update = array("category");

		$allCategoryIds = get_terms(array('taxonomy' => 'category', 'hide_empty' => false, 'fields' => 'ids'));

		foreach($allCategoryIds as $categoryId){
		    LayUpdateImageLinks::remove_imagelink_in_category_json( $categoryId."_category_gridder_json", $linktype_to_update, $term_id );
		    LayUpdateImageLinks::remove_imagelink_in_category_json( $categoryId."_phone_category_gridder_json", $linktype_to_update, $term_id );
		}

		// update post's and page's json
		$query = new WP_Query( 
		    array(
		        'post_type' => array('post', 'page', 'lay_news'),
		        'post_status' => 'publish',
		        'posts_per_page' => -1,
		        'fields' => 'ids',
		    ) 
		);
		
		if ( $query->have_posts() ) {
		    foreach ($query->posts as $key => $id){
		        LayUpdateImageLinks::remove_imagelink_in_post_json( '_gridder_json', $linktype_to_update, $term_id, $id );
		        LayUpdateImageLinks::remove_imagelink_in_post_json( '_phone_gridder_json', $linktype_to_update, $term_id, $id );
		    }
		}
	}

}

new LayUpdateImageLinks();