<?php

// a LayMenu Instance creates:
// css output
// customizer options
// customize and css defaults
// html markup
// menu fallback

// todo: hideburger in get_header() in frontend.php: $hideburger = $primary == "" ? true : false;

class LayMenu{

    public $menu_type;

    public function __construct($menu_type){
        $this->menu_type = $menu_type;
    }

    public function get_mobile_menu_lis(){
        $menu_type = $this->menu_type;
        $args = array(
            'theme_location'  => $menu_type,
            'echo'            => false,
            'depth'           => 0,
            'container'		  => false,
            'items_wrap'      => '%3$s',
            'link_before'	  => '<span>',
            'link_after'	  => '</span>',
            // using menu_id so in menu_link_attributes function i can use a different textformat for the mobile menu
            'menu_id'         => 'mobile_menu',
        );
        return wp_nav_menu( $args );   
    }

    public function get_markup(){
        $menu_type = $this->menu_type;
        $args = array(
            'theme_location'  => $menu_type,
            'echo'            => false,
            'depth'           => 0,
            'container'		  => false,
            'items_wrap'      => '%3$s',
            'link_before'	  => '<span>',
            'link_after'	  => '</span>',
            'fallback_cb'     => $this->menu_fallback(),
            'menu_id'         => 'desktop_menu'
        );
        $menu = wp_nav_menu( $args );

        // for woocommerce sticky position when using a store notice

        // for primary menu, suffix is empty string "" (for backwards compatibility)
        // other suffixes are: '_'.$menu_type
        $suffix = '_'.$menu_type;
        if( $menu_type == PRIMARY_MENU ){
            $suffix = '';
        }
        $position = get_theme_mod('nav_position'.$suffix, 'top-right');

        $position_class = strpos($position, 'top') !== false ? 'position-top' : 'position-not-top';

        $isfixed = get_theme_mod('nav_isfixed'.$suffix, '1');
        $isfixed_class = $isfixed == '1' ? 'is-fixed' : 'is-not-fixed';
        
        $arrangement_class = get_theme_mod('nav_arrangement'.$suffix, 'horizontal');

        $menu_submenu_type = get_theme_mod('menu_submenu_type', 'vertical');
        $menu_submenu_show_on = get_theme_mod('menu_submenu_show_on', 'hover');

        return
        '<nav class="laynav desktop-nav show-submenu-on-'.$menu_submenu_show_on.' submenu-type-'.$menu_submenu_type.' laynav-position-'.$position.' arrangement-'.$arrangement_class.' '.$position_class.' '.$isfixed_class.' '.$menu_type.'">
            <ul>
                '.$menu.'
            </ul>
        </nav>';
    }

    public function menu_fallback(){
		if ( ! current_user_can( 'manage_options' ) ){
	        return;
	    }
	    if ( !has_nav_menu( $this->menu_type ) ) {
            $description = LayMenuManager::get_description_by_location($this->menu_type);

            if( $this->menu_type == 'primary' ){
                echo
                '<div style="font-family: helvetica,arial,sans-serif; font-weight: lighter; line-height: 1.2; width: 650px; margin: 90px 10px 10px 10px; padding: 20px; background-color: #cafcfc; border: 2px solid #acf9f9; border-radius: 4px; display: block;">
                    <h2 style="margin: 10px 0 30px 0; font-weight:bold; font-size: 20px; text-align: left;">Please create a "'.$description.'" in the admin panel.</h2>
                    <strong>Step 1:</strong> Go to "Appearance" &#8594; "Menus" or <a style="color:blue;" target="_blank" href="'.admin_url( 'nav-menus.php' ).'">click here</a>.<br>
                    Then create a menu by clicking on "Create Menu":<br>
                    <img style="width:100%; box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.5); margin-top:10px; margin-bottom:30px; border-radius: 4px;" src="'.get_template_directory_uri().'/menu/img/create_menu.jpg" alt="">
                    <br><strong>Step 2:</strong> Check "'.$description.'" under "Display location" and click "Save Menu".
                    <br><img style="width:100%; box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.5); margin-top:10px; border-radius: 4px;" src="'.get_template_directory_uri().'/menu/img/primary.jpg" alt="">
                </div>';
            }else{
                echo
                '<div style="font-family: helvetica,arial,sans-serif; font-weight: lighter; line-height: 1.2; width: 650px; margin: 90px 10px 10px 10px; padding: 20px; background-color: #cafcfc; border: 2px solid #acf9f9; border-radius: 4px; display: block;">
                    <h2 style="margin: 10px 0 30px 0; font-weight:bold; font-size: 20px; text-align: left;">Please create a "'.$description.'" in the admin panel.</h2>
                    Go to "Appearance" &rarr; "Menus" &rarr; "Manage Locations".<br>
                    Create a menu and assign it to "'.$description.'".
                    <br><img style="width:100%; box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.5); margin-top:10px; border-radius: 4px;" src="'.get_template_directory_uri().'/menu/img/manage_locations_'.$this->menu_type.'.jpg" alt="">
                </div>';
            }
		}

	}

}