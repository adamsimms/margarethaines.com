<?php

/*

TODO: Remove thumbnail json from carousel if post is trashed

*/

// this class updates project thumbnails and thumbnails inside carousels and stack elements when a project is saved
// and it updates thumbnails in stack elements

class LayUpdateThumbnails{

	public static function init() {
		add_filter( 'post_updated', 'LayUpdateThumbnails::update_thumbnail_everywhere', 10, 3 );
		add_filter( 'edited_post_tag', 'LayUpdateThumbnails::update_thumbnail_everywhere_after_tag_edit', 10, 2 );
		add_filter( 'delete_post_tag', 'LayUpdateThumbnails::update_thumbnail_everywhere_after_tag_edit', 10, 2 );

		add_filter( 'wp_trash_post', 'LayUpdateThumbnails::remove_thumbnail_from_everywhere', 10, 1 );
	}

	public static function get_gridder_json_values($from_posts = true) {
		global $wpdb;
		$table_name = 'postmeta';
		$column_name = 'meta_key';
		if (!$from_posts) {
			$table_name = 'options';
			$column_name = 'option_name';
		}

		$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}{$table_name} WHERE {$column_name} LIKE '%_gridder_json'");		
		return $results;
	}

	public static function remove_thumbnail_from_everywhere($post_id) {
		$category_gridder_json_values = LayUpdateThumbnails::get_gridder_json_values(false);
		foreach($category_gridder_json_values as $category_gridder_json_value) {
			LayUpdateThumbnails::remove_thumbnail_from_category_json($category_gridder_json_value, $post_id);
		}

		$post_gridder_json_values = LayUpdateThumbnails::get_gridder_json_values();
		foreach($post_gridder_json_values as $post_gridder_json_value) {
			LayUpdateThumbnails::remove_thumbnail_from_post_json($post_gridder_json_value, $post_id);
		}
	}

	private static function remove_thumbnail_from_category_json($category_gridder_json_value, $post_id) {
		if ($category_gridder_json_value->option_value) {
			try {
				$jsonObject = json_decode($category_gridder_json_value->option_value, true);
				$needsUpdate = false;

				if (!is_scalar($jsonObject)) {
					LayUpdateThumbnails::remove_thumbnail_from_json_recursive($jsonObject['cont'], $needsUpdate, $post_id);
				}

				if ($needsUpdate) {
					LayUpdateThumbnails::update_push($jsonObject);

					$jsonString = json_encode($jsonObject);
					if ($jsonString != false && $jsonString != "") {
						update_option( $category_gridder_json_value->option_name, $jsonString );
					}
				}
			} catch (Exception $e) {
				// Nothing - json is invalid
			}
		}
	}

	private static function remove_thumbnail_from_post_json($post_gridder_json_value, $post_id) {
		if ($post_gridder_json_value->meta_value) {
			try {
				$jsonObject = json_decode($post_gridder_json_value->meta_value, true);
				$needsUpdate = false;
	
				if (!is_scalar($jsonObject)) {
					LayUpdateThumbnails::remove_thumbnail_from_json_recursive($jsonObject['cont'], $needsUpdate, $post_id);
				}

				if ($needsUpdate) {
					LayUpdateThumbnails::update_push($jsonObject);
					// save json back to db
					// http://stackoverflow.com/a/22208945/3159159
					$jsonString = json_encode($jsonObject);
					if ($jsonString != false && $jsonString != "") {
						$jsonString = wp_slash( $jsonString );
						update_post_meta( $post_gridder_json_value->post_id, $post_gridder_json_value->meta_key, $jsonString );
					}
				}
			} catch (Exception $e) {
				// Nothing - json is invalid
			}
		}
	}

	private static function remove_thumbnail_from_json_recursive(&$array, &$needsUpdate, $post_id) {
		if (is_array($array)) {
			for ($i = 0; $i < count($array); $i++) {
				if (array_key_exists('postid', $array[$i])) {
					if ($array[$i]['postid'] == $post_id) {
						// delete column
						unset($array[$i]);
						// http://stackoverflow.com/questions/369602/delete-an-element-from-an-array/369761#369761
						$array = array_values($array);
						$needsUpdate = true;
						$i--;
					}
				}
				else if ($array[$i]['type'] == 'carousel') {
					LayUpdateThumbnails::remove_thumbnail_from_json_recursive($array[$i]['carousel'], $needsUpdate, $post_id);
				}
				else if ($array[$i]['type'] == 'elementgrid' && isset($array[$i]['config'])) {
					LayUpdateThumbnails::remove_thumbnail_from_json_recursive($array[$i]['config']['elements'], $needsUpdate, $post_id);
				}
				else if ($array[$i]['type'] == 'stack') {
					LayUpdateThumbnails::remove_thumbnail_from_json_recursive($array[$i]['cont'], $needsUpdate, $post_id);
				}
			}
		}
	}

	// push needs to be different elements in 100vh rows cause they are pos absolute

    // todo: test this!
	private static function update_push(&$jsonObj) {
		$right = 0;

		for ($i = 0, $rowix = 0; $i < count($jsonObj['cont']); $i++) {
            if( array_key_exists('row', $jsonObj['cont'][$i]) && array_key_exists('col', $jsonObj['cont'][$i]) && !array_key_exists('placeFreely', $jsonObj['cont'][$i]) ) {
                if ($jsonObj['cont'][$i]['row'] != $rowix) {
                    $right = 0;
                }
    
                $rowWithElsPositionAbsolute = LayUpdateThumbnails::row_has_elements_placed_absolute($rowix, $jsonObj);
                $type = $jsonObj['cont'][$i]['type'];
    
                $left = $jsonObj['cont'][$i]['col'];
    
                $absolute_pos_el = array_key_exists('absolute_position', $jsonObj['cont'][$i]) ? $jsonObj['cont'][$i]['absolute_position'] : false;
    
                if ($rowWithElsPositionAbsolute) {
                    if( $type == 'text' || $type == 'html' || $absolute_pos_el ) {
                        $push = $left;
                    }
                } else {
                    $push = $left - $right;
                    $right = $jsonObj['cont'][$i]['col'] + $jsonObj['cont'][$i]['colspan'];
                }
    
                $jsonObj['cont'][$i]['push'] = $push;
                $rowix = $jsonObj['cont'][$i]['row'];
            }
		}
	}

	private static function row_has_elements_placed_absolute($rowix, $jsonObj) {
		if (array_key_exists($rowix, $jsonObj['rowAttrs'])) {
			if (!is_null($jsonObj['rowAttrs'][$rowix])) {
				if (array_key_exists('row100vh', $jsonObj['rowAttrs'][$rowix]) && $jsonObj['rowAttrs'][$rowix]['row100vh'] == true) {
					return true;
				}
                if (array_key_exists('rowcustomheight', $jsonObj['rowAttrs'][$rowix]) && $jsonObj['rowAttrs'][$rowix]['rowcustomheight'] != '') {
					return true;
				}
			}
		}
		return false;
	}

	// update tags for project thumbnails
	// todo: update tags for project thumbnails in carousel
	// todo: put tags in carousel project thumbnails
	public static function update_thumbnail_everywhere_after_tag_edit( $term_id, $tt_id ){

		$category_gridder_json_values = LayUpdateThumbnails::get_gridder_json_values(false);
		foreach($category_gridder_json_values as $category_gridder_json_value) {
			if ($category_gridder_json_value->option_value) {
				try {
					$jsonObject = json_decode($category_gridder_json_value->option_value, true);
					$needsUpdate = false;
	
					if (!is_scalar($jsonObject)) {
						if (is_array($jsonObject['cont'])) {
							for ($i = 0; $i < count($jsonObject['cont']); $i++) {
								// element with type of thumbnail has 'postid' attribute .. but it's actual element type could be still 'img' instead of 'postThumbnail'
								if (array_key_exists( 'postid', $jsonObject['cont'][$i] )) {
									// does element have postid of current post being saved?
									$needsUpdate = true;
									// tags
									$tags = get_the_tags($jsonObject['cont'][$i]['postid']);
									$tagArray = array();
									if ($tags) {
										usort($tags, function($a, $b) {
											return $a->term_order - $b->term_order;
										});
										foreach($tags as $tag) {
											$tagArray []= $tag->name;
										}
									}
									$jsonObject['cont'][$i]['tags'] = $tagArray;
								}
							}
						}
					}
	
					if ($needsUpdate) {
							// save json back to db
						$jsonString = json_encode($jsonObject);
						if ($jsonString != false && $jsonString != "") {
							update_option( $category_gridder_json_value->option_name, $jsonString );
						}
					}
				} catch (Exception $e) {
					// Nothing - json is invalid
				}
			}
		}

		$post_gridder_json_values = LayUpdateThumbnails::get_gridder_json_values();
		foreach($post_gridder_json_values as $post_gridder_json_value) {
			if ($post_gridder_json_value->meta_value) {
				try {
					$jsonObject = json_decode($post_gridder_json_value->meta_value, true);
					$needsUpdate = false;
	
					if (!is_scalar($jsonObject)) {
						if (is_array($jsonObject['cont'])) {
							for ($i = 0; $i < count($jsonObject['cont']); $i++) {
								// element with type of thumbnail has 'postid' attribute .. but it's actual element type could be still 'img' instead of 'postThumbnail'
								if (array_key_exists( 'postid', $jsonObject['cont'][$i] )) {
									// does element have postid of current post being saved?
									$needsUpdate = true;
									// tags
									$tags = get_the_tags($jsonObject['cont'][$i]['postid']);
									$tagArray = array();
									if ($tags) {
										usort($tags, function($a, $b) {
											return $a->term_order - $b->term_order;
										});
										foreach($tags as $tag) {
											$tagArray []= $tag->name;
										}
									}
									$jsonObject['cont'][$i]['tags'] = $tagArray;
								}
							}
						}
					}
	
					if ($needsUpdate) {
						// save json back to db
						// http://stackoverflow.com/a/22208945/3159159
						$jsonString = json_encode($jsonObject);
						if ($jsonString != false && $jsonString != '') {
							$jsonString = wp_slash( $jsonString );
							update_post_meta( $post_gridder_json_value->post_id, $post_gridder_json_value->meta_key, $jsonString );
						}
					}
				} catch (Exception $e) {
					// Nothing - json is invalid
				}
			}
		}
	}

	// update the post values in all category, page and post jsons
	// http://wordpress.stackexchange.com/questions/134664/what-is-correct-way-to-hook-when-update-post
	public static function update_thumbnail_everywhere($post_id, $post_after, $post_before) {
		$poststatus = get_post_status($post_id);
		if (!has_post_thumbnail($post_id) || $poststatus != 'publish') {
			return;
		}

		// check for posttype. cause post_updated also gets triggered when nav_menu_item updates / a navigation menu is saved
		if (get_post_type( $post_id ) == 'post' ) {

			$featuredImgId = get_post_thumbnail_id($post_id);
			$featuredImgObj = wp_get_attachment_image_src($featuredImgId, 'full');
            if( $featuredImgObj ) {
                $sizesArr = array();

                $permalink = LTUtility::getRelativeURL(get_permalink($post_id));
                $title = stripslashes($post_after->post_title);
    
                $featuredImgUrl = LTUtility::getRelativeURL($featuredImgObj[0]);
                $ar = $featuredImgObj[2] / $featuredImgObj[1];
                $w = $featuredImgObj[1];
                $h = $featuredImgObj[2];
    
                for ($i = 0; $i < count(Setup::$sizes); $i++) {
                    $attachment = wp_get_attachment_image_src($featuredImgId, Setup::$sizes[$i]);
                    $sizesArr[Setup::$sizes[$i]] = LTUtility::getRelativeURL($attachment[0]);
                }
                $full = wp_get_attachment_image_src($featuredImgId, 'full');
                $sizesArr['full'] = LTUtility::getRelativeURL($full[0]);
    
                $projectDescr = "";
                if ( isset( $_POST['lay_project_description'] ) ) {
                    $projectDescr = $_POST['lay_project_description'];
                    $projectDescr = wpautop($projectDescr);
                    $projectDescr = stripslashes($projectDescr);
                }
    
                // mouseover thumbnail image
                $mouseOverThumbSizesArr = array();
                $mouseOverThumbWidth = "";
                $mouseOverThumbHeight = "";
                $mouseover_thumbnail_id = "";
                
                if (ImageMouseoverThumbnails::$active == true) {
                    if ( isset( $_POST['_lay_thumbnail_mouseover_image'] ) ) {
                        $mouseover_thumbnail_id = $_POST['_lay_thumbnail_mouseover_image'];
                    }
    
                    if ($mouseover_thumbnail_id && get_post( $mouseover_thumbnail_id )) {
                        for ($i = 0; $i < count(Setup::$sizes); $i++) {
                            $attachment = wp_get_attachment_image_src($mouseover_thumbnail_id, Setup::$sizes[$i]);
                            $mouseOverThumbSizesArr[Setup::$sizes[$i]] = LTUtility::getRelativeURL($attachment[0]);
                        }
                        $full = wp_get_attachment_image_src($mouseover_thumbnail_id, 'full');
                        $mouseOverThumbSizesArr['full'] = LTUtility::getRelativeURL($full[0]);
                        $mouseOverThumbWidth = $full[1];
                        $mouseOverThumbHeight = $full[2];
                    }
                }
                // video thumbnail
                $video_url = "";
                $video_attid = "";
                $video_meta = array('width'=>'', 'height'=>'');
                if (VideoThumbnails::$active == true) {
                    if ( isset( $_POST['_lay_thumbnail_video'] ) && '-1' != $_POST['_lay_thumbnail_video']) {
                        $video_attid = $_POST['_lay_thumbnail_video'];
                        $video_url = LTUtility::getRelativeURL(wp_get_attachment_url($video_attid));
                        $video_meta = wp_get_attachment_metadata($video_attid);
                    }
                }
    
                $category_gridder_json_values = LayUpdateThumbnails::get_gridder_json_values(false);
                foreach($category_gridder_json_values as $category_gridder_json_value) {
                    LayUpdateThumbnails::update_thumbnail_in_category_json($category_gridder_json_value, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl,
                        $ar, $sizesArr, $projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h);
                }
        
                $post_gridder_json_values = LayUpdateThumbnails::get_gridder_json_values();
                foreach($post_gridder_json_values as $post_gridder_json_value) {
                    LayUpdateThumbnails::update_thumbnail_in_post_json($post_gridder_json_value, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl,
                        $ar, $sizesArr, $projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h);
                }
            }
	
		}
	}

	private static function update_thumbnail_in_post_json($post_gridder_json_value, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl,
			$ar, $sizesArr, $projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h) {

		if ($post_gridder_json_value->meta_value) {
			try {
				$jsonObject = json_decode($post_gridder_json_value->meta_value, true);
				$needsUpdate = false;

				if (!is_scalar($jsonObject)) {
					LayUpdateThumbnails::update_thumbnail_in_json_recursive($jsonObject['cont'], $needsUpdate, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl,
						$ar, $sizesArr, $projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h);
				}

				if ($needsUpdate) {
					// save json back to db
					// http://stackoverflow.com/a/22208945/3159159
					$jsonString = json_encode($jsonObject);
					if ($jsonString != false && $jsonString != '') {
						$jsonString = wp_slash( $jsonString );
						update_post_meta( $post_gridder_json_value->post_id, $post_gridder_json_value->meta_key, $jsonString );
					}
				}
			} catch (Exception $e) {
				// Nothing - json is invalid
			}
		}
	}

	private static function update_thumbnail_in_category_json($category_gridder_json_value, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl,
			$ar, $sizesArr, $projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h) {

		if ($category_gridder_json_value->option_value) {
			try {
				$jsonObject = json_decode($category_gridder_json_value->option_value, true);
				$needsUpdate = false;

				if (!is_scalar($jsonObject)) {
					LayUpdateThumbnails::update_thumbnail_in_json_recursive($jsonObject['cont'], $needsUpdate, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl,
						$ar, $sizesArr, $projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h);
				}

				if ($needsUpdate) {
						// save json back to db
					$jsonString = json_encode($jsonObject);
					if ($jsonString != false && $jsonString != "") {
						update_option( $category_gridder_json_value->option_name, $jsonString );
					}
				}
			} catch (Exception $e) {
				// Nothing - json is invalid
			}
		}
	}

	private static function update_thumbnail_in_json_recursive(&$array, &$needsUpdate, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl,
			$ar, $sizesArr, $projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h) {
		if (is_array($array)) {
			for ($i = 0; $i < count($array); $i++) {
				// element with type of thumbnail has 'postid' attribute .. but it's actual element type could be still 'img' instead of 'postThumbnail'
				if (array_key_exists( 'postid', $array[$i] )) {
					// does element have postid of current post being saved?
					if ($array[$i]['postid'] == $post_id) {
						$needsUpdate = true;
						$array[$i]['link'] = $permalink;
						$array[$i]['title'] = $title;
						if (isset($array[$i]['caption'])) {
							$array[$i]['caption'] = $title;
						}
                        // dont update values if image was replaced manually
                        // todo: replace w and h values & alt value
                        if( !array_key_exists( 'replacedImage', $array[$i]) ) {
                            $array[$i]['attid'] = $featuredImgId;
                            $array[$i]['cont'] = $featuredImgUrl;
                            $array[$i]['ar'] = $ar;
                            $array[$i]['sizes'] = $sizesArr;
                            $array[$i]['w'] = $w;
                            $array[$i]['h'] = $h;
                        }
                        $array[$i]['descr'] = $projectDescr;
						if (ImageMouseoverThumbnails::$active == true) {
							$array[$i]['mo_attid'] = $mouseover_thumbnail_id;
							$array[$i]['mo_sizes'] = $mouseOverThumbSizesArr;
							$array[$i]['mo_w'] = $mouseOverThumbWidth;
							$array[$i]['mo_h'] = $mouseOverThumbHeight;
						}
						if (VideoThumbnails::$active == true) {
							$array[$i]['video_url'] = $video_url;
							$array[$i]['video_w'] = $video_meta['width'];
							$array[$i]['video_h'] = $video_meta['height'];
							$array[$i]['video_attid'] = $video_attid;
						}
						// tags
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
						$array[$i]['tags'] = $tagArray;
					}
				}
				// update project thumbnails in carousels
				else if ($array[$i]['type'] == 'carousel') {
					LayUpdateThumbnails::update_thumbnail_in_json_recursive($array[$i]['carousel'], $needsUpdate, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl, $ar, $sizesArr,
						$projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h);
				}
				// update project thumbnails in elementgrid
				else if ($array[$i]['type'] == 'elementgrid' && isset($array[$i]['config'])) {
					LayUpdateThumbnails::update_thumbnail_in_json_recursive($array[$i]['config']['elements'], $needsUpdate, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl, $ar, $sizesArr,
						$projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h);
				}
				// update project thumbnails in type stack
				else if ($array[$i]['type'] == 'stack' ) {
					LayUpdateThumbnails::update_thumbnail_in_json_recursive($array[$i]['cont'], $needsUpdate, $post_id, $permalink, $title, $featuredImgId, $featuredImgUrl, $ar, $sizesArr,
						$projectDescr, $mouseOverThumbSizesArr, $mouseOverThumbWidth, $mouseOverThumbHeight, $video_url, $video_attid, $video_meta, $mouseover_thumbnail_id, $w, $h);
				}
			}
		}
	}
}

LayUpdateThumbnails::init();