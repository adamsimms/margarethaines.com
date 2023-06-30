<?php

class LayThumnbailgridFunctions{
    public function __construct(){
        add_action('wp_ajax_get_thumbnailgrid_filter_markup', array($this, 'lay_get_thumbnailgrid_filter_markup_ajax'));
    }

    public static function lay_get_thumbnailgrid_filter_markup_ajax(){
        // error_log(print_r('yyyyay', true));
        $config = $_POST['config'];
        echo LayThumnbailgridFunctions::lay_get_thumbnailgrid_filter_markup($config);
        die();
    }

    public static function lay_get_thumbnailgrid_tagfilter_markup($config){
        // error_log(print_r($config, true));
        // if( array_key_exists('showfilter', $config) && $config['showfilter'] == false ) {
            // only show tags that are in current category
        // }
        // $categories = get_categories( array( 'hide_empty' => true, 'orderby' => 'menu_order' ) );
        $sortedTagsArray;
        $useSortedTags = false;
        $filterMarkup = '';

        if( array_key_exists('sortedTagFilters', $config) && $config['sortedTagFilters'] && $config['sortedTagFilters'] != null) {
            $sortedTagsArray = $config['sortedTagFilters'];
            if( is_array($sortedTagsArray) && count($sortedTagsArray) > 0 ) {
                $useSortedTags = true;
            }
        }
        $tags = get_tags();

        if( $useSortedTags ) {

            // first see if we have any ids in $categories that are not in $sortedTagsArray
            // in that case user must have added new categories
            $sortedTagIds = array();
            $tagIds = array();
            foreach( $tags as $tag ) {
                $tagIds []= $tag->term_id;
            }
            foreach( $sortedTagsArray as $item ) {
                $sortedTagIds []= $item['id'];
            }

            foreach( $tagIds as $tagId ) {
                // a tag id is not in sortedTagIds! append it
                if( !in_array( $tagId, $sortedTagIds ) ){
                    $sortedTagsArray []= array('id' => $tagId);
                }
            }
            $ix = 0;
            // deselect tags button
            // pad with leading zeros for sorting
            if( array_key_exists('deselect_tags', $config) && $config['deselect_tags'] == true ) {
                $padded_ix = str_pad(strval($ix), 5, "0", STR_PAD_LEFT);
                $filterMarkup .= '<span data-ix="'.$padded_ix.'" class="tag-bubble deselect-tags lay-filter-hidden" style="display:none;"></span>';
                $ix++;
            }
            foreach( $sortedTagsArray as $item_new ) {
                $id = $item_new['id'];
                foreach( $tags as $tag ) {
                    // this means non-existent categories that might still be saved in $sortedFilterArray won't be added
                    if( $id == $tag->term_id ) {
                        $visible_class = 'lay-filter-visible';
                        if( array_key_exists('visible', $item_new) ) {
                            // error_log(print_r($item_new['visible'], true));
                            if( $item_new['visible'] == 'true' ) {
                                // error_log(print_r('yay', true));
                                $visible_class = 'lay-filter-visible';
                            }else{
                                $visible_class = 'lay-filter-hidden';
                            }
                        }
                        $visible_style = '';
                        if( $visible_class === 'lay-filter-hidden' ) {
                            $visible_style = 'style="display:none;"';
                        }
                        $padded_ix = str_pad(strval($ix), 5, "0", STR_PAD_LEFT);
                        $filterMarkup .= '<span data-ix="'.$padded_ix.'" data-tag_id="'.$tag->term_id.'" class="tag-bubble '.$tag->slug.' '.$visible_class.'" '.$visible_style.'>'.$tag->name.'</span>';
                        $ix++;
                        continue;
                    }
                }
            }

        } else {

            $ix = 0;
            foreach ( $tags as $tag ) {   
                // pad with leading zeros for sorting
                $padded_ix = str_pad(strval($ix), 5, "0", STR_PAD_LEFT); 
                $filterMarkup .= '<span data-ix="'.$padded_ix.'" data-tag_id="'.$tag->term_id.'" class="tag-bubble '.$tag->slug.'">'.$tag->name.'</span>';
                $ix++;
            }
        }
        $oneline = get_theme_mod('tgtf_oneline', 1) == 1 ? 'mobile-one-line' : 'mobile-not-one-line';
        return '<div class="_'.get_theme_mod('tgtf_textformat', 'Default').'_no_spaces lay-thumbnailgrid-tagfilter '.$oneline.'">'.$filterMarkup.'</div>';
    }

    public static function lay_get_thumbnailgrid_category_filter_markup($config = array()){
               // when this partial reloads because of the customizer, it won't have a $config passed
        // in this case, just use catgory with number 1 as active category for filter
        // this will not represent the shown thumbnails underneath but at least there'll be an active menupoint for styling purposes
        if( !array_key_exists('cat_id', $config) ) {
            $config['cat_id'] = 1;
        }

        $categories = get_categories( array( 'hide_empty' => true, 'orderby' => 'menu_order' ) );
        $sortedFilterArray;
        $useSortedFilter = false;

        if( array_key_exists('sortedFilters', $config) && $config['sortedFilters'] && $config['sortedFilters'] != null) {
            $sortedFilterArray = $config['sortedFilters'];
            if( is_array($sortedFilterArray) && count($sortedFilterArray) > 0 ) {
                $useSortedFilter = true;
            }
        }

        $oneline = get_theme_mod('tgf_oneline', 1) == 1 ? 'mobile-one-line' : 'mobile-not-one-line';
        $filterMarkup = '<div class="_'.get_theme_mod('tgf_textformat', 'Default').'_no_spaces lay-thumbnailgrid-filter '.$oneline.'">';
        if( $useSortedFilter ) {

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

            foreach( $categoryIds as $catId ) {
                // a category id is not in sortedFilterIds! append it
                if( !in_array( $catId, $sortedFilterIds ) ){
                    $sortedFilterArray []= array('term_id' => $catId);
                }
            }

            foreach( $sortedFilterArray as $item_new ) {
                // error_log(print_r($item, true));
                $id = $item_new['term_id'];
                foreach( $categories as $category ) {
                    // this means non-existent categories that might still be saved in $sortedFilterArray won't be added
                    if( $id == $category->term_id ) {
                        $category_name = $category->name;
                        $category_slug = $category->slug;
                        $visible_class = 'lay-filter-visible';
                        if( array_key_exists('visible', $item_new) ) {

                            if( $item_new['visible'] == 1 ) {
                                $visible_class = 'lay-filter-visible';
                            }else{
                                $visible_class = 'lay-filter-hidden';
                            }
                        }
                        $visible_style = '';
                        if( $visible_class === 'lay-filter-hidden' ) {
                            $visible_style = 'style="display:none;"';
                        }
                        // active filter
                        if( array_key_exists('cat_id', $config) && $config['cat_id'] == $id ) {
                            $filterMarkup .= '<div class="lay-thumbnailgrid-filter-anchor lay-filter-active lay-filter-default '.$visible_class.'" '.$visible_style.' data-slug="'.$category_slug.'" data-id="'.$id.'">'.$category_name.'</div>';
                        } else {
                            $filterMarkup .= '<div class="lay-thumbnailgrid-filter-anchor '.$visible_class.'" data-slug="'.$category_slug.'" '.$visible_style.' data-id="'.$id.'">'.$category_name.'</div>';
                        }
                    }
                }
            }


            $filterMarkup .= '</div>';
        } else {
            $first_anchor = '';
            $other_anchors = '';
    
            foreach( $categories as $category ) {
                $id = $category->term_id;
                $category_name = $category->name;
                $category_slug = $category->slug;
                // first anchor is always the anchor of the category that was selected to be shown in the thumbnailsgrid modal
                if( array_key_exists('cat_id', $config) && $config['cat_id'] == $id ) {
                    $first_anchor = '<div class="lay-thumbnailgrid-filter-anchor lay-filter-active lay-filter-default" data-slug="'.$category_slug.'" data-id="'.$id.'">'.$category_name.'</div>';
                } else {
                    $other_anchors .= '<div class="lay-thumbnailgrid-filter-anchor" data-slug="'.$category_slug.'" data-id="'.$id.'">'.$category_name.'</div>';
                }
            }
            $filterMarkup .= $first_anchor.$other_anchors.'</div>';
        }
        return $filterMarkup;
    }

    // using this in a customizer partial, so for convenience i put this function here
    public static function lay_get_thumbnailgrid_filter_markup($config = array()){
        $filterMarkup = '';
        $use_tag_filter = array_key_exists('showtagfilter', $config) ? $config['showtagfilter'] : false;
        $use_cat_filter = array_key_exists('showfilter', $config) ? $config['showfilter'] : false;
        // when gridder ajax: 'true'. when just frontend: 1 lmao
        if( $use_cat_filter == 'true' || $use_cat_filter == 1 ) {
            $filterMarkup .= LayThumnbailgridFunctions::lay_get_thumbnailgrid_category_filter_markup($config);
        }
        if( $use_tag_filter == 'true' || $use_tag_filter == 1 ) {
            $filterMarkup .= LayThumnbailgridFunctions::lay_get_thumbnailgrid_tagfilter_markup($config);
        }
        return $filterMarkup;
    }

    // this function accepts an array of postids and a display variable
    public static function get_thumbnails_data_for_thumbnailgrid_by_ids( $ids ){
		$array = array();

		// generating an array of objects that contain all the info needed to create a thumbnailgrid
		foreach ($ids as $post_id){

			$attid = get_post_thumbnail_id($post_id);

			$sizes = array();
			for ($i=0; $i < count(Setup::$sizes); $i++) {
				$attachment = wp_get_attachment_image_src($attid, Setup::$sizes[$i]);
                if( is_array($attachment) ) {
                    $sizes[Setup::$sizes[$i]] = $attachment[0];
                }
			}
			$full = wp_get_attachment_image_src($attid, 'full');
            if( is_array($full) ) {
                $sizes['full'] = $full[0];
            } else {
                $sizes['full'] = '';
            }

			$ar = 0;
			if($full){
				if($full[1] != 0){
					$ar = $full[2] / $full[1];
				}
			}

			// mouseover thumbnail image
			$mouseOverThumbSizesArr = array();
			$mouseOverThumbWidth = "";
			$mouseOverThumbHeight = "";
			if(ImageMouseoverThumbnails::$active == true){
				$mouseover_thumbnail_id = get_post_meta( $post_id, '_lay_thumbnail_mouseover_image', true );

				if ( $mouseover_thumbnail_id && get_post( $mouseover_thumbnail_id ) ) {
					for ($i=0; $i < count(Setup::$sizes); $i++) {
						$attachment = wp_get_attachment_image_src($mouseover_thumbnail_id, Setup::$sizes[$i]);
						$mouseOverThumbSizesArr[Setup::$sizes[$i]] = $attachment[0];
					}
					$full = wp_get_attachment_image_src($mouseover_thumbnail_id, 'full');
					$mouseOverThumbSizesArr['full'] = $full[0];
					$mouseOverThumbWidth = $full[1];
					$mouseOverThumbHeight = $full[2];
				}
			}
			// video thumbnail
			$video_url = "";
			$video_meta = array('width'=>'', 'height'=>'');
			if(VideoThumbnails::$active == true){
				$video_id = get_post_meta( $post_id, '_lay_thumbnail_video', true );
				if($video_id != ""){
					$video_url = wp_get_attachment_url($video_id);
					$video_meta = wp_get_attachment_metadata($video_id);
				}
            }
            $video_w = '';
            $video_h = '';
            // error_log(print_r($video_meta, true));
            if( is_array($video_meta) && isset($video_meta["width"]) && isset($video_meta["height"]) ) {
                $lastIx = count($array) - 1;
                $video_w = $video_meta["width"];
                $video_h = $video_meta["height"];
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
				"type" => "img",
				"title" => get_the_title($post_id),
				"attid" => $attid,
				"postid" => $post_id,
				"ar" => $ar,
				'sizes' => $sizes,
				"link" => get_permalink($post_id),
				"descr" => get_post_meta( $post_id, 'lay_project_description', true ),
				"mo_sizes" => $mouseOverThumbSizesArr,
	   			"mo_w" => $mouseOverThumbWidth,
	   			"mo_h" => $mouseOverThumbHeight,
                "video_url" => $video_url,
                "video_w" => $video_w,
                "video_h" => $video_h,
                'tags' => $tagArray
            );
		}

		return $array;
    }

    // this function just returns the neccessary data to create a thumbnailgrid
    public static function get_thumbnails_data_for_thumbnailgrid_by_catid( $cat_id, $config ){
        $ids = array();

        $randomorder = array_key_exists('randomorder', $config) ? $config['randomorder'] : false;
        $sortbydate = array_key_exists('sortbydate', $config) ? $config['sortbydate'] : false;
        $sortbymenuorder = array_key_exists('sortbymenuorder', $config) ? $config['sortbymenuorder'] : false;
        $sortbycustom = array_key_exists('sortbycustom', $config) ? $config['sortbycustom'] : false;
        $sortbyname = array_key_exists('sortbyname', $config) ? $config['sortbyname'] : false;

        if( $randomorder == false && $sortbydate == false && $sortbymenuorder == false && $sortbyname == false) {
            $sortbycustom = true;
        }

        $orderby = '';
        if( $sortbydate == true ) {
            $orderby = 'post_date';
        }
        if( $sortbymenuorder == true ) {
            $orderby = 'menu_order';
        }
        if( $randomorder == true ) {
            $orderby = 'rand';
        }
        if( $sortbyname == true ) {
            $orderby = 'post_title';
        }

        $ids = array();
        if( $sortbycustom == true ) {
            $ids = Thumbnailgrid::get_project_ids_possibly_with_order($cat_id);
        } else {
            $orderby = '';
            if( $sortbydate == true ) {
                $orderby = 'post_date';
            }
            if( $sortbymenuorder == true ) {
                $orderby = 'menu_order';
            }
            if( $randomorder == true ) {
                $orderby = 'rand';
            }
            if( $sortbyname == true ) {
                $orderby = 'post_title';
            }
            $order = 'DESC';
            // WHY…?
            if( $orderby == 'menu_order' || $orderby == 'post_title' ) {
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
                    $ids []= Frontend::get_polylang_translated_id($post_id, 'post');
                }
            }
        }

        if( LayFrontend_Options::$show_password_protected_posts_in_thumbnailgrid == false ) {
            $ids = Thumbnailgrid::filter_out_password_protected($ids);
        }

        return LayThumnbailgridFunctions::get_thumbnails_data_for_thumbnailgrid_by_ids($ids, $cat_id);
	}
}
new LayThumnbailgridFunctions();