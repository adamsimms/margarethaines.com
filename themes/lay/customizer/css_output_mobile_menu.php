<?php
class CSS_Output_Mobile_Menu{

    public function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'lay_customize_css' ), 20 );
    }

    // when using style_2 or style_3, the menu div must always be fixed
    // the burger icon and menubar can be position absolute / not fixed
    public static function get_mobile_menu_isfixed(){
        $menu_style = get_theme_mod('mobile_menu_style', 'style_1');
        if( $menu_style == 'style_2' || $menu_style == 'style_3' ) {
           return '1';
        } else {
            return get_theme_mod('mobile_menu_isfixed', '1');
        }
    }

    public static function generate_is_fixed_css($selector, $is_fixed){
        $return = $selector;

        if($is_fixed == '1'){
            $return .= '{position: fixed;}';
        }
        else{
            $return .= '{position: absolute;}';
        }
        return $return;

    }

    public static function lay_customize_css(){
        $mobile_menu_style = get_theme_mod('mobile_menu_style', 'style_1');
        $mobileStyles = "";

        switch( $mobile_menu_style ) {
            case 'style_1':
            break;
            case 'style_2':
            case 'style_3':
                $spacetop_mu = CSS_Output::get_mu('mobile_menu_spacetop_mu', 'px');
                $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav>ul', 'padding-top', 'mobile_menu_spacetop', '12', '', $spacetop_mu);
            break;            
            case 'style_desktop_menu':
            break;
        }

        // mobile menu
        $txtColor = Customizer::$defaults['mobile_menu_txt_color'];
        $lighterBgColor = Customizer::$defaults['mobile_menu_light_color'];
        $darker = Customizer::$defaults['mobile_menu_dark_color'];

        $mobileStyles .= CSS_Output::generate_hide_mobile_menu();

        if(get_theme_mod('mobile_menu_style', 'style_1') == 'style_desktop_menu'){

            $spacetop_mu = CSS_Output::get_mu('mobile_menu_spacetop_mu', 'px');
            $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav', 'top', 'mobile_menu_spacetop', '12', '', $spacetop_mu);

            switch(get_theme_mod('mobile_menu_position', 'right')){
                case 'left':
                    $spaceleft_mu = CSS_Output::get_mu('mobile_menu_spaceleft_mu', '%');
                    $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav', 'left', 'mobile_menu_spaceleft', '5', '', $spaceleft_mu);
                break;
                case 'right':
                    $spaceright_mu = CSS_Output::get_mu('mobile_menu_spaceright_mu', '%');
                    $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav', 'right', 'mobile_menu_spaceright', '5', '', $spaceright_mu);
                break;
                case 'center':
                    $mobileStyles .=
                    'nav.mobile-nav{right: auto; left: 50%;
                    -webkit-transform: translateX(-50%);
                    -moz-transform: translateX(-50%);
                    -ms-transform: translateX(-50%);
                    -o-transform: translateX(-50%);
                    transform: translateX(-50%);}';
                break;
            }

            $mobileStyles .= CSS_Output::nav_generate_menupoints_arrangement('nav.mobile-nav li', 'mobile_menu_arrangement');
            // $selector, $mod_name, $default, $prefix='', $postfix='', $arrangement_mod_name
            $mobileStyles .= CSS_Output::nav_generate_menupoints_spacebetween_css('nav.mobile-nav li', 'mobile_menu_spacebetween', '5', '', 'px', 'mobile_menu_arrangement');
            if( get_theme_mod('mobile_menu_arrangement', 'horizontal') == 'vertical' ) {
                $val = get_theme_mod('mobile_menu_spacebetween', '5');
                $mobileStyles .= '.laynav.mobile-nav.mobile-menu-style-style_desktop_menu.arrangement-vertical .sub-menu{
                    margin-top: '.$val.'px;
                }';
            }
        }

        // todo: test this:
        // mobile menu fixed?
        // when using style 2 or 3, the actual menu must always be fixed, the menubar and menuicons can ne absolute/not fixed
        $menu_div_fixed = CSS_Output_Mobile_Menu::get_mobile_menu_isfixed();
        $mobileStyles .= CSS_Output_Mobile_Menu::generate_is_fixed_css('nav.mobile-nav', $menu_div_fixed);
        // todo: test this with .lay-mobile-icons-wrap
        $mobileStyles .= CSS_Output::generate_is_fixed_css('.navbar, .lay-mobile-icons-wrap', 'mobile_menu_isfixed');


        // mobile site title

        // mobile site title hide, not using "generate_hide_css" here because shown state is display flex, not display block
        $default = get_theme_mod('st_hide', 0);
        $m_st_hide = get_theme_mod('m_st_hide', $default);
        if($m_st_hide == "1"){
            $mobileStyles .= ".mobile-title.text, .mobile-title.image{display:none;}";
        }

        $mobileStyles .= CSS_Output::generate_css('.mobile-title.image img', 'height', 'm_st_img_height', 30, '', 'px');

        $default = get_theme_mod('st_fontfamily', Customizer::$defaults['fontfamily']);
        $mobileStyles .= CSS_Output::generate_css('.mobile-title.text', 'font-family', 'm_st_fontfamily', $default, '', '');

        $m_st_fontsize_mu = CSS_Output::get_mu('m_st_fontsize_mu', 'px');
        $mobileStyles .= CSS_Output::generate_css('.mobile-title.text', 'font-size', 'mobile_menu_sitetitle_fontsize', Customizer::$defaults['mobile_menu_fontsize'], '', $m_st_fontsize_mu);

        $default = get_theme_mod('st_fontweight', Customizer::$defaults['fontweight']);
        $mobileStyles .= CSS_Output::generate_css('.mobile-title.text', 'font-weight', 'm_st_fontweight', $default, '', '');

        $default = get_theme_mod('st_color', Customizer::$defaults['color']);
        $mobileStyles .= CSS_Output::generate_css('.mobile-title.text', 'color', 'm_st_color', $default, '', '');

        $default = get_theme_mod('st_letterspacing' , Customizer::$defaults['letterspacing']);
        $mobileStyles .= CSS_Output::generate_css('.mobile-title.text', 'letter-spacing', 'm_st_letterspacing', $default, '', 'em');

        // mobile site title position
        $m_st_position = get_theme_mod('m_st_position', 'center');
        $mobile_hide_menu = get_theme_mod('mobile_hide_menu', 0);

        $m_st_isfixed = get_theme_mod('m_st_isfixed', 1);
        if($m_st_isfixed == "0"){
            $mobileStyles .= '.mobile-title{position:absolute;}';
        }else{
            $mobileStyles .= '.mobile-title{position:fixed;}';
        }

        if($m_st_position == "center"){
            // use top space
            $m_st_spacetop_mu = CSS_Output::get_mu('m_st_spacetop_mu', 'px');
            $mobileStyles .= CSS_Output::generate_css('.mobile-title', 'top', 'm_st_spacetop', 12, '', $m_st_spacetop_mu);
            $mobileStyles .= '.mobile-title{width: 100%}';
        }else if($m_st_position == "left"){
            // use top space and left space
            $m_st_spacetop_mu = CSS_Output::get_mu('m_st_spacetop_mu', 'px');
            $mobileStyles .= CSS_Output::generate_css('.mobile-title', 'top', 'm_st_spacetop', 12, '', $m_st_spacetop_mu);
            $m_st_spaceleft_mu = CSS_Output::get_mu('m_st_spaceleft_mu', '%');
            $mobileStyles .= CSS_Output::generate_css('.mobile-title', 'left', 'm_st_spaceleft', 5,'', $m_st_spaceleft_mu);
        }else if($m_st_position == "right"){
            $m_st_spacetop_mu = CSS_Output::get_mu('m_st_spacetop_mu', 'px');
            $mobileStyles .= CSS_Output::generate_css('.mobile-title', 'top', 'm_st_spacetop', 12, '', $m_st_spacetop_mu);
            $m_st_spaceright_mu = CSS_Output::get_mu('m_st_spaceright_mu', '%');
            $mobileStyles .= CSS_Output::generate_css('.mobile-title', 'right', 'm_st_spaceright', 5,'', $m_st_spaceright_mu);
        }

        // mobile site title position

        $m_st_position = get_theme_mod('m_st_position', 'center');
        if($m_st_position == "center"){
            $mobileStyles .=
            '.navbar{
                text-align: center;
            }
            .mobile-title{
                text-align:center; padding: 0 44px;
            }
            .mobile-title.text > span{
                margin: 0 auto;
            }';
        }else if($m_st_position == "left"){
            $mobileStyles .=
            '.navbar{
                text-align: left;
            }
            .mobile-title{
                text-align:left; padding: 0 44px 0 0;
            }';
        }

        // mobile navbar background color with rgba
        $mobile_menubar_height = 0;
        $mobile_hide_menubar = get_theme_mod('mobile_hide_menubar');
        // error_log(print_r($mobile_hide_menubar, true));
        if($mobile_hide_menubar == 1){
            // error_log(print_r('mobile_hide_menubar', true));
            $mobileStyles .= '.navbar{display:none;}';
            $mobileStyles .= '.lay-mobile-icons-wrap{padding-top:'.get_theme_mod('mobile_menu_icon_burger_spacetop', '10').'px;}';
            $mobileStyles .= '.lay-mobile-icons-wrap{padding-right:'.get_theme_mod('mobile_menu_icon_burger_spaceright', '10').'px;}';

            $sr = get_theme_mod('mobile_menu_icon_burger_spaceright', '10');
            $sr = (int)$sr;

            $mobileStyles .= '.laynav .burger-wrap{padding-right:'.($sr - 3).'px;}';
            $mobileStyles .= '.laynav .burger-wrap{padding-top:'.get_theme_mod('mobile_menu_icon_burger_spacetop', '10').'px;}';
        }else{
            $mobile_menubar_height = get_theme_mod('mobile_menubar_height', 40);
            // burger top position
            switch( get_theme_mod('burger_icon_type', 'default_thin') ){
                case 'default':
                case 'default_thin':
                    if( $mobile_menubar_height > 20 ){
                        $mobileStyles .= '.burger-wrap{padding-top:'.(($mobile_menubar_height-20)/2).'px;}';
                        $mobileStyles .= '.lay-mobile-icons-wrap{padding-right:'.(($mobile_menubar_height-20)/2).'px;}';
                        $mobileStyles .= '.laynav .burger-wrap{padding-right:'.((($mobile_menubar_height-20)/2) - 3).'px;}';
                    }
                break;
                case 'new':
                    if( $mobile_menubar_height > 20 ){
                        $mobileStyles .= '.burger-wrap{padding-top:'.(($mobile_menubar_height-30)/2).'px;}';
                        $mobileStyles .= '.lay-mobile-icons-wrap{padding-right:'.(($mobile_menubar_height-30)/2).'px;}';
                        $mobileStyles .= '.laynav .burger-wrap{padding-right:'.((($mobile_menubar_height-30)/2) - 3).'px;}';

                    }
                break;
            }
            // woocommerce cart icon height. attention: current cart icon is 20px tall. if i use a different icon height, i need to change that number below
            if( $mobile_menubar_height > 20 ){
                $offset = -2;
                $mobileStyles .= '.lay-cart-icon-wrap{padding-top:'.( ( ($mobile_menubar_height-20) / 2 ) + $offset ) .'px;}';
                $mobileStyles .= '.lay-cart-icon-wrap{padding-left:'.(($mobile_menubar_height-20)/2).'px;}';
                $mobileStyles .= '.lay-cart-icon-wrap{height:'.($mobile_menubar_height - $offset).'px;}';
            }

            $mobileStyles .= '.burger-wrap{height:'.$mobile_menubar_height.'px;}';
        }

        // custom top position burger icon

        if( get_theme_mod('mobile_hide_menubar') == 1 || get_theme_mod('burger_icon_type', 'default_thin') == 'custom' ) {
            $mobileStyles .= '.lay-mobile-icons-wrap{padding-top:'.get_theme_mod('mobile_menu_icon_burger_spacetop', '10').'px;}';
            $mobileStyles .= '.lay-mobile-icons-wrap{padding-right:'.get_theme_mod('mobile_menu_icon_burger_spaceright', '10').'px;}';
        }


        $mobileStyles .= '.burger-custom{width:'.get_theme_mod('mobile_menu_icon_burger_width', '25').'px;}';
        $mobileStyles .= '.mobile-menu-close-custom{width:'.get_theme_mod('mobile_menu_icon_close_width', '25').'px;}';

        // body padding top
        $mobile_hide_menu = get_theme_mod('mobile_hide_menu', 0);
        $mobile_hide_menubar = get_theme_mod('mobile_hide_menubar', 0);
        // note to myself: cannot do body padding-top here, when we use a store notification

        if($mobile_hide_menu != '1' && $mobile_hide_menubar != '1'){
            $mobileStyles .= 'body{padding-top:'.$mobile_menubar_height.'px;}';
            // for phone cover, i need to set a margin-top for the inner row, because top aligned texts in a 100vh row are "position absolute"
            // and i dont want those texts to be underneath the navbar:
            $mobileStyles .= '.cover-enabled-on-phone .cover-region{top:'.$mobile_menubar_height.'px;}';
            // also, i need to set a height that is calc(100vh - navbarheight):
            $mobileStyles .= CSS_Output_First_Row_100vh_Heights::get_first_row_100vh_heights();
        }

        $mobileStyles .= CSS_Output::generate_css('.navbar', 'height', 'mobile_menubar_height', 40, '', 'px');

        $mobile_menu_bar_background_color = get_theme_mod('mobile_menu_bar_color', $lighterBgColor);
        $rgb = CSS_Output::hex2rgb($mobile_menu_bar_background_color);
        $alpha = (int)get_theme_mod('mobile_menu_bar_opacity', 100);
        $alpha /= 100;
        if($alpha < 0){ $alpha = 0; }
        else if($alpha > 1){ $alpha = 1; }
        $mobileStyles .= '.navbar{background-color:rgba('.$rgb['red'].','.$rgb['green'].','.$rgb['blue'].','.$alpha.')}';

        $mobile_menu_bar_blurry = get_theme_mod('mobile_menu_bar_blurry', '');
        if( $mobile_menu_bar_blurry == '1' ) {
            $blur = get_theme_mod('mobile_menu_bar_blur_amount', 20);
            $mobileStyles .= 
            '.navbar{
                -webkit-backdrop-filter: saturate(180%) blur('.$blur.'px);
                backdrop-filter: saturate(180%) blur('.$blur.'px);
            }';
        }

        $mobileStyles .= CSS_Output::generate_css('.navbar', 'border-bottom-color', 'mobile_menu_bar_border_color', $darker);
        $mobileStyles .= CSS_Output::generate_css('.burger-default span, .burger-default span:before, .burger-default span:after', 'background-color', 'mobile_menu_burger_icon_color', $txtColor);
        $mobileStyles .= CSS_Output::generate_css('.burger-new .bread-crust-top, .burger-new .bread-crust-bottom', 'background', 'mobile_menu_burger_icon_color', $txtColor);
        $mobileStyles .= CSS_Output::generate_css('.lay-cart-icon-wrap', 'color', 'mobile_menu_burger_icon_color', '#000');

        $mobile_menu_bar_show_border = get_theme_mod('mobile_menu_bar_show_border', "1");
        if($mobile_menu_bar_show_border == "0"){
            $mobileStyles .= '.navbar{border-bottom-width: 0;}';
        }

        $use_desktop_menu_as_mobile_menu = get_theme_mod('mobile_menu_style', 'style_1') == 'style_desktop_menu' ? 1 : 0;
        if($use_desktop_menu_as_mobile_menu != 1){
            // mobile menu points color
            $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li a', 'border-bottom-color', 'mobile_menu_points_underline_color', $darker);
            $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav a', 'color', 'mobile_menu_text_color', $txtColor);
    
            // mobile menu background color with rgba
            $mobile_menu_background_color = get_theme_mod('mobile_menu_background_color', $lighterBgColor);
            $rgb = CSS_Output::hex2rgb($mobile_menu_background_color);
            $alpha = (int)get_theme_mod('mobile_menu_background_opacity', 100);
            $alpha /= 100;
            if($alpha < 0){ $alpha = 0; }
            else if($alpha > 1){ $alpha = 1; }
            switch( $mobile_menu_style ){
                case 'style_1':
                    $mobileStyles .= 'nav.mobile-nav li>a{background-color:rgba('.$rgb['red'].','.$rgb['green'].','.$rgb['blue'].','.$alpha.')}';
                break;
                default:
                    $mobileStyles .= 'nav.mobile-nav{background-color:rgba('.$rgb['red'].','.$rgb['green'].','.$rgb['blue'].','.$alpha.')}';
                break;
            }

            if( get_theme_mod('mobile_menu_blurry', false) == '1' ) {
                $blur = get_theme_mod('mobile_menu_blur_amount', 20);
                switch( $mobile_menu_style ){
                    case 'style_1':
                        $mobileStyles .= 'nav.mobile-nav li>a{
                            -webkit-backdrop-filter: saturate(180%) blur('.$blur.'px);
                            backdrop-filter: saturate(180%) blur('.$blur.'px);
                        }';
                    break;
                    default:
                        $mobileStyles .= 'nav.mobile-nav{
                            -webkit-backdrop-filter: saturate(180%) blur('.$blur.'px);
                            backdrop-filter: saturate(180%) blur('.$blur.'px);
                        }';
                    break;
                }
            }

            // mobile background color of current-menu-item with rgba
            // needed to add .current_page_item for woocommerce pages
            $mobile_menu_current_menu_item_background_color = get_theme_mod('mobile_menu_current_menu_item_background_color', $darker);
            $rgb = CSS_Output::hex2rgb($mobile_menu_current_menu_item_background_color);
            $mobileStyles .= 'nav.mobile-nav li.current-menu-item>a, nav.mobile-nav li.current_page_item>a{background-color:rgba('.$rgb['red'].','.$rgb['green'].','.$rgb['blue'].','.$alpha.')}';

            $mobile_menu_current_menu_item_color = get_theme_mod('mobile_menu_current_menu_item_color', $txtColor);
            $rgb = CSS_Output::hex2rgb($mobile_menu_current_menu_item_color);
            $mobileStyles .= 'nav.mobile-nav li.current-menu-item>a, nav.mobile-nav li.current_page_item>a{color:rgb('.$rgb['red'].','.$rgb['green'].','.$rgb['blue'].')}';
        }
        // mobile menu fontsizes
        $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li a', 'font-size', 'mobile_menu_fontsize', Customizer::$defaults['mobile_menu_fontsize'], '', 'px');

        switch( $mobile_menu_style ){
            case 'style_1':
            case 'style_2':
            case 'style_3':
                $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li a', 'padding-left', 'mobile_menupoint_paddingleft', 10, '', 'px');
                $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li a', 'padding-right', 'mobile_menupoint_paddingright', 10, '', 'px');
                $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li a', 'padding-top', 'mobile_menupoint_paddingtop', 10, '', 'px');
                $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li a', 'padding-bottom', 'mobile_menupoint_paddingbottom', 10, '', 'px');
            break;
            case 'style_desktop_menu':
            break;
        }

        $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li, nav.mobile-nav li a', 'text-align', 'mobile_menu_text_align', 'left');
        $mobileStyles .= CSS_Output::generate_css('nav.mobile-nav li a', 'line-height', 'mobile_menupoint_lineheight', 1, '', 'em');

        $breakpoint = get_option('lay_breakpoint', 600);
        $breakpoint = (int)$breakpoint;

        wp_add_inline_style( 'frontend-style',
        '/* customizer css mobile menu */
            @media (max-width: '.($breakpoint).'px){'
                .$mobileStyles.
            '}'
        );
    }

    public static function echo_lay_customize_css(){
        echo CSS_Output_Mobile_Menu::lay_customize_css();
    }

}
new CSS_Output_Mobile_Menu();