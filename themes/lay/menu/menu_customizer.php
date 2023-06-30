<?php 

// todo: use desktop menu as mobile menu, make this option global
// todo: CSS_Output::generate_hide_css('nav.'.$this->menu_type, 'hide_primary_menu');
// todo: see if textformat is in use for menus

// todo frontend passed data 'nav_hide' => $nav_hide,

/* 
Customizer:

Menu Style
    - Menu Style (Primary Menu)
        - Controls
    - Menu Style (Second Menu)
        - Controls
    - Menu Bar (Section)
        - Controls
    - Menu Point Mouseover (Section)
        - Controls
    - Menu Point Active (Section)
        - Controls
*/

// this class creates the "menu" customizer options that are individual for each menu
// and it generates the css output
class LayMenuCustomizer{

    public $menu_type;
    public $customizer_panel_name;
    public $suffix;
    public $menu_amount;

    public function __construct($menu_type){
        $this->menu_type = $menu_type;

        $menu_amount = intval(get_option('misc_options_menu_amount', 1));
        if ( $menu_amount == 0 ) {
            $menu_amount = 1;
        }

        $this->menu_amount = $menu_amount;
        $this->customizer_panel_name = 'navigation_panel_'.$menu_type;
        if( $menu_type == PRIMARY_MENU  ){
            $this->customizer_panel_name = 'navigation_panel';
        }

        // for primary menu, suffix is empty string "" (for backwards compatibility)
        // other suffixes are: '_'.$menu_type
        $this->suffix = '_'.$menu_type;
        if( $menu_type == PRIMARY_MENU ){
            $this->suffix = '';
        }

        add_action( 'customize_register', array($this, 'register_panel'), 10 );
        add_action( 'customize_register', array($this, 'add_menu_section'), 10 );
    }

    public function register_panel($wp_customize){
        $title = LayMenuManager::get_description_by_location($this->menu_type);
        $wp_customize->add_panel( $this->customizer_panel_name, array(
            'priority'       => 5,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => 'Menu Style ('.$title.')'
        ) );
    }

    // menu styles
    public function add_menu_section($wp_customize){
        include get_template_directory().'/menu/customizer_sections/menu_section.php';
    }

    public function is_menu_hidden(){
        return get_theme_mod('hide_'.$this->menu_type.'_menu') == 1 ? false : true;
    }
    
    public function show_nav_hidewhenscrolling_show_on_mouseover(){
        $hidden = get_theme_mod('hide_'.$this->menu_type.'_menu') == 1 ? true : false;
        if($hidden){
            return false;
        }
        return get_theme_mod('nav_hidewhenscrolling'.$this->suffix) == 1 ? true : false;
    }

    public function get_css(&$desktopAndTabletStyles, &$mobileStyles, &$menuStyles, &$sharedStyles, $use_desktop_menu_as_mobile_menu){
        $desktopAndTabletStyles .= CSS_Output::generate_hide_css('nav.'.$this->menu_type, 'hide_'.$this->menu_type.'_menu', true);

		/* if a textformat was chosen for the menu, we are using the textformat's html class for the dom element to
		have a style applied and to make the possible tablet font-size work. In this case we don't need menu styles created with the customize controls
		*/
        $nav_textformat = get_theme_mod('nav_textformat'.$this->suffix, 'Default');
		if($nav_textformat == ""){
			// no textformat chosen, so we need to create menustyles based on individual controls
	        $menuStyles .= CSS_Output::generate_css('nav.'.$this->menu_type.' a', 'color', 'nav_color'.$this->suffix, Customizer::$defaults['color']);
	        $sharedStyles .= CSS_Output::generate_css('nav.'.$this->menu_type, 'font-family', 'nav_fontfamily'.$this->suffix, Customizer::$defaults['fontfamily']);
	        $sharedStyles .= CSS_Output::generate_css('nav.'.$this->menu_type, 'font-weight', 'nav_fontweight'.$this->suffix, Customizer::$defaults['fontweight'],'', '');

	        $nav_fontsize_mu = CSS_Output::get_mu('nav_fontsize_mu', 'px');
	        // there is an extra setting for mobile menu, so not using $menuStyles here
	        $desktopAndTabletStyles .= CSS_Output::generate_css('nav.'.$this->menu_type.' li', 'font-size', 'nav_fontsize'.$this->suffix, Customizer::$defaults['fontsize'],'', $nav_fontsize_mu);
			$sharedStyles .= CSS_Output::generate_css('nav.'.$this->menu_type.' a', 'letter-spacing', 'nav_letterspacing'.$this->suffix, Customizer::$defaults['letterspacing'], '', 'em');
			// textalign is only important here if menu points arrangement is "horizontal"
            $menuStyles .= CSS_Output::generate_css('nav.'.$this->menu_type, 'text-align', 'nav_textalign'.$this->suffix, 'left', '', '');
		}

        $spaceleft_mu = CSS_Output::get_mu('nav_spaceleft_mu'.$this->suffix, '%');
        $desktopAndTabletStyles .= CSS_Output::generate_css('nav.'.$this->menu_type, 'left', 'nav_spaceleft'.$this->suffix, '5', '', $spaceleft_mu);

        $spaceright_mu = CSS_Output::get_mu('nav_spaceright_mu'.$this->suffix, '%');
        $desktopAndTabletStyles .= CSS_Output::generate_css('nav.'.$this->menu_type, 'right', 'nav_spaceright'.$this->suffix, '5', '', $spaceright_mu);

        $spacebottom_mu = CSS_Output::get_mu('nav_spacebottom_mu'.$this->suffix, 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('nav.'.$this->menu_type, 'bottom', 'nav_spacebottom'.$this->suffix, '16', '', $spacebottom_mu);
        
                                                                                        // $selector, $mod_name, $default, $prefix='', $postfix='', $arrangement_mod_name
        $desktopAndTabletStyles .= CSS_Output::nav_generate_menupoints_spacebetween_css('nav.'.$this->menu_type.' li', 'nav_spacebetween'.$this->suffix, '20', '', 'px', 'nav_arrangement'.$this->suffix);
        
        // submenu margin-bottom/padding:
        // for submenus that are vertical in a vertical menu, i want the vertical space around it to be the same as the space between menu points
        // i use the setting for submenu spacearound only for the horizontal space, not the vertical one, cause it looks better
        // $arrangement = get_theme_mod('nav_arrangement'.$this->suffix, 'horizontal');
        // if( $arrangement == 'vertical' ) {
        //     $desktopAndTabletStyles .= 'nav.'.$this->menu_type.' .sub-menu { margin-top:'.get_theme_mod('nav_spacebetween'.$this->suffix, '20').'px; }';
        //     $desktopAndTabletStyles .= 'nav.'.$this->menu_type.' li.menu-item-has-children { padding-bottom:'.get_theme_mod('nav_spacebetween'.$this->suffix, '20').'px; }';
        // }

        $menuStyles .= CSS_Output::generate_is_fixed_css('nav.'.$this->menu_type, 'nav_isfixed'.$this->suffix);
        $menuStyles .= CSS_Output::generate_opacity_css('nav.'.$this->menu_type.' a', 'nav_opacity'.$this->suffix, 100);
        $menuStyles .= CSS_Output::nav_generate_menupoints_arrangement('nav.laynav.'.$this->menu_type.' li', 'nav_arrangement'.$this->suffix);

        $spacetop_mu = CSS_Output::get_mu('nav_spacetop_mu'.$this->suffix, 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('nav.'.$this->menu_type, 'top', 'nav_spacetop'.$this->suffix, '16', '', $spacetop_mu);
        
        // !woocommerce! sticky top nav! needs same margin-top as top value, this way sticky will work properly
        // $desktopAndTabletStyles .= CSS_Output::generate_css('body.lay-woocommerce-show-store-notice nav.'.$this->menu_type.'.position-top', 'margin-top', 'nav_spacetop'.$this->suffix, '16', '', $spacetop_mu);

        $desktopAndTabletStyles .= CSS_Output::generate_position_css('nav.'.$this->menu_type, 'nav_position'.$this->suffix, 'top-right');
        
        $strokewidth = get_theme_mod('nav_underline_strokewidth'.$this->suffix, 0);

        if( intval($strokewidth) > 0 ) {
            $desktopAndTabletStyles .= 'nav.'.$this->menu_type.' a span{ 
                text-decoration-thickness:'.$strokewidth.'px;
                text-decoration-style: solid;
                text-decoration-line: underline;
             }';
        }

        // $menuStyles .= CSS_Output::generate_css('nav.'.$this->menu_type.' a span', 'border-bottom-width', 'nav_underline_strokewidth'.$this->suffix, 0,'', 'px');
    }

}