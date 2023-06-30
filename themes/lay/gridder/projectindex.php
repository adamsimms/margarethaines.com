<?php

class ProjectIndex{

    public function __construct(){
		if ( is_admin() ) {
			add_action('wp_ajax_get_projectindex', array($this, 'get_projectindex_via_ajax'));
            add_action('wp_ajax_get_category_list_for_projectindex', array($this, 'get_category_list_for_projectindex'));
            add_action('wp_ajax_get_tag_list_for_projectindex', array($this, 'get_tag_list_for_projectindex'));
		}
    }

    public static function get_tag_list_for_projectindex(){
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
                $sortedTagIds []= $item['term_id'];
            }
			// check if there are new cat ids
            foreach( $tagIds as $tagId ) {
                // a tag id is not in sortedTagIds! append it
                if( !in_array( $tagId, $sortedTagIds ) ){
                    $sortedTagsArray []= array('term_id' => $tagId, 'visible' => true);
                }
			}

			// also update names in case tag names were changed
			foreach( $tags as $tag ) {
				foreach( $sortedTagsArray as &$item ) {
					if( $item['term_id'] == $tag->term_id ) {
						$item['name'] = $tag->name;
						break;
					}
				}
			}

			// and only put in tags that still exist
			$sortedTagsArrayReturn = array();
			foreach( $sortedTagsArray as $item2 ){
				foreach( $tags as $tag ) {
					if( $item2['term_id'] == $tag->term_id ) {
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
			$json = json_encode( $tags );
			wp_send_json($json);
		}
		die();
	}

    public static function usortCat($a, $b) {
        if ($a['cats_markup'] == $b['cats_markup']) {
            return 0;
        }
        $cmp = strcmp($a['cats_markup'], $b['cats_markup']);
        $value = 0;
        if( $cmp > 0 ) {
            $value = 1;
        } else if ( $cmp < 0 ) {
            $value = -1;
        }
        return $value;
    }

    public static function usortTag($a, $b) {
        // if ($a['tags_markup'] == $b['tags_markup']) {
        //     return 0;
        // }
        // $cmp = strcmp($a['tags_markup'], $b['tags_markup']);
        // $value = 0;
        // if( $cmp > 0 ) {
        //     $value = 1;
        // } else if ( $cmp < 0 ) {
        //     $value = -1;
        // }
        // return $value;

        // https://stackoverflow.com/questions/3699439/natsort-multidemsional-array
        // using natsort so numbers will be sorted correctly too, in case someone uses numbers for tags
        return strnatcasecmp($a['tags_markup'], $b['tags_markup']);
    }

    public static function usortTitle($a, $b) {
        if ($a['post_title'] == $b['post_title']) {
            return 0;
        }
        $cmp = strcmp($a['post_title'], $b['post_title']);
        $value = 0;
        if( $cmp > 0 ) {
            $value = 1;
        } else if ( $cmp < 0 ) {
            $value = -1;
        }
        return $value; 
    }

    public static function usortDate($a, $b) {
        // error_log(print_r($a, true));
        // error_log(print_r($a['post_date'], true));
        $a_date = get_the_date('Ymd', $a['post_id']);
        $b_date = get_the_date('Ymd', $b['post_id']);
        // error_log(print_r($a_date, true));
        if ($a_date == $b_date) {
            return 0;
        }
        $cmp = strcmp(strtotime($a_date), strtotime($b_date));
        $value = 0;
        if( $cmp > 0 ) {
            $value = 1;
        } else if ( $cmp < 0 ) {
            $value = -1;
        }
        return $value; 
    }

    public static function orderRows(&$rows, $orderby, $order){
        switch( $orderby ) {
            case 'categories':
                usort($rows, 'ProjectIndex::usortCat');
            break;
            case 'tags':
                usort($rows, 'ProjectIndex::usortTag');
            break;
            case 'title':
                usort($rows, 'ProjectIndex::usortTitle');
            break;
            case 'date':
                usort($rows, 'ProjectIndex::usortDate');
            break;
        }
        // error_log(print_r($orderby.' $orderby', true));

        if($order == 'DESC'){
            $rows = array_reverse($rows);
        }
    }

    public static function get_category_list_for_projectindex(){
		$sortedCategoriesArray = $_GET['categories'];
		$categories = get_categories( array('hide_empty' => false, 'orderby' => 'menu_order') );

		if( is_array($sortedCategoriesArray) ){
            // first see if we have any ids in $categories that are not in $sortedCategoriesArray
            // in that case user must have added new categories
            $sortedCatIds = array();
            $categoryIds = array();
            foreach( $categories as $category ) {
                $categoryIds []= $category->term_id;
            }
            foreach( $sortedCategoriesArray as $item ) {
                $sortedCatIds []= $item['term_id'];
            }
			// check if there are new cat ids
            foreach( $categoryIds as $catId ) {
                // a category id is not in sortedCatIds! append it
                if( !in_array( $catId, $sortedCatIds ) ){
                    $sortedCategoriesArray []= array('term_id' => $catId, 'visible' => true);
                }
			}

			// also update names in case category names were changed
			foreach( $categories as $category ) {
				foreach( $sortedCategoriesArray as &$item ) {
					if( $item['term_id'] == $category->term_id ) {
						$item['name'] = $category->name;
						break;
					}
				}
			}

			// and only put in categories that still exist
			$sortedCategoriesArrayReturn = array();
			foreach( $sortedCategoriesArray as $item2 ){
				foreach( $categories as $category ) {
					if( $item2['term_id'] == $category->term_id ) {
						$sortedCategoriesArrayReturn []= $item2;
					}
				}
			}
			// now convert to objects 
			foreach( $sortedCategoriesArrayReturn as &$item3 ) {
				// add "visible" property
				// if( !array_key_exists('visible', $item3) ) {
				// 	$item3['visible'] = true;
				// }
				// error_log(print_r($item3, true));
				$item3 = (object)$item3;
			}
			$json = json_encode( $sortedCategoriesArrayReturn );
			wp_send_json($json);
		}else{
			$json = json_encode( $categories );
			wp_send_json($json);
		}
		die();
	}

    public static function get_projectindex_via_ajax() {
        $config = $_POST['config'];
        $uniqueId = array_key_exists('uniqueId', $_POST) ? $_POST['uniqueId'] : '';
        $currentLayout = array_key_exists('currentLayout', $_POST) ? $_POST['currentLayout'] : 'desktop';
        echo ProjectIndex::get_projectindex($config, $currentLayout);
        die();
    }

    public static function get_projectindex($config, $currentLayout) {
        $orderby = '';
        if( is_array($config) ) {
            $orderby_temp = $config['orderBy'];
            $order = $config['order'];
        }
        // when order by is category or tag, i need to order manually, cause wordpress doesnt accept these arguments for order
        if( $orderby_temp != 'category' && $orderby_temp != 'tag' ) {
            $orderby = $orderby_temp;
        }
        // only the projects of these categories are shown. empty for all. this is the value of the multiselector for categories in the modal

        // i have no idea why, but orderby and order doesnt work here
        // $query->request always returns "wp_posts.menu_order ASC" even if i use totally different values
        // thats why i just sort myself by using "ProjectIndex::orderRows"
        /*
        
        wp_posts.ID FROM wp_posts  WHERE 1=1  AND wp_posts.post_type = 'post' AND ((wp_posts.post_status = 'publish'))  ORDER BY wp_posts.menu_order ASC 


        */
        $query_args = array(
            'post_status' => 'publish',
            'orderby' => $orderby,
            'order' => $order,
            'posts_per_page' => -1,
            'fields' => 'ids',
            'has_password' => false
        );

        $category_term_slugs = array();
        if( is_array( $config['category'] ) ) {
            foreach ($config['category'] as $cat) {
                $category_term_slugs []= $cat['value'];
            }
        }
        if( count($category_term_slugs) > 0 ) {
            $query_args['category_name'] = implode(',', $category_term_slugs);
        }
        $style = array_key_exists('style', $config) ? $config['style'] : 'table';
        $separator = ( $style == 'comma' || $style == 'comma2' ) ? '<span class="lay-pi-separator">,&nbsp;</span>' : '';
        $separator2 = ( $style == 'comma' || $style == 'comma2' ) ? '<span class="_'.$config['filtersTextformat'].'_no_spaces lay-pi-separator">,&nbsp;</span>' : '';

        // 'color:'.$config['textColor'].';';

        $uniqueId = array_key_exists('uniqueId', $config) ? $config['uniqueId'] : '';
        $filterColor = array_key_exists('filterColor', $config) ? $config['filterColor'] : $config['textColor'];
        $filterHoverColor = array_key_exists('filterHoverColor', $config) ? $config['filterHoverColor'] : $filterColor;

        $filterHoverCSS = '';
        if( array_key_exists('doFilterHoverColor', $config) && $config['doFilterHoverColor'] == true ) {
            $filterHoverCSS = '
                .lay-projectindex.id-'.$uniqueId.' .lay-projectindex-filter-inner:hover polyline{ stroke:'.$filterHoverColor.'; }
                .lay-projectindex.id-'.$uniqueId.' .lay-projectindex-filter-inner:hover{ color:'.$filterHoverColor.'; }
            ';
        }

        $paddingDesktop = array_key_exists('paddingLeftRight', $config['desktop']) ? $config['desktop']['paddingLeftRight'] : 0;
        $paddingTablet = array_key_exists('paddingLeftRight', $config['tablet']) ? $config['tablet']['paddingLeftRight'] : 0;
        $paddingPhone = array_key_exists('paddingLeftRight', $config['phone']) ? $config['phone']['paddingLeftRight'] : 0;

        $phone_breakpoint = get_option('lay_breakpoint', 600);
        $phone_breakpoint = (int)$phone_breakpoint;

		$tablet_breakpoint = get_option( 'lay_tablet_breakpoint', 1024 );
        $tablet_breakpoint = (int)$tablet_breakpoint;

        // when imagehover addon is active, we add a hover class by javascript
        // cause with the imagehover addon we trigger a "mouseover" or simulate a mouseover even when we just scroll and dont move the mouse
        // that is why here we do: .lay-projectindex.lay-projectindex-imagehover-not-active for some of the hover css
        $projectindex_css = 
        '<style>
            @media (min-width: '.($tablet_breakpoint+1).'px){'
                .'.lay-projectindex.id-'.$uniqueId.' .lay-projectindex-row,
                .lay-projectindex.id-'.$uniqueId.' .lay-projectindex-filter-wrap{
                    padding-left:'.$paddingDesktop.'px;
                    padding-right:'.$paddingDesktop.'px;
                }'
            .'}
            @media (max-width: '.($tablet_breakpoint).'px) and (min-width: '.($phone_breakpoint+1).'px){'
                .'.lay-projectindex.id-'.$uniqueId.' .lay-projectindex-row,
                .lay-projectindex.id-'.$uniqueId.' .lay-projectindex-filter-wrap{
                    padding-left:'.$paddingTablet.'px;
                    padding-right:'.$paddingTablet.'px;
                }'
            .'}
            @media (max-width: '.($phone_breakpoint).'px){'
                .'.lay-projectindex.id-'.$uniqueId.' .lay-projectindex-row,
                .lay-projectindex.id-'.$uniqueId.' .lay-projectindex-filter-wrap{
                    padding-left:'.$paddingPhone.'px;
                    padding-right:'.$paddingPhone.'px;
                }'
            .'}
            .lay-projectindex.id-'.$uniqueId.' .lay-project-index-current-project{ background-color:'.$config['activeColor'].'; }'
            .'.lay-projectindex.id-'.$uniqueId.' .lay-projectindex-filter-inner polyline{ stroke:'.$filterColor.'; }'
            .'.lay-projectindex.id-'.$uniqueId.' .lay-projectindex-filter-inner{ color:'.$filterColor.'; }'
            .$filterHoverCSS
            .'.lay-projectindex.id-'.$uniqueId.' .lay-projectindex-col{ color:'.$config['textColor'].'; }'
            .(array_key_exists('doHoverColor', $config) && $config['doHoverColor'] == true ? '.lay-projectindex.lay-projectindex-imagehover-not-active.id-'.$uniqueId.' .lay-projectindex-row:hover>div, .lay-projectindex.lay-projectindex-imagehover-active.id-'.$uniqueId.' .lay-projectindex-row.hover>div{ color:'.$config['hoverColor'].'; }' : '')    
            .(array_key_exists('doBgHoverColor', $config) && $config['doBgHoverColor'] == true ? '.lay-projectindex.lay-projectindex-imagehover-not-active.id-'.$uniqueId.' .lay-projectindex-row:hover, .lay-projectindex.lay-projectindex-imagehover-active.id-'.$uniqueId.' .lay-projectindex-row.hover{ background-color:'.$config['bgHoverColor'].'; }' : '')    
        .'</style>';

        $imagehover_active = $config['useImageHover'] && is_plugin_active('laytheme-imagehover/laytheme-imagehover.php') == true ? 'lay-projectindex-imagehover-active' : 'lay-projectindex-imagehover-not-active';


        $lay_projectindex = '<div class="lay-projectindex lay-projectindex-style-'.$style.' id-'.$uniqueId.' '.$imagehover_active.'" data-config="'.htmlspecialchars(json_encode($config)).'">';

        // filter!
        // error_log(print_r("yay", true));
        // error_log(print_r($config, true));

        $showFilter = $config['showFilters'];
        if( is_string($config['showFilters']) ) {
            // error_log(print_r('is string!', true));
            // error_log(print_r($config['showFilters'], true));
            $showFilter = $config['showFilters'] == 'true' ? true : false;
        }

        if( $showFilter === true ) {
            // error_log(print_r('reached filter code!', true));
            $lay_projectindex .= '<div class="lay-projectindex-filter-wrap">';

            foreach ($config[$currentLayout]['sortedColumns'] as $column) {

                $css = 'padding-top:'.$config['spaceTopBottom'].'px; padding-bottom:'.$config['spaceTopBottom'].'px;';
                if( $column['visible'] === 'false' || $column['visible'] === false ) {
                    $css .= 'display:none;';
                }

                switch( $column['name'] ) {
                    case 'year':
                        $active = $orderby == 'date' ? 'projectindex-filter-active' : '';
                        $lay_projectindex .= 
                        '<div class="'.$active.' order-'.$order.' lay-projectindex-filter lay-projectindex-filter-year" style="'.$css.'">
                            <div class="lay-projectindex-filter-inner">
                                <span class="_'.$config['filtersTextformat'].'_no_spaces">'.$config['yearFilterText'].'</span>
                                <svg height="9" width="16"><polyline fill="none" stroke="black" points="1,0 8,8 15,0"></polyline></svg>
                                '.$separator2.'
                            </div>
                        </div>';
                    break;
                    case 'title':
                        $active = $orderby == 'title' ? 'projectindex-filter-active' : '';
                        $lay_projectindex .= 
                        '<div class="'.$active.' order-'.$order.' lay-projectindex-filter lay-projectindex-filter-title" style="'.$css.'">
                            <div class="lay-projectindex-filter-inner">
                                <span class="_'.$config['filtersTextformat'].'_no_spaces">'.$config['titleFilterText'].'</span>
                                <svg height="9" width="16"><polyline fill="none" stroke="black" points="1,0 8,8 15,0"></polyline></svg>
                                '.$separator2.'
                            </div>
                        </div>';
                    break;
                    case 'categories':
                        $active = $orderby == 'categories' ? 'projectindex-filter-active' : '';
                        $lay_projectindex .= 
                        '<div class="'.$active.' order-'.$order.' lay-projectindex-filter lay-projectindex-filter-categories" style="'.$css.'">
                            <div class="lay-projectindex-filter-inner">
                                <span class="_'.$config['filtersTextformat'].'_no_spaces">'.$config['categoriesFilterText'].'</span>
                                <svg height="9" width="16"><polyline fill="none" stroke="black" points="1,0 8,8 15,0"></polyline></svg>
                                '.$separator2.'
                            </div>
                        </div>';
                    break;
                    case 'tags':
                        $active = $orderby == 'tags' ? 'projectindex-filter-active' : '';
                        $lay_projectindex .= 
                        '<div class="'.$active.' order-'.$order.' lay-projectindex-filter lay-projectindex-filter-tags" style="'.$css.'">
                            <div class="lay-projectindex-filter-inner">
                                <span class="_'.$config['filtersTextformat'].'_no_spaces">'.$config['tagsFilterText'].'</span>
                                <svg height="9" width="16"><polyline fill="none" stroke="black" points="1,0 8,8 15,0"></polyline></svg>
                                '.$separator2.'
                            </div>
                        </div>';
                    break;
                }
            }

            $lay_projectindex .= '</div>';
        }
        // #filter

        $rows = array();
        $query = new WP_Query($query_args);

        // error_log(print_r($query->request, true));

        $current_post_id = false;
        global $post;
        if( is_object($post) ) {
            $current_post_id = $post->ID;
        }

        if ( $query->have_posts() ) {
            // error_log(print_r($query->posts, true));
            foreach ($query->posts as $id) {
                // title
                // categories
                // tags
                // year
                $cat_names = wp_get_post_categories($id, array('fields' => 'names', 'orderby' => 'term_order'));
                $cat_ids = wp_get_post_categories($id, array('fields' => 'ids', 'orderby' => 'term_order'));

                // order tags by user order:
                if ( is_array($config['sortedCategories']) ) {
                    // cats contains all categories of project.
                    // now traverese through user ordered cats to order these project cats and hide/show them based on "visible" value
                    $ordered_result_cats = array();
                    foreach ($config['sortedCategories'] as $ordered_cat) {
                        foreach ($cat_names as $project_cat_name) {
                            $v = $ordered_cat['visible'];
                            if( gettype($v) == 'string' ) {
                                if($ordered_cat['visible'] == 'false'){
                                    $v = false;
                                }
                                else if($ordered_cat['visible'] == 'true'){
                                    $v = true;
                                }
                            }
                            if( $v == true ) {
                                // get cat name by code, in case we switched to a different language or cat name was changed
                                $term = get_term_by('term_id', $ordered_cat['term_id'], 'category');
                                if( $term !== false && trim($term->name) == trim($project_cat_name) ) {
                                    $ordered_result_cats []= $project_cat_name;
                                }
                            }

                        }
                    }
                    $cat_names = $ordered_result_cats;
                } 

                $categoriesSeparator = array_key_exists('categoriesSeparator', $config) ? $config['categoriesSeparator'] : ', ';
                $cats_markup = implode($categoriesSeparator, $cat_names);

                $tags = get_the_tags($id);
                $tagArray = array();
                // order by term order, and fill $tagArray with names of tags
                if ($tags) {
                    // https://stackoverflow.com/questions/2699086/how-to-sort-a-multi-dimensional-array-by-value
                    usort($tags, function($a, $b) {
                        return $a->term_order - $b->term_order;
                    });
                    foreach($tags as $tag) {
                        $tagArray []= $tag->name;
                    }
                }
                // order by user defined order
                if ( is_array($config['sortedTags']) && $tags ) {
                    // $tags contains all tags of project.
                    // now traverese through user ordered tags to order these project tags and hide/show them based on "visible" value
                    $ordered_result_tags = array();
                    foreach ($config['sortedTags'] as $ordered_tag) {
                        foreach ($tagArray as $project_tag_name) {
                            $v = $ordered_tag['visible'];
                            if( gettype($v) == 'string' ) {
                                if($ordered_tag['visible'] == 'false'){
                                    $v = false;
                                }
                                else if($ordered_tag['visible'] == 'true'){
                                    $v = true;
                                }
                            }
                            if( $v == true ) {
                                // get tag name by code, in case we switched to a different language or tag name was changed
                                $term = get_term_by('term_id', $ordered_tag['term_id'], 'post_tag');
                                if( $term !== false && trim($term->name) == trim($project_tag_name) ) {
                                    // get term name by code, this way the name is updated when switching btwn languages or changing term name
                                    $ordered_result_tags []= $project_tag_name;
                                }
                            }
                            
                        }
                    }
                    $tagArray = $ordered_result_tags;
                }
                $tagsSeparator = array_key_exists('tagsSeparator', $config) ? $config['tagsSeparator'] : ', ';
                $tags_markup = implode($tagsSeparator, $tagArray);
                /*
                    'sortedCategories' => false,
                    'sortedTags' => false,
                    'textformat' => 'Default',
                    'spaceTopBottom' => 5,
                    'lineStrokeWidth' => 1,
                    'lineColor' => '#000',
                    'useImageHover' => true
                */

                // put all post related things in an array so we can sort by category or tags
                // without having to get the categories and tags inside the sort function

                $rows []= array(
                    'post_id' => $id,
                    'cat_ids' => $cat_ids,
                    'post_link' => get_permalink($id),
                    'post_name' => get_post_field( 'post_name', $id ),
                    'post_title' => get_the_title( $id ),
                    'post_date' => get_the_date('Y', $id),
                    'cats_markup' => $cats_markup,
                    'tags_markup' => $tags_markup
                );
            }

            // error_log(print_r($rows, true));

            // sort!
            // error_log(print_r($orderby, true));

            ProjectIndex::orderRows($rows, $orderby, $order);
            // iterate
            $ix = 0;
            foreach ($rows as $row) {
                $border_style = 'border-bottom:'.$config['lineStrokeWidth'].'px solid '.$config['lineColor'].';';
                $extraclass = '';
                if( $ix == 0 ) {
                    $extraclass = 'lay-projectindex-first-row';
                    $border_style .= 'border-top:'.$config['lineStrokeWidth'].'px solid '.$config['lineColor'].';';
                }
                // $font_color_css = '';
                // if( trim($config['textColor']) != '' ) {
                //     $font_color_css = 'color:'.$config['textColor'].';';
                // }
                $current_post_class = $current_post_id == $row['post_id'] ? 'lay-project-index-current-project' : '';
                $lay_projectindex .= 
                '<div class="lay-projectindex-row '.$current_post_class.' projectindex-project-slug-'.$row['post_name'].' _'.$config['textformat'].'_no_spaces '.$extraclass.'" style="'.$border_style.' padding-top:'.$config['spaceTopBottom'].'px; padding-bottom:'.$config['spaceTopBottom'].'px;">';
                
                // error_log(print_r($config[$currentLayout]['sortedColumns'], true));
                // $ix2 = 0;
                foreach ($config[$currentLayout]['sortedColumns'] as $column) {
                    // error_log(print_r($column, true));
                    $css = '';
                    if( $column['visible'] === 'false' || $column['visible'] === false ) {
                        $css = 'style="display:none;"';
                    }
                    // if( $ix2 == count($config[$currentLayout]['sortedColumns']) - 1 ) {
                    //     $separator = '';
                    // }
                    switch( $column['name'] ) {
                        case 'year':
                            $lay_projectindex .= 
                            '<div class="lay-projectindex-col-year lay-projectindex-col" data-date="'.get_the_date('Ymd', $row['post_id']).'" '.$css.'>'.$row['post_date'].$separator.'</div>';
                        break;
                        case 'title':
                            $lay_projectindex .= 
                            '<div class="lay-projectindex-col-title lay-projectindex-col" '.$css.'>'.$row['post_title'].$separator.'</div>';
                        break;
                        case 'categories':
                            $lay_projectindex .= 
                            '<div class="lay-projectindex-col-categories lay-projectindex-col" '.$css.'>'.$row['cats_markup'].$separator.'</div>';
                        break;
                        case 'tags':
                            $emptyClass = $row['tags_markup'] == '' ? 'lay-projectindex-col-empty' : ''; 
                            $lay_projectindex .= 
                            '<div class="lay-projectindex-col-tags lay-projectindex-col '.$emptyClass.'" '.$css.'>'.$row['tags_markup'].$separator.'</div>';
                        break;
                    }
                    // $ix2++;
                }
                $imagehover_attr = $config['useImageHover'] == true && is_plugin_active('laytheme-imagehover/laytheme-imagehover.php') ? 'data-hoverimageid="'.get_post_thumbnail_id($row['post_id']).'"' : '';
                $lay_projectindex .= '<a class="projectindex-project-link" href="'.$row['post_link'].'" '.$imagehover_attr.' data-type="project" data-catid="'.LayElFunctions::stringifyCatIds($row['cat_ids']).'" data-id="'.$row['post_id'].'" data-title="'.__($row['post_title']).'"></a>';
                $lay_projectindex .= '</div>';
                $ix++;
            }
        
        }
        $lay_projectindex .= '</div>';

        // error_log(print_r($lay_projectindex, true));

        return $projectindex_css.$lay_projectindex;
    }

}
new ProjectIndex();