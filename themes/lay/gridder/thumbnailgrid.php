<?php
// todo: make project prevnext work with this project order

class Thumbnailgrid{

	public function __construct(){
		if ( is_admin() ) {
			add_action('wp_ajax_get_thumbnails_for_thumbnailgrid', array($this, 'get_thumbnails_for_thumbnailgrid_gridder'));
		}
		
		add_action('wp_ajax_get_post_order_list_for_thumbnailgrid', array($this, 'get_post_order_list_for_thumbnailgrid'));
		add_action('wp_ajax_reverse_post_order_thumbnailgrid', array($this, 'reverse_post_order_thumbnailgrid'));

		add_action('wp_ajax_thumbgrid_save_project_order', array($this, 'thumbgrid_save_project_order'));

		add_action('wp_ajax_get_category_filter_list_for_thumbnailgrid', array($this, 'get_category_filter_list_for_thumbnailgrid'));
		add_action('wp_ajax_get_tag_list_for_thumbnailgrid', array($this, 'get_tag_list_for_thumbnailgrid'));

		add_action( 'wp_trash_post', array($this, 'remove_post_from_project_order'), 10, 1 );
		add_action( 'post_updated', array($this, 'maybe_remove_post_from_project_orders_on_post_save'), 10, 3 );
		add_action( 'post_updated', array($this, 'delete_transients'), 10, 3 );
    }

    public static function delete_transients($post_ID, $post_after, $post_before){
        $cats = get_categories();
        foreach( $cats as $cat ) {
            delete_transient( 'thumbnailgrid_query_'.$cat->term_id );
        }
    }

	public static function maybe_remove_post_from_project_orders_on_post_save($post_ID, $post_after, $post_before){
		// if a post was saved and its categories changed, remove that post from custom project order metadatas

		// first get categories of post
		$cats = get_the_category($post_ID);
		$posts_cat_ids = array();
		foreach( $cats as $cat ) {
			$cat_id = $cat->cat_ID;
			$posts_cat_ids []= $cat_id;
		}

		// get all cat ids
		$all_categories = get_categories();
		$all_cat_ids = array();
		foreach( $all_categories as $cat ) {
			$all_cat_ids []= $cat->cat_ID;
		}

		// get all categories that are not categories of the post
		$diff = array_diff($all_cat_ids, $posts_cat_ids);

		foreach( $diff as $cat_id ) {
			$thumb_order_ids = get_term_meta($cat_id, 'project_order', true);
			if ( !is_array($thumb_order_ids) ) {
				$thumb_order_ids = json_decode($thumb_order_ids);
			}
			// can be false or array
			if ( is_array($thumb_order_ids) ) {
				// the thumb_order_ids are post ids, just remove the current post's id from project order
				$offset = array_search($post_ID, $thumb_order_ids);
				if (is_int($offset)) {
					array_splice($thumb_order_ids, $offset, 1);
					$ids_str = json_encode($thumb_order_ids);
					update_term_meta($cat_id, 'project_order', $ids_str);
				}
			}
		}
	}

	public static function remove_post_from_project_order($postid){
		// get all cat ids
		$all_categories = get_categories();
		$all_cat_ids = array();
		foreach( $all_categories as $cat ) {
			$all_cat_ids []= $cat->cat_ID;
		}

		foreach( $all_cat_ids as $cat_id ) {
			$thumb_order_ids = get_term_meta($cat_id, 'project_order', true);
			if ( !is_array($thumb_order_ids) ) {
				$thumb_order_ids = json_decode($thumb_order_ids);
			}
			if ( is_array($thumb_order_ids) ) {
				$offset = array_search($postid, $thumb_order_ids);
				if (is_int($offset)) {
					array_splice($thumb_order_ids, $offset, 1);
					$ids_str = json_encode($thumb_order_ids);
					update_term_meta($cat_id, 'project_order', $ids_str);
				}
			}
		}
	}

	public static function thumbgrid_save_project_order(){
		$obj = $_POST['project_order'];
		$ids = json_encode($obj['ids']);
		update_term_meta($obj["termid"], 'project_order', $ids);
		// update_term_meta($obj["termid"], 'project_order', '');
	}

	public static function get_project_ids_possibly_with_order($cat_id){
		// post ids of projects of category with cat_id
		$query_ids = array();

		$args = array(
			'posts_per_page' => -1,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'post',
			'cat' => $cat_id,
			'fields' => 'ids',
            'post_status' => 'publish'
		);

        $query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			foreach ($query->posts as $post_id){
				$query_ids []= $post_id;
			}
		}

		// if project order was saved before as meta (it is an array of project ids), see if the query above has new projects. if so, prepend them and return resulting array
		$thumb_order_ids = get_term_meta($cat_id, 'project_order', true);

        // error_log(print_r('$thumb_order_ids', true));
        // error_log(print_r($thumb_order_ids, true));

		if( !is_array($thumb_order_ids) ){
			$thumb_order_ids = json_decode($thumb_order_ids);
		}


		// $thumb_order_ids can be false or array
		if( is_array($thumb_order_ids) ){

            $valid_ids = $query_ids;
            // remove any post ids that may not be part of this category anymore!
            $invalid_ids = array_diff($thumb_order_ids, $valid_ids);
            $valid_sorted_ids = array_diff($thumb_order_ids, $invalid_ids);
            
            // now get all ids of valid posts that are not in 'project_order' ids, because they were newly added
            $thumb_order_ids = array_diff($valid_sorted_ids, $thumb_order_ids);
			$diff = array_diff($query_ids, $valid_sorted_ids);

			if(count($diff) > 0){
                // if there are any new ids, put them in front of the existing sorted ids, and save the new order in the database
				$result = array_merge($diff, $valid_sorted_ids);
				update_term_meta($cat_id, 'project_order', json_encode($result));
				return $result;
			}

			return $valid_sorted_ids;
		}

		// if theres no project order term meta, just return $query_ids
		// error_log(print_r('no project order term meta', true));
		return $query_ids;
	}

	public static function filter_out_password_protected($ids){
		$new_ids = array();
		for ($i=0; $i < count($ids); $i++) { 
			$id = $ids[$i];
			$post = get_post($id);
            if(empty($post->post_password)){
				$new_ids []= $id;
			}
        }
		return $new_ids;
	}

	public static function get_post_order_list_for_thumbnailgrid(){
		$cat_id = $_GET['catId'];
		$ids = Thumbnailgrid::get_project_ids_possibly_with_order($cat_id);

		$array = array();

		foreach ($ids as $post_id){
			if(get_post_status($post_id) != "publish"){
				continue;
			}
			$attid = get_post_thumbnail_id($post_id);
			$arr = wp_get_attachment_image_src($attid, '_265');
			$array []= array("post_id" => $post_id, "src" => $arr[0], "title" => get_the_title($post_id));
		}

		wp_send_json($array);
		die();
	}

	public static function  reverse_post_order_thumbnailgrid(){
		$cat_id = $_GET['catId'];
		$ids = Thumbnailgrid::get_project_ids_possibly_with_order($cat_id);

		$array = array();
		$ids = array_reverse($ids);
		$ids_str = json_encode($ids);
		update_term_meta($cat_id, 'project_order', $ids_str);

		foreach ($ids as $post_id){
			$attid = get_post_thumbnail_id($post_id);
			$arr = wp_get_attachment_image_src($attid, '_265');
			$img = "";
			if( $arr != "false" ) {
				$img = $arr[0];
			}
			$array []= array("post_id" => $post_id, "src" => $img, "title" => get_the_title($post_id));
		}

		wp_send_json($array);
		die();
	}

    public static function get_tag_list_for_thumbnailgrid(){
		$sortedTagsArray = $_POST['tags'];
		$tags = get_terms( array(
            'taxonomy' => 'post_tag',
            'hide_empty' => false,
            'orderby' => 'menu_order'
        ) );

		if( is_array($sortedTagsArray) ){
            // first see if we have any ids in $tags that are not in $sortedTagsArray
            // in that case user must have added new tags
            $sortedTagIds = array();
            $tagIds = array();
            foreach( $tags as $tag ) {
                $tagIds []= $tag->term_id;
            }
            foreach( $sortedTagsArray as $item ) {
                $sortedTagIds []= $item['id'];
            }
			// check if there are new cat ids
            foreach( $tagIds as $tagId ) {
                // a tag id is not in sortedTagIds! append it
                if( !in_array( $tagId, $sortedTagIds ) ){
                    $sortedTagsArray []= array('id' => $tagId, 'visible' => true);
                }
			}

			// also update names in case tag names were changed
			foreach( $tags as $tag ) {
				foreach( $sortedTagsArray as &$item ) {
					if( $item['id'] == $tag->term_id ) {
						$item['name'] = $tag->name;
						$item['slug'] = $tag->slug;
						break;
					}
				}
			}

			// and only put in tags that still exist
			$sortedTagsArrayReturn = array();
			foreach( $sortedTagsArray as $item2 ){
				foreach( $tags as $tag ) {
					if( $item2['id'] == $tag->term_id ) {
						$sortedTagsArrayReturn []= $item2;
					}
				}
			}
			// now convert to objects 
			foreach( $sortedTagsArrayReturn as &$item3 ) {
				// add "visible" property
				// if( !array_key_exists('visible', $item3) ) {
				// 	$item3['visible'] = true;
				// }
				// error_log(print_r($item3, true));
				$item3 = (object)$item3;
			}
			$json = json_encode( $sortedTagsArrayReturn );
			wp_send_json($json);
		}else{
			$tags2 = array();
			foreach( $tags as $tag ) {
				// error_log(print_r($tag, true));
				$tags2 []= array('id' => $tag->term_id, 'visible' => true, 'name' => $tag->name, 'slug' => $tag->slug );
			}
			// error_log(print_r($tags2, true));
			$json = json_encode( $tags2 );
			wp_send_json($json);
		}
		die();
	}

	public static function get_category_filter_list_for_thumbnailgrid(){
		$sortedFilterArray = $_GET['filter'];
		$categories = get_categories( array('hide_empty' => true, 'orderby' => 'menu_order') );

		if( is_array($sortedFilterArray) ){
            // first see if we have any ids in $categories that are not in $sortedFilterArray
            // in that case user must have added new categories
            $sortedFilterIds = array();
            $categoryIds = array();
            foreach( $categories as $category ) {
                $categoryIds []= $category->term_id;
            }
            foreach( $sortedFilterArray as $item ) {
                $sortedFilterIds []= $item['term_id'];
            }
			// check if there are new cat ids
            foreach( $categoryIds as $catId ) {
                // a category id is not in sortedFilterIds! append it
                if( !in_array( $catId, $sortedFilterIds ) ){
                    $sortedFilterArray []= array('term_id' => $catId);
                }
			}

			// also update names in case category names were changed
			foreach( $categories as $category ) {
				foreach( $sortedFilterArray as &$item ) {
					if( $item['term_id'] == $category->term_id ) {
						$item['name'] = $category->name;
						break;
					}
				}
			}

			// and only put in categories that still exist
			$sortedFilterArrayReturn = array();
			foreach( $sortedFilterArray as $item2 ){
				foreach( $categories as $category ) {
					if( $item2['term_id'] == $category->term_id ) {
						$sortedFilterArrayReturn []= $item2;
					}
				}
			}
			// now convert to objects 
			foreach( $sortedFilterArrayReturn as &$item3 ) {
				// add "visible" property
				// if( !array_key_exists('visible', $item3) ) {
				// 	$item3['visible'] = true;
				// }
				// error_log(print_r($item3, true));
				$item3 = (object)$item3;
			}
			$json = json_encode( $sortedFilterArrayReturn );
			wp_send_json($json);
		}else{
			$json = json_encode( $categories );
			wp_send_json($json);
		}
		die();
	}

	public static function get_thumbnails_for_thumbnailgrid_gridder(){
		$cat_id = $_GET['catId'];
        $config = $_GET['config'];

        $randomorder = array_key_exists('randomorder', $config) ? $config['randomorder'] : 'false';
        $sortbydate = array_key_exists('sortbydate', $config) ? $config['sortbydate'] : 'false';
        $sortbymenuorder = array_key_exists('sortbymenuorder', $config) ? $config['sortbymenuorder'] : 'false';
        $sortbycustom = array_key_exists('sortbycustom', $config) ? $config['sortbycustom'] : 'false';

        if( $randomorder == 'false' && $sortbydate == 'false' && $sortbymenuorder == 'false' ) {
            $sortbycustom = 'true';
        }

        $ids = array();
        // values passed by js are always strings:
        if( $sortbycustom == 'true' ) {
            $ids = Thumbnailgrid::get_project_ids_possibly_with_order($cat_id);
        } else {
            $orderby = '';
            if( $sortbydate == 'true' ) {
                $orderby = 'post_date';
            }
            if( $sortbymenuorder == 'true' ) {
                $orderby = 'menu_order';
            }
            if( $randomorder == 'true' ) {
                $orderby = 'rand';
            }
            $order = 'DESC';
            // WHY…?
            if( $orderby == 'menu_order' ) {
                $order = 'ASC';
            }
            $args = array(
                'posts_per_page' => -1,
                'orderby' => $orderby,
                'order' => $order,
                'post_type' => 'post',
                'cat' => $cat_id,
                'fields' => 'ids',
                'post_status' => 'publish'
            );
    
            $query = new WP_Query( $args );
    
            if ( $query->have_posts() ) {
                foreach ($query->posts as $post_id){
                    $ids []= $post_id;
                }
            }

            if( $randomorder == 'true' ) {
                shuffle($ids);
            }
        }
		$array = array();

		// generating an array of objects that contain all the info needed to view component
		// ar, cont, sizes, sizes._1024, title, descr,
		foreach ($ids as $post_id){
            // hide projectthumbnail of currently shown project
            // if( LayFrontend_Options::$hide_current_project_from_thumbnailgrid == 'on' && $post_id == $post->ID ){
            //     continue;
            // }
			$attid = get_post_thumbnail_id($post_id);
			$_512 = wp_get_attachment_image_src($attid, '_512');
			$full = wp_get_attachment_image_src($attid, 'full');

			$ar = 0;
			if($full && is_array($full) && $full[1] != 0){
				$ar = $full[2]/$full[1];
			}
			$tags = get_the_tags($post_id);
			$tagArray = array();
			if ($tags) {
				usort($tags, function($a, $b) {
					return $a->term_order - $b->term_order;
				});
				foreach($tags as $tag) {
					$tagArray []= $tag->name;
				}
			}

			$array []= array(
				"ar" => $ar,
				"cont" => $full[0],
				"sizes" => array("_512" => $_512[0]),
				"title" => get_the_title($post_id),
				"tags" => $tagArray,
				"descr" => get_post_meta($post_id, 'lay_project_description', true)
			);
		}

		wp_send_json($array);
		die();
	}

}
new Thumbnailgrid();
