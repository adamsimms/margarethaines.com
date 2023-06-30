<?php
class LayFrontend_Options {

    public static $pt_textformat;
    public static $ptags_textformat;
    public static $pt_position;
    public static $pd_position;
    public static $st_position;
    public static $st_hide;
    public static $navbar_hide;
    public static $showArrows;
    public static $pa_type;
    public static $simple_parallax;
    public static $playicon;
    public static $projectsFooterId;
    public static $footer_active_in_projects;
    public static $pagesFooterId;
    public static $footer_active_in_pages;
    public static $newsFooterId;
    public static $footer_active_in_news;
    public static $individual_news_footers;
    public static $categoriesFooterId;
    public static $footer_active_in_categories;
    public static $individual_project_footers;
    public static $individual_page_footers;
    public static $individual_category_footers;
    public static $prevnext_navigate_through;
    public static $navigation_transition_duration;
    public static $activate_project_description;
    public static $fi_mo_touchdevice_behaviour;
    public static $image_loading;
    public static $cover_active_in_projects;
    public static $cover_active_in_pages;
    public static $cover_active_in_categories;
    public static $cover_individual_project_ids;
    public static $cover_individual_page_ids;
    public static $cover_individual_category_ids;
    public static $cover_scrolldown_on_click;
    public static $cover_darken_when_scrolling;
    public static $cover_parallaxmove_when_scrolling;
    public static $misc_options_cover;
    public static $misc_options_max_width_apply_to_logo_and_nav;
    public static $maxwidth;
    public static $default;
    public static $m_st_fontfamily;
    public static $misc_options_showoriginalimages;
    public static $cover_disable_for_phone;
    public static $phone_layout_active;
    public static $misc_options_thumbnail_video;
    public static $misc_options_thumbnail_mouseover_image;
    public static $frame_leftright;
    public static $bg_color;
    public static $bg_image;
    public static $is_customize;
    public static $is_ssl;
    public static $has_www;
    public static $is_qtranslate_active;
    public static $intro_text_textformat;
    public static $element_transition_on_scroll;
    public static $breakpoint;
    public static $video_thumbnail_mouseover_behaviour;
    public static $cover_down_arrow_type;
    public static $cover_down_arrow;
    public static $cover_down_arrow_phone;
    public static $cover_down_arrow_animate;
    public static $spaces_mu;
    public static $offsets_mu;
    public static $tablet_breakpoint;
    public static $turn_off_custom_code;
    public static $menu_submenu_keep_open;
    public static $show_password_protected_posts_in_thumbnailgrid;
    public static $lightbox_default_caption;
    public static $lightbox_captionTextformat;
    public static $hide_current_project_from_thumbnailgrid;
    public static $enable_video_lazyloading_for_firefox;

    public function __construct(){
        // if i dont use this hook but set all vars on construct, the latest values are not set when changing these values in customize
        // instead, the old values will still be in use
        add_action('wp_loaded', array($this, 'set_vars'));
    }

    public static function set_vars(){
        LayFrontend_Options::$lightbox_captionTextformat = get_option( 'lightbox_captionTextformat', "Default" );
        LayFrontend_Options::$lightbox_default_caption = get_option( 'lightbox_default_caption', "none" );
        LayFrontend_Options::$tablet_breakpoint = get_option( 'misc_options_textformats_tablet_breakpoint', 1024 );
        LayFrontend_Options::$tablet_breakpoint = (int)LayFrontend_Options::$tablet_breakpoint;

        LayFrontend_Options::$spaces_mu = get_option( 'gridder_spaces_mu', LayConstants::gridder_spaces_mu );
        if ( LayFrontend_Options::$spaces_mu == '%' ) {
            LayFrontend_Options::$spaces_mu = 'vw';
        }
        LayFrontend_Options::$offsets_mu = get_option( 'gridder_offsets_mu', LayConstants::gridder_offsets_mu );
        if ( LayFrontend_Options::$offsets_mu == '%' ) {
            LayFrontend_Options::$offsets_mu = 'vw';
        }

        LayFrontend_Options::$cover_down_arrow_type = get_option( 'cover_down_arrow_type', 'none' );
        
        $desktop_image_thumb_id = get_option( 'cover_down_arrow', '' );
        $desktop_image_thumb = wp_get_attachment_image_src( $desktop_image_thumb_id, 'full' );
        if( is_array($desktop_image_thumb) ) {
            LayFrontend_Options::$cover_down_arrow = '<img class="cover-down-arrow-desktop" src="'.$desktop_image_thumb[0].'" alt="">';
        } else {
            LayFrontend_Options::$cover_down_arrow = Lay_LayoutFunctions::$downArrowDesktop;
        }

        $phone_image_thumb_id = get_option( 'cover_down_arrow_phone', '' );
        $phone_image_thumb = wp_get_attachment_image_src( $phone_image_thumb_id, 'full' );
        if( is_array($phone_image_thumb) ) {
            LayFrontend_Options::$cover_down_arrow_phone = '<img class="cover-down-arrow-phone" src="'.$phone_image_thumb[0].'" alt="">';
        } else {
            if( is_array($desktop_image_thumb) ) {
                LayFrontend_Options::$cover_down_arrow_phone = '<img class="cover-down-arrow-phone" src="'.$desktop_image_thumb[0].'" alt="">';
            } else {
                LayFrontend_Options::$cover_down_arrow_phone = Lay_LayoutFunctions::$downArrowPhone;
            }
        }

        LayFrontend_Options::$cover_down_arrow_animate = get_option('cover_down_arrow_animate', '') == 'on' ? true : false;

        LayFrontend_Options::$enable_video_lazyloading_for_firefox = get_option('misc_options_enable_video_lazyloading_for_firefox', '') == 'on' ? true : false;

        LayFrontend_Options::$breakpoint = MiscOptions::$phone_breakpoint;

        LayFrontend_Options::$pt_textformat = get_theme_mod("pt_textformat", "Default");
        if(LayFrontend_Options::$pt_textformat != ""){
            LayFrontend_Options::$pt_textformat = '_'.LayFrontend_Options::$pt_textformat;
        }

        LayFrontend_Options::$ptags_textformat = get_theme_mod("ptags_textformat", "Default");
        if(LayFrontend_Options::$ptags_textformat != ""){
            LayFrontend_Options::$ptags_textformat = '_'.LayFrontend_Options::$ptags_textformat;
        }
    
        LayFrontend_Options::$pt_position = get_theme_mod("pt_position", "below-image");
        LayFrontend_Options::$pd_position = get_theme_mod("pd_position", "below-image");

        LayFrontend_Options::$st_position = get_theme_mod('st_position', 'top-left');
        LayFrontend_Options::$st_hide = get_theme_mod('st_hide', 0);
        LayFrontend_Options::$navbar_hide = get_theme_mod('navbar_hide', 0);
    
        LayFrontend_Options::$showArrows = get_option('misc_options_show_project_arrows', '');
        LayFrontend_Options::$showArrows = LayFrontend_Options::$showArrows == 'on' && !MiscOptions::$locked ? true : false;
        LayFrontend_Options::$pa_type = get_theme_mod('pa_type', 'icon');
        LayFrontend_Options::$simple_parallax = get_option('misc_options_simple_parallax', '');
        LayFrontend_Options::$simple_parallax = LayFrontend_Options::$simple_parallax == 'on' && !MiscOptions::$locked ? true : false;
    
        LayFrontend_Options::$show_password_protected_posts_in_thumbnailgrid = get_option('misc_options_show_password_protected_posts_in_thumbnailgrid', 'on');
        LayFrontend_Options::$show_password_protected_posts_in_thumbnailgrid = LayFrontend_Options::$show_password_protected_posts_in_thumbnailgrid == 'on' ? true : false;

        LayFrontend_Options::$playicon = '';
        $playicon_id = get_option( 'misc_options_html5video_playicon', '' );
        if($playicon_id != ''){
            LayFrontend_Options::$playicon = wp_get_attachment_image_src( $playicon_id, 'full' );
            LayFrontend_Options::$playicon = LayFrontend_Options::$playicon[0];
        }
    
        LayFrontend_Options::$projectsFooterId = '';
        LayFrontend_Options::$footer_active_in_projects = get_option('lay_footer_active_in_projects', 'off');
        if(LayFrontend_Options::$footer_active_in_projects=="all"){
            LayFrontend_Options::$projectsFooterId = get_option('lay_projects_footer', '');
        }
    
        LayFrontend_Options::$pagesFooterId = '';
        LayFrontend_Options::$footer_active_in_pages = get_option('lay_footer_active_in_pages', 'off');
        if(LayFrontend_Options::$footer_active_in_pages=="all"){
            LayFrontend_Options::$pagesFooterId = get_option('lay_pages_footer', '');
        }

        LayFrontend_Options::$newsFooterId = '';
        LayFrontend_Options::$footer_active_in_news = get_option('lay_footer_active_in_news', 'off');
        if(LayFrontend_Options::$footer_active_in_news=="all"){
            LayFrontend_Options::$newsFooterId = get_option('lay_news_footer', '');
        }
    
        LayFrontend_Options::$categoriesFooterId = '';
        LayFrontend_Options::$footer_active_in_categories = get_option('lay_footer_active_in_categories', 'off');
        if(LayFrontend_Options::$footer_active_in_categories=="all"){
            LayFrontend_Options::$categoriesFooterId = get_option('lay_categories_footer', '');
        }
    
        LayFrontend_Options::$individual_project_footers = get_option('lay_individual_project_footers', '');
        LayFrontend_Options::$individual_news_footers = get_option('lay_individual_news_footers', '');
        LayFrontend_Options::$individual_page_footers = get_option('lay_individual_page_footers', '');
        LayFrontend_Options::$individual_category_footers = get_option('lay_individual_category_footers', '');
    
        LayFrontend_Options::$prevnext_navigate_through = get_option('misc_options_prevnext_navigate_through', 'all_projects');
        
        // LayFrontend_Options::$navigation_transition_in_duration = Frontend::get_navigation_transition_in_duration_in_milliseconds();
        // LayFrontend_Options::$navigation_transition_out_duration = Frontend::get_navigation_transition_out_duration_in_milliseconds();

        LayFrontend_Options::$activate_project_description = get_option('misc_options_activate_project_description', '');
        LayFrontend_Options::$activate_project_description = LayFrontend_Options::$activate_project_description == "on" && !MiscOptions::$locked ? true : false;
    
        LayFrontend_Options::$fi_mo_touchdevice_behaviour = get_theme_mod('fi_mo_touchdevice_behaviour', 'mo_dont_show');
        
        LayFrontend_Options::$hide_current_project_from_thumbnailgrid = get_option('misc_options_hide_current_project_from_thumbnailgrid', 'on');

        /* 
		i changed the misc option inputs from radio to checkbox
		this used to be either "instant_load" or "lazy_load"
		but now it can be '' or 'on'
		'on' is when lazyload is turned on, '' is when lazyload is off
		i need to make sure in my code the values 'instant_load' and 'lazy_load' are handled too
		*/
        LayFrontend_Options::$image_loading = get_option('misc_options_image_loading', 'on');
        if( LayFrontend_Options::$image_loading == 'on' ) {
			LayFrontend_Options::$image_loading = 'lazy_load';
		} else if (LayFrontend_Options::$image_loading == '') {
			LayFrontend_Options::$image_loading = 'instant_load';
        }
        
        LayFrontend_Options::$cover_active_in_projects = get_option( 'cover_active_in_projects', "off" );
        LayFrontend_Options::$cover_active_in_pages = get_option( 'cover_active_in_pages', "off" );
        LayFrontend_Options::$cover_active_in_categories = get_option( 'cover_active_in_categories', "off" );
    
        // for an unknown reason in rare cases the arrays are saved as associative arrays, so flatten them here
        LayFrontend_Options::$cover_individual_project_ids = CoverOptions::get_individual_project_ids();
        LayFrontend_Options::$cover_individual_page_ids = CoverOptions::get_individual_page_ids();
        LayFrontend_Options::$cover_individual_category_ids = CoverOptions::get_individual_category_ids();
    
        LayFrontend_Options::$cover_scrolldown_on_click = get_option('cover_scrolldown_on_click', '');
        LayFrontend_Options::$cover_scrolldown_on_click = LayFrontend_Options::$cover_scrolldown_on_click == 'on' ? true : false;
        LayFrontend_Options::$cover_darken_when_scrolling = get_option('cover_darken_when_scrolling', '');
        LayFrontend_Options::$cover_darken_when_scrolling = LayFrontend_Options::$cover_darken_when_scrolling == 'on' ? true : false;
        LayFrontend_Options::$cover_parallaxmove_when_scrolling = get_option('cover_parallaxmove_when_scrolling', '');
        LayFrontend_Options::$cover_parallaxmove_when_scrolling = LayFrontend_Options::$cover_parallaxmove_when_scrolling == 'on' ? true : false;
    
        LayFrontend_Options::$misc_options_cover = get_option('misc_options_cover', '');
        LayFrontend_Options::$misc_options_cover = LayFrontend_Options::$misc_options_cover == 'on' && !MiscOptions::$locked ? true : false;
    
        LayFrontend_Options::$turn_off_custom_code = get_option( 'misc_setting_turn_off_custom_code', '' ) == 'on' ? true : false;

        LayFrontend_Options::$misc_options_max_width_apply_to_logo_and_nav = get_option('misc_options_max_width_apply_to_logo_and_nav', '');
        LayFrontend_Options::$misc_options_max_width_apply_to_logo_and_nav = LayFrontend_Options::$misc_options_max_width_apply_to_logo_and_nav == 'on' ? true : false;
        LayFrontend_Options::$maxwidth = get_option( 'misc_options_max_width', '0' );
    
        LayFrontend_Options::$default = get_theme_mod('st_fontfamily', Customizer::$defaults['fontfamily']);
        LayFrontend_Options::$m_st_fontfamily = get_theme_mod('m_st_fontfamily', LayFrontend_Options::$default);
    
        LayFrontend_Options::$misc_options_showoriginalimages = get_option('misc_options_showoriginalimages', '');
        LayFrontend_Options::$misc_options_showoriginalimages = LayFrontend_Options::$misc_options_showoriginalimages == 'on' ? true : false;
        LayFrontend_Options::$cover_disable_for_phone = get_option('cover_disable_for_phone', '');
        LayFrontend_Options::$cover_disable_for_phone = LayFrontend_Options::$cover_disable_for_phone == 'on' ? true : false;
    
        LayFrontend_Options::$phone_layout_active = get_option('misc_options_extra_gridder_for_phone', 'on');
        LayFrontend_Options::$phone_layout_active =  LayFrontend_Options::$phone_layout_active == 'on' ? true : false;

        LayFrontend_Options::$misc_options_thumbnail_video = get_option('misc_options_thumbnail_video', '');
        LayFrontend_Options::$misc_options_thumbnail_video = LayFrontend_Options::$misc_options_thumbnail_video == 'on' && !MiscOptions::$locked ? true : false;
        LayFrontend_Options::$misc_options_thumbnail_mouseover_image = get_option('misc_options_thumbnail_mouseover_image', '');
        LayFrontend_Options::$misc_options_thumbnail_mouseover_image = LayFrontend_Options::$misc_options_thumbnail_mouseover_image == 'on' && !MiscOptions::$locked ? true : false;
    
        LayFrontend_Options::$frame_leftright = get_option( 'gridder_defaults_frame', LayConstants::gridder_defaults_frame );
    
        LayFrontend_Options::$bg_color = get_theme_mod('bg_color', '#ffffff');
        if(LayFrontend_Options::$bg_color == ""){
            LayFrontend_Options::$bg_color = "#ffffff";
        }
        LayFrontend_Options::$bg_image = get_theme_mod('bg_image', "");
    
        LayFrontend_Options::$is_customize = is_customize_preview();
        LayFrontend_Options::$is_ssl = is_ssl();
        LayFrontend_Options::$has_www = LTUtility::has_www();
    
        LayFrontend_Options::$is_qtranslate_active = is_plugin_active('qtranslate-x/qtranslate.php') || is_plugin_active('qtranslate-xt-master/qtranslate.php');
    
        LayFrontend_Options::$intro_text_textformat = get_theme_mod('intro_text_textformat', 'Default');
        if(LayFrontend_Options::$intro_text_textformat != ""){
            LayFrontend_Options::$intro_text_textformat = '_'.LayFrontend_Options::$intro_text_textformat;
        }
    
        LayFrontend_Options::$element_transition_on_scroll = get_option('misc_options_element_transition_on_scroll', '');
        LayFrontend_Options::$element_transition_on_scroll = LayFrontend_Options::$element_transition_on_scroll == 'on' ? true : false; 
        LayFrontend_Options::$video_thumbnail_mouseover_behaviour = get_theme_mod('fi_mo_video_behaviour', 'autoplay');

        LayFrontend_Options::$menu_submenu_keep_open = get_theme_mod('menu_submenu_keep_open', false);
    }

}

new LayFrontend_Options();