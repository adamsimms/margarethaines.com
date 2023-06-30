<?php

// todo: textformats for menu attributes

class LayMenuManager{

    public static $menu_instances;
    public static $menu_amount;
    public static $cart_url;

    public function __construct(){
        if( class_exists('WooCommerce') ) {
            LayMenuManager::$cart_url = wc_get_cart_url();
        }
        // get option, how many menus are available?
        $menu_amount = intval(get_option('misc_options_menu_amount', 1));
        if ( $menu_amount == 0 ) {
            $menu_amount = 1;
        }
        LayMenuManager::$menu_amount = $menu_amount;
        LayMenuManager::instantiate_menus();
        add_action( 'after_setup_theme', array($this, 'register_menus') );
        add_filter( 'nav_menu_link_attributes', array($this, 'menu_link_attributes'), 10, 4 );
        add_filter( 'nav_menu_css_class', array($this, 'custom_nav_menu_css_class'), 10, 2 );
    }

    function custom_nav_menu_css_class( $classes, $item ) {
        // add "laycart" class to cart button
        if( class_exists('WooCommerce') ) {
            if( $item->url == LayMenuManager::$cart_url ) {
                if( !in_array('laycart', $classes) ) {
                    array_push( $classes, 'laycart' );
                }
                $count = WC()->cart->get_cart_contents_count();
                if( $count == 0 ) {
                    array_push( $classes, 'laycart-empty' );
                } else {
                    array_push( $classes, 'laycart-not-empty' );
                }
            }
        }
        return $classes;    
    }

    private static function instantiate_menus(){
        // instantiate menus, put them in the $menu_instances_array
        LayMenuManager::$menu_instances = array();

        switch( LayMenuManager::$menu_amount ){
            case 1:
                $primary_menu_instance = new LayMenu(PRIMARY_MENU);
                LayMenuManager::$menu_instances []= $primary_menu_instance;
            break;
            case 2:
                $primary_menu_instance = new LayMenu(PRIMARY_MENU);
                $second_menu_instance = new LayMenu(SECOND_MENU);

                LayMenuManager::$menu_instances []= $primary_menu_instance;
                LayMenuManager::$menu_instances []= $second_menu_instance;
            break;
            case 3:
                $primary_menu_instance = new LayMenu(PRIMARY_MENU);
                $second_menu_instance = new LayMenu(SECOND_MENU);
                $third_menu_instance = new LayMenu(THIRD_MENU);
                
                LayMenuManager::$menu_instances []= $primary_menu_instance;
                LayMenuManager::$menu_instances []= $second_menu_instance;
                LayMenuManager::$menu_instances []= $third_menu_instance;
            break;
            case 4:
                $primary_menu_instance = new LayMenu(PRIMARY_MENU);
                $second_menu_instance = new LayMenu(SECOND_MENU);
                $third_menu_instance = new LayMenu(THIRD_MENU);
                $fourth_menu_instance = new LayMenu(FOURTH_MENU);
                
                LayMenuManager::$menu_instances []= $primary_menu_instance;
                LayMenuManager::$menu_instances []= $second_menu_instance;
                LayMenuManager::$menu_instances []= $third_menu_instance;
                LayMenuManager::$menu_instances []= $fourth_menu_instance;
            break;
        }
    }

    // see if there is content in at least one menu
    public static function at_least_one_menu_is_filled(){
        $a_menu_is_filled = false;

        $locations = get_nav_menu_locations();
        if(count($locations) == 0){
            return false;
        }

        foreach(LayMenuManager::$menu_instances as $menu_instance){
            $menu_id = $locations[$menu_instance->menu_type];
            $menu_object = wp_get_nav_menu_object($menu_id);

            if($menu_object != false){
                if($menu_object->count > 0){
                    $a_menu_is_filled = true;
                }
            }
        }
        // mobile menu
        if( array_key_exists(MOBILE_MENU, $locations) ){
            $menu_id = $locations[MOBILE_MENU];
            $menu_object = wp_get_nav_menu_object($menu_id);
            if($menu_object != false){
                if($menu_object->count > 0){
                    $a_menu_is_filled = true;
                }
            }
        }

        return $a_menu_is_filled;
    }

    // register_nav_menus
    public static function register_menus(){
        $menus = array();

        for($i=0; $i<LayMenuManager::$menu_amount; $i++){
            $description = '';
            $location = '';
            switch($i){
                case 0:
                    $description = PRIMARY_MENU_DESCRIPTION;
                    $location = PRIMARY_MENU;
                break;
                case 1:
                    $description = SECOND_MENU_DESCRIPTION;
                    $location = SECOND_MENU;
                break;
                case 2:
                    $description = THIRD_MENU_DESCRIPTION;
                    $location = THIRD_MENU;
                break;
                case 3:
                    $description = FOURTH_MENU_DESCRIPTION;
                    $location = FOURTH_MENU;
                break;
            }
            $menus[$location] = $description; 
        }

        register_nav_menus($menus);
    }

    // this gets the menu markup of all menus available
    public static function get_menu_markup(){
        $menus_markup = '';

        foreach(LayMenuManager::$menu_instances as $menu_instance){
            $menus_markup .= $menu_instance->get_markup();
        }

		return $menus_markup;
    }

    public static function get_mobile_menu(){
        // traverse through all $menu_instances and get their menu 
        $mobile_menu_style = get_theme_mod('mobile_menu_style', 'style_1');
        $mobile_menu_additional_css_classes = '';
        if ( $mobile_menu_style == 'style_desktop_menu' ) {
            $mobile_menu_additional_css_classes = 'arrangement-'.get_theme_mod('mobile_menu_arrangement', 'horizontal');
        }
        $nav_menu_markup = 
        '<nav class="laynav mobile-nav mobile-menu-style-'.$mobile_menu_style.' '.$mobile_menu_additional_css_classes.'">';
        switch( $mobile_menu_style ){
            case 'style_1':
            break;
            case 'style_2':
                $burger_icon_type = get_theme_mod('burger_icon_type', 'default_thin');
                $customCloseImg = get_theme_mod('mobile_menu_icon_close', '');
                if( $burger_icon_type == 'custom' && $customCloseImg != '' ){
                    $nav_menu_markup .= 
                    '<div class="burger-wrap burger-custom-wrap-close">
                        <div class="burger-inner">
                            <img src="'.$customCloseImg.'" class="mobile-menu-close-custom mobile-menu-icon">
                        </div>
                    </div>';
                }
                if( $burger_icon_type == "default" || $burger_icon_type == "default_thin" ){
                    $nav_menu_markup .= 
                    '<div class="burger-wrap burger-wrap-default burger-no-animation '.$burger_icon_type.'">
                        <div class="burger-inner">
                            <button class="burger burger-default mobile-menu-icon active">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>';
                }
                if( $burger_icon_type == 'new' ){
                    $nav_menu_markup .= 
                    '<div class="burger-wrap burger-wrap-new burger-no-animation">
                        <div class="burger-inner">
                            <div class="burger burger-new mobile-menu-icon active">
                                <span class="bread-top">
                                    <span class="bread-crust-top"></span>
                                </span>
                                <span class="bread-bottom">
                                    <span class="bread-crust-bottom"></span>
                                </span>
                            </div>
                        </div>
                    </div>';
                }
            break;
        }
        $nav_menu_markup .= 
            '<ul>';
            // in case the user creates a custom mobile menu this will be used instead of combining primary menu, secondary menu, third, fourth menu
            if( has_nav_menu('lay_mobile_menu') ){
                $args = array(
                    'theme_location'  => 'lay_mobile_menu',
                    'echo'            => false,
                    'depth'           => 0,
                    'container'		  => false,
                    'items_wrap'      => '%3$s',
                    'link_before'	  => '<span>',
                    'link_after'	  => '</span>',
                    // using menu_id so in menu_link_attributes function i can use a different textformat for the mobile menu
                    'menu_id'         => 'mobile_menu'
                );
                $nav_menu_markup .= wp_nav_menu( $args );
            }else{
                foreach(LayMenuManager::$menu_instances as $menu_instance){
                    $nav_menu_markup .= $menu_instance->get_mobile_menu_lis();
                }
            }
        $nav_menu_markup .= 
            '</ul>
        </nav>';
		return $nav_menu_markup;
    }

    public static function get_suffix_based_on_identifier($location){
        switch($location){
            case PRIMARY_MENU:
                return '';
            break;
            case SECOND_MENU:
                return '_'.SECOND_MENU;
            break;
            case THIRD_MENU:
                return '_'.THIRD_MENU;
            break;
            case FOURTH_MENU:
                return '_'.FOURTH_MENU;
            break;
            default: 
                return '';
            break;
        }        
    }

    public static function get_description_by_location($location){
        switch($location){
            case PRIMARY_MENU:
                return PRIMARY_MENU_DESCRIPTION;
            break;
            case SECOND_MENU:
                return SECOND_MENU_DESCRIPTION;
            break;
            case THIRD_MENU:
                return THIRD_MENU_DESCRIPTION;
            break;
            case FOURTH_MENU:
                return FOURTH_MENU_DESCRIPTION;
            break;
        }
    }

    // sets data-* attributes and textformat of the menu links
    public static function menu_link_attributes($atts, $item, $args, $depth){

		// only for laytheme menus. This prevents additional attributes from being added to extra menus. Extra menus could be added with plugin "menu shortcode" for example.       
        switch($args->theme_location){
            case PRIMARY_MENU:
            case SECOND_MENU:
            case THIRD_MENU:
            case FOURTH_MENU:
            case 'lay_mobile_menu':
                break;
            default:
                return $atts;
        }

		$misc_options_force_custom_links_target_blank = get_option('misc_options_force_custom_links_target_blank', 'on');
        // textformat
        
        // get suffix
        $suffix = '';
        switch($args->theme_location){
            case PRIMARY_MENU:
                break;
            case SECOND_MENU:
                $suffix = '_'.SECOND_MENU;
                break;
            case THIRD_MENU:
                $suffix = '_'.THIRD_MENU;
                break;
            case FOURTH_MENU:
                $suffix = '_'.FOURTH_MENU;
                break;
            default:
                return $atts;
        }
        $nav_textformat = get_theme_mod('nav_textformat'.$suffix, 'Default');
        $submenu_textformat = get_theme_mod('menu_submenu_textformat', $nav_textformat);
        // for mobile menu, use the 'mobile_menu_textformat' textformat
        // this is because the 4 different desktop menus could all use different textformats, but we want only one textformat in use for all mobile menu points
        
        // error_log(print_r($item, true));
        // error_log(print_r($atts, true));
        // error_log(print_r($depth, true));
        // error_log(print_r(" ", true));

        if($args->menu_id == 'mobile_menu'){
            $nav_textformat = get_theme_mod('mobile_menu_textformat', 'Default');
        }
		if($nav_textformat != "" && $depth == 0){
			$nav_textformat = '_'.$nav_textformat;
			if(array_key_exists('class', $atts)){
				$atts['class'] .= ' '.$nav_textformat;
			}else{
				$atts['class'] = $nav_textformat;
			}
        }
        // submenu
        if( $depth > 0 ) {
            $submenu_textformat = '_'.$submenu_textformat;
			if(array_key_exists('class', $atts)){
				$atts['class'] .= ' '.$submenu_textformat;
			}else{
				$atts['class'] = $submenu_textformat;
			}
        }
        
        // WooCommerce Cart
        // the user needs to add the class "laycart" to the menupoint "Cart"
        // now, the cart menu point will open the sidebar cart if the plugin is installed and
        // will have a (2) suffix where 2 is the number of items in the cart.
        // error_log(print_r($atts, true));
        // error_log(print_r($item, true));

        if( class_exists('WooCommerce') ) {
            if( $item->url == LayMenuManager::$cart_url ) {
                // sidebar plugin is installed? use its function xoo_wsc_cart
                if( function_exists('xoo_wsc_cart') ) {
                    $cart_count = xoo_wsc_cart()->get_cart_count();
                    $item->title .= ' ('.$cart_count.')';
                    // add cart class
                    $item->classes []= 'xoo-wsc-basket';
                } else if ( is_object( WC()->cart ) ) {
                    // todo: does this make sense?
                    $cart_count = WC()->cart->get_cart_contents_count();
                    $item->title .= ' (<span class="laycart-button-count">'.$cart_count.'</span>)';
                }
                // error_log(print_r($item, true));
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
			$atts['data-title'] = $item->title;
		}

		if( $item->object == 'project' ){
            $cats = get_the_category( $item->object_id );
            $catids = array();
            foreach( $cats as $cat ) {
                $catids []= $cat->term_id;
            }
            $atts['data-catid'] = json_encode($catids);
		}
		else if( $item->object == 'category' ){
			$atts['data-catid'] = $item->object_id;
		}

        if ( class_exists( 'WooCommerce' ) ){
            // https://gist.github.com/Bradley-D/7287723

            // the shop page is of type archive. however, the menu point says it is of type page, so here we just make it a archive page manually
            // need to do this because the data-type of the body tag needs to match the data-type of the shop-page menu item so the menu item will
            // get the correct "current-menu-item" class via javascript
            if( $item->object_id == get_option( 'woocommerce_shop_page_id' ) ) {
                $atts['data-type'] = 'archive';
            }
        }


		return $atts;
	}

}
new LayMenuManager();