<?php
// in case the user creates a custom mobile menu this will be used instead of combining primary menu, secondary menu, third, fourth menu
class LayCustomMobileMenu{

    public function __construct(){
        add_action( 'after_setup_theme', array($this, 'register_custom_mobile_nav') );
        add_filter( 'nav_menu_link_attributes', array($this, 'menu_link_attributes'), 10, 4 );
    }

    // in case the user creates a custom mobile menu this will be used instead of combining primary menu, secondary menu, third, fourth menu
	public static function register_custom_mobile_nav(){
		register_nav_menus(
			array( 'lay_mobile_menu' => 'Mobile Menu' )
		);
	}

    // sets data-* attributes and textformat of the menu links
    public static function menu_link_attributes($atts, $item, $args, $depth){

		// only for laytheme menus. This prevents additional attributes from being added to extra menus. Extra menus could be added with plugin "menu shortcode" for example.       
        switch($args->theme_location){
            case 'lay_mobile_menu':
                break;
            default:
                return $atts;
        }

		$misc_options_force_custom_links_target_blank = get_option('misc_options_force_custom_links_target_blank', 'on');
        // textformat
        
        // for mobile menu, use the 'mobile_menu_textformat' textformat
        // this is because the 4 different desktop menus could all use different textformats, but we want only one textformat in use for all mobile menu points
        if($args->menu_id == 'mobile_menu'){
            $nav_textformat = get_theme_mod('mobile_menu_textformat', 'Default');
        }
		if($nav_textformat != ""){
			$nav_textformat = '_'.$nav_textformat;
			if(array_key_exists('class', $atts)){
				$atts['class'] .= ' '.$nav_textformat;
			}else{
				$atts['class'] = $nav_textformat;
			}
		}

		if($item->object == 'post'){$item->object = 'project';}

		if($item->object == "custom"){
			// frontpage link
			// https://github.com/WordPress/WordPress/blob/5eb5afac3450f2bd02886f5f1f4fe56ed208fd79/wp-admin/includes/nav-menu.php#L786
			if($item->url == home_url('/') || $item->url == '/'){
				$frontpage_type = get_theme_mod('frontpage_type', 'category');
				$item->object = $frontpage_type;
				switch ($frontpage_type){
				    case 'category':
				        $item->object_id = get_theme_mod('frontpage_select_category', 1);
				    break;
				    case 'project':
				        $item->object_id = get_theme_mod('frontpage_select_project');
				    break;
				    case 'page':
				        $item->object_id = get_theme_mod('frontpage_select_page');
				    break;
				}
				$atts['data-type'] = $frontpage_type;
				$atts['data-title'] = "";
				$atts['data-id'] = $item->object_id;
			}
			else{
                $is_language_switch = false;
                foreach( $item->classes as $class ){
                    if($class == 'qtranxs-lang-menu-item'){
                        $is_language_switch = true;
                    }
                }

				$atts['data-type'] = 'custom';
			}
		}else{
			$atts['data-id'] = $item->object_id;
			$atts['data-type'] = $item->object;
			$atts['data-title'] = __($item->title);
		}

		if( $item->object == 'project' ){
		    $cats = get_the_category( $item->object_id );
		    $atts['data-catid'] = $cats[0]->term_id;
		}
		else if( $item->object == 'category' ){
			$atts['data-catid'] = $item->object_id;
		}

		return $atts;
	}

}
new LayCustomMobileMenu();