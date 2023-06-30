<?php

class LayUpdateRowBgLinks{

	public static function update_row_bg_link(&$array, &$needsUpdate, $linktype_to_update, $id, $permalink, $title) {
		if (is_array($array)) {
			for ($i = 0; $i < count($array); $i++) {
				if( is_array( $array[$i] ) ){
					if (array_key_exists( 'link', $array[$i] )) {
						// make sure the imagelink is of type $linktype_to_update
						if( in_array($array[$i]['link']['type'], $linktype_to_update) ){
							// make sure that the post id linked to is id of current post being saved
							if( $array[$i]['link']['id'] == $id ){
								$needsUpdate = true;
								$array[$i]['link']['url'] = $permalink;
								$array[$i]['link']['title'] = $title;
	
								// if image links to a project, update the catid too
								if($array[$i]['link']['type'] == "project"){
									$categories = get_the_category($id);
									$catid = array();
									foreach($categories as $cat){
										$catid []= $cat->term_id;
									}
									$array[$i]['link']['catid'] = $catid;
								}
							}
						}
					}
				}
			}
		}
	}

	public static function remove_row_bg_link(&$array, &$needsUpdate, $linktype_to_update, $id) {
		if (is_array($array)) {
			for ($i = 0; $i < count($array); $i++) {
				if( is_array( $array[$i] ) ){
					if (array_key_exists( 'link', $array[$i] )) {
						// make sure the imagelink is of type $linktype_to_update
						if( in_array($array[$i]['link']['type'], $linktype_to_update) ){
							if ($array[$i]['link']['id'] == $id) {
								$needsUpdate = true;
								unset($array[$i]['link']);
							}
						}
					}
				}
			}
		}
	}
}