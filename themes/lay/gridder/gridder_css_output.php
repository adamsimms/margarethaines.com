<?php

class Gridder_CSS_Output{

	public function __construct(){
        add_action( 'admin_head', array($this, 'lay_customize_css_for_admin'));
    }

    public static function lay_customize_css_for_admin(){
        // projecttitle styles for backend edit category screen
        $screen = get_current_screen();
        if ( !LTUtility::is_admin_page_with_a_gridder($screen) ) {
            return;
        }
        $css_for_js = '';
        $strokewidth = get_theme_mod('link_underline_strokewidth', 1);
        if( intval($strokewidth) > 0 ) {
            $css_for_js = 'text-decoration-thickness:'.$strokewidth.'px!important;text-decoration-style: solid!important;text-decoration-line: underline!important';
        }
        // for tinymce style
        echo
        '<script type="text/javascript">
            var customizerPassedData = {};
            customizerPassedData.link_css = \'a{color: '.get_theme_mod('link_color', '#000000').';text-underline-offset: '.get_theme_mod('link_underline_offset', '3').get_theme_mod('link_underline_offset_mu', 'px').';'.$css_for_js.'}\';
        </script>';

        $css = '';

        // project tags
        $mod = get_theme_mod("ptags_visibility", 'always-show');
        if($mod == 'hide'){
            $css .= '#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags{display:none!important;}';
        }
        $css .= CSS_Output::generate_opacity_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'ptags_opacity', 100);
        $css .= CSS_Output::generate_opacity_css('.thumbnail-tags', 'ptags_opacity', 100);

        // if a textformat was set for project title, then we don't need to output css for it, cause we would use the textformat's css instead
        if(get_theme_mod("ptags_textformat", "_Default") == ""){
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'font-family', 'ptags_fontfamily', Customizer::$defaults['fontfamily']);
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'color', 'ptags_color', Customizer::$defaults['color']);
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'letter-spacing', 'ptags_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'line-height', 'ptags_lineheight', Customizer::$defaults['lineheight'], '', '');
            // textalign only applies to project title when its position is below image
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'text-align', 'ptags_align', 'left');
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'font-weight', 'ptags_fontweight', Customizer::$defaults['fontweight']);

            $ptags_fontsize_mu = CSS_Output::get_mu('ptags_fontsize_mu', 'px');
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, #gridder .lay-input-modal .thumbnail-tags', 'font-size', 'ptags_fontsize', Customizer::$defaults['fontsize'], '', $ptags_fontsize_mu);
        }

        $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, .lay-input-modal .thumbnail-tags', 'margin-bottom', 'ptags_spacebottom', '0', '', 'px');
        $css .= CSS_Output::generate_css('#gridder #gridder-wrap .thumbnail-tags, .lay-input-modal .thumbnail-tags', 'margin-top', 'ptags_spacetop', '0', '', 'px');


        // project title 
        $mod = get_theme_mod("pt_visibility", 'always-show');
        if($mod == 'hide'){
            $css .= '#gridder #gridder-wrap .title, #gridder .lay-input-modal .title{display:none!important;}';
        }
        $css .= CSS_Output::generate_opacity_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'pt_opacity', 100);
        $css .= CSS_Output::generate_css('#gridder .container', 'background-color', 'bg_color', '#ffffff');
        $css .= CSS_Output::pt_generate_position_css('#gridder #gridder-wrap .titlewrap-on-image, #gridder .lay-input-modal .titlewrap-on-image');
        $css .= CSS_Output::generate_opacity_css('.title', 'pt_opacity', 100);

        // if a textformat was set for project title, then we don't need to output css for it, cause we would use the textformat's css instead
        if(get_theme_mod("pt_textformat", "_Default") == ""){
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'font-family', 'pt_fontfamily', Customizer::$defaults['fontfamily']);
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'color', 'pt_color', Customizer::$defaults['color']);
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'letter-spacing', 'pt_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'line-height', 'pt_lineheight', Customizer::$defaults['lineheight'], '', '');
            // textalign only applies to project title when its position is below image
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'text-align', 'pt_align', 'left');
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'font-weight', 'pt_fontweight', Customizer::$defaults['fontweight']);

            $pt_fontsize_mu = CSS_Output::get_mu('pt_fontsize_mu', 'px');
            $css .= CSS_Output::generate_css('#gridder #gridder-wrap .title, #gridder .lay-input-modal .title', 'font-size', 'pt_fontsize', Customizer::$defaults['fontsize'], '', $pt_fontsize_mu);
        }

        $css .= CSS_Output::generate_css('#gridder #gridder-wrap .above-image .title, .lay-input-modal .above-image .title', 'margin-bottom', 'pt_spacetop', '5', '', 'px');
        $css .= CSS_Output::generate_css('#gridder #gridder-wrap .below-image .title, .lay-input-modal .below-image .title', 'margin-top', 'pt_spacetop', '5', '', 'px');

        $css .= CSS_Output::generate_css('#gridder .container', 'background-color', 'bg_color', '#ffffff');

        // project description
        
        // pd position
        $pd_position = get_theme_mod('pd_position', 'below-image');
        $pt_position = get_theme_mod('pt_position', 'below-image');
        // when pt position is below or above and pd pos is on-image, do center css
        // otherwise, the pt alignment defines where pt and pd are (can be on-image-top-left, or on-image-top-right, on-image-bottom-left etc)
        if( $pd_position == 'on-image' && strpos($pt_position, 'on-image') === false ){
            $css .= 
            '#gridder #gridder-wrap .titlewrap-on-image,
            #gridder .lay-input-modal .titlewrap-on-image{
                top: 50%;
                left: 50%;
                -webkit-transform: translate(-50%,-50%);
                -moz-transform: translate(-50%,-50%);
                -ms-transform: translate(-50%,-50%);
                -o-transform: translate(-50%,-50%);
                transform: translate(-50%,-50%);
            }';   
        }
        $css .= CSS_Output::generate_opacity_css('#gridder #gridder-wrap .descr, #gridder .lay-input-modal .descr', 'pd_opacity', 100);
        $css .= CSS_Output::generate_css('#gridder #gridder-wrap .descr, #gridder .lay-input-modal .descr', 'margin-top', 'pd_spacetop', '0', '', 'px');
        
        // thumbnailgrid filter
        // if a textformat is selected, the html class is used by the dom element, so i don't need to create extra styles
		$tgf_textformat = get_theme_mod('tgf_textformat', 'Default');
		if($tgf_textformat == ""){
			// if no textformat was selected for thumbnailgrid filter, generate css based on the individual customizer controls
			$tgf_fontsize_mu = CSS_Output::get_mu('tgf_fontsize_mu', 'px');
			$css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'font-size', 'tgf_fontsize', Customizer::$defaults['fontsize'],'', $tgf_fontsize_mu);
			$css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'font-weight', 'tgf_fontweight', Customizer::$defaults['fontweight']);
			$css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'letter-spacing', 'tgf_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
			$css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'color', 'tgf_color', Customizer::$defaults['color']);
			$css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'font-family', 'tgf_fontfamily', Customizer::$defaults['fontfamily']);
			$css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'text-align', 'tgf_align', 'left');
        }
        $d = get_theme_mod('tgf_color', Customizer::$defaults['color']);
        $css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter .lay-filter-active', 'color', 'tgf_active_color', $d);
        $css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'margin-bottom', 'tgf_spacebelow', '20', '', 'px');
        $css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter-anchor', 'margin-right', 'tgf_spacebetween_2', '10', '', 'px');
        $css .= CSS_Output::generate_css('.lay-thumbnailgrid-filter-anchor', 'margin-bottom', 'tgf_spacebetween_2', '10', '', 'px');

        $css .= CSS_Output::generate_opacity_css('.lay-thumbnailgrid-filter-anchor', 'tgf_opacity', 50);

        $css .= CSS_Output::generate_opacity_css('.lay-thumbnailgrid-filter-anchor.lay-filter-active', 'tgf_active_opacity', 100);

        $tgf_active_strokewidth = get_theme_mod('tgf_active_strokewidth', 0);
        if( $tgf_active_strokewidth > 0 ) {
            $css .= '
            .lay-thumbnailgrid-filter-anchor{
                text-decoration-thickness:'.$tgf_active_strokewidth.'px;
                text-decoration-color: transparent;
                text-decoration-style: underline;
            }
            .lay-thumbnailgrid-filter-anchor.lay-filter-active{
                border-bottom-color: inherit;
            }';
        }

        // tags filter for thumbnailgrid
        // if a textformat is selected, the html class is used by the dom element, so i don't need to create extra styles
		$tgtf_textformat = get_theme_mod('tgtf_textformat', 'Default');
		if($tgtf_textformat == ""){
			// if no textformat was selected for st, generate css based on the individual customizer controls
			$tgtf_fontsize_mu = CSS_Output::get_mu('tgtf_fontsize_mu', 'px');
			$css .= CSS_Output::generate_css('.tag-bubble', 'font-size', 'tgtf_fontsize', Customizer::$defaults['fontsize'],'', $tgtf_fontsize_mu);
			$css .= CSS_Output::generate_css('.tag-bubble', 'font-weight', 'tgtf_fontweight', Customizer::$defaults['fontweight']);
			$css .= CSS_Output::generate_css('.tag-bubble', 'letter-spacing', 'tgtf_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
			$css .= CSS_Output::generate_css('.tag-bubble', 'color', 'tgtf_color', Customizer::$defaults['color']);
			$css .= CSS_Output::generate_css('.tag-bubble', 'font-family', 'tgtf_fontfamily', Customizer::$defaults['fontfamily']);
        }
        $css .= CSS_Output::generate_css('.lay-thumbnailgrid-tagfilter', 'margin-bottom', 'tgtf_spacebelow', '20', '', 'px');
        $css .= CSS_Output::generate_css('.tag-bubble', 'margin', 'tgtf_spacebetween', '10', '', 'px');
        $css .= CSS_Output::generate_css('.lay-thumbnailgrid-tagfilter', 'margin-left', 'tgtf_spacebetween', '10', '-', 'px');

        $css .= CSS_Output::generate_css('.tag-bubble', 'background-color', 'tgtf_bubble_color', '#eeeeee');
        $css .= CSS_Output::generate_css('.tag-bubble', 'border-radius', 'tgtf_bubble_border_radius', '100', '', 'px');
        $css .= CSS_Output::generate_css('.tag-bubble:hover, .tag-bubble.lay-tag-active', 'background-color', 'tgtf_bubble_active_color', '#d0d0d0');
        

        $background_color = get_theme_mod('bg_color', '#ffffff');
        $css .= '#gridder-wrap{ background-color:'.$background_color.'; }';
        
        // woocommerce
        if( class_exists( 'WooCommerce' ) ) {
            // styles needed for productsgrid element

            // button text format
            $button_text_format = get_theme_mod('lay_woocommerce_button_textformat', 'Shop_Big');
            $css .= FormatsManager::get_textformat_css_for_selector($button_text_format, '#gridder-root .lay-products .button', false);
            
            // project thumbnail custom add to cart button text format
            $show_add_to_cart_button = get_theme_mod('lay_woocommerce_pt_show_add_to_cart_button', 0);
            if( $show_add_to_cart_button ) {
                if( get_theme_mod('lay_woocommerce_pt_use_custom_textformat', 1) == true ) {
                    $format = get_theme_mod('lay_woocommerce_pt_add_to_cart_textformat', 'Shop_Small');
                    $css .= FormatsManager::get_textformat_css_for_selector($format, '#gridder-root .lay_woocommerce_product_thumbnail_title_wrap .button', false);
                }
            }

            $button_style = get_theme_mod('lay_woocommerce_button_style', 'filled');
            $button_color = get_theme_mod('lay_woocommerce_button_color', '#000');
            $button_mouseover_color = get_theme_mod('lay_woocommerce_mouseover_button_color', '#000');
            $lay_woocommerce_button_padding_top_bottom = get_theme_mod('lay_woocommerce_button_padding_top_bottom', '11');
            $lay_woocommerce_button_padding_left_right = get_theme_mod('lay_woocommerce_button_padding_left_right', '15');
            $lay_woocommerce_button_text_color = get_theme_mod('lay_woocommerce_button_text_color', '#fff');

            $css .= '#gridder-root .lay-products .button{ color:'.$lay_woocommerce_button_text_color.'!important; opacity: 1; }';
            $css .= '#gridder-root .lay-products .button{ padding-top:'.$lay_woocommerce_button_padding_top_bottom.'px; padding-bottom:'.$lay_woocommerce_button_padding_top_bottom.'px; }';
            $css .= '#gridder-root .lay-products .button{ padding-left:'.$lay_woocommerce_button_padding_left_right.'px; padding-right:'.$lay_woocommerce_button_padding_left_right.'px; }';
            $css .= '#gridder-root .lay-products .button{ border-radius:'.get_theme_mod('lay_woocommerce_button_border_radius', 0).'px; }';
            
            $button_border_width = get_theme_mod('lay_woocommerce_button_border_width', '1');

            switch($button_style){
                case 'filled':
                    $css .= '
                    #gridder-root .lay-products .button{
                        background-color: '.$button_color.';
                        border-bottom: none!important;
                        border: none!important;
                    }
                    #gridder-root .lay-products .button{
                        background-color: '.$button_mouseover_color.';
                    }
                    ';
                break;
                case 'outlines':
                    $css .= '
                    #gridder-root .lay-products .button{
                        border-color: '.$button_color.';
                        border-bottom: '.$button_border_width.'px solid '.$button_color.'!important;
                        border-width: '.$button_border_width.'px;
                        border-style: solid;
                        background-color: transparent;
                    }
                    #gridder-root .lay-products .button{
                        border-color: '.$button_mouseover_color.';
                        border-bottom-color: '.$button_mouseover_color.'!important;
                        background-color: transparent;
                    }
                    ';
                break;
            }

            $css .= CSS_Output::generate_css('#gridder-root .lay-woocommerce-product-thumbnail-title', 'margin-top', 'lay_woocommerce_pt_spacetop', '12','', 'px');
            $css .= CSS_Output::generate_css('#gridder-root .lay-woocommerce-product-thumbnail-price', 'margin-top', 'lay_woocommerce_pt_price_spacetop', '0','', 'px');
            $css .= CSS_Output::generate_css('#gridder-root .lay_woocommerce_product_thumbnail-out_of_stock', 'margin-top', 'lay_woocommerce_pt_outofstock_spacetop', '2','', 'px');

            $css .= CSS_Output::generate_css('#gridder-root .lay_woocommerce_product_thumbnail_title_wrap .add_to_cart_inline', 'margin-top', 'lay_woocommerce_pt_cart_button_spacetop', '15','', 'px!important');

        }

        // buttons
        // #eeeeee same as standard tag bubble color
        $bgcolor = get_theme_mod('laybutton1_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton1_background_color', '#ffffff');
        $css .= 
        '#gridder-root a.laybutton1{
            color: '.get_theme_mod('laybutton1_text_color', '#000').';
            border-radius: '.get_theme_mod('laybutton1_borderradius', 0).'px;
            background-color: '.$bgcolor.';
            border: '.get_theme_mod('laybutton1_borderwidth', 1).'px solid '.get_theme_mod('laybutton1_border_color', '#000000').';
            padding-left: '.get_theme_mod('laybutton1_paddingleftright', 15).'px;
            padding-right: '.get_theme_mod('laybutton1_paddingleftright', 15).'px;
            padding-top: '.get_theme_mod('laybutton1_paddingtop', 5).'px;
            padding-bottom: '.get_theme_mod('laybutton1_paddingbottom', 5).'px;
            margin-left: '.get_theme_mod('laybutton1_marginleftright', 0).'px;
            margin-right: '.get_theme_mod('laybutton1_marginleftright', 0).'px;
            margin-top: '.get_theme_mod('laybutton1_margintop', 0).'px;
            margin-bottom: '.get_theme_mod('laybutton1_marginbottom', 0).'px;
            text-decoration: none!important;
        }';
        $laybutton1_textformat = get_theme_mod('laybutton1_textformat', 'Default');
        $css .= FormatsManager::get_textformat_css_for_selector($laybutton1_textformat, '#gridder-root a.laybutton1', false);
        

        $bgcolor = get_theme_mod('laybutton2_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton2_background_color', '#ffffff');
        $css .= 
        '#gridder-root a.laybutton2{
            color: '.get_theme_mod('laybutton2_text_color', '#000').';
            border-radius: '.get_theme_mod('laybutton2_borderradius', 100).'px;
            background-color: '.$bgcolor.';
            border: '.get_theme_mod('laybutton2_borderwidth', 1).'px solid '.get_theme_mod('laybutton2_border_color', '#000000').';
            padding-left: '.get_theme_mod('laybutton2_paddingleftright', 20).'px;
            padding-right: '.get_theme_mod('laybutton2_paddingleftright', 20).'px;
            padding-top: '.get_theme_mod('laybutton2_paddingtop', 5).'px;
            padding-bottom: '.get_theme_mod('laybutton2_paddingbottom', 5).'px;
            margin-left: '.get_theme_mod('laybutton2_marginleftright', 0).'px;
            margin-right: '.get_theme_mod('laybutton2_marginleftright', 0).'px;
            margin-top: '.get_theme_mod('laybutton2_margintop', 0).'px;
            margin-bottom: '.get_theme_mod('laybutton2_marginbottom', 0).'px;
            text-decoration: none!important;
        }';
        $laybutton2_textformat = get_theme_mod('laybutton2_textformat', 'Default');
        $css .= FormatsManager::get_textformat_css_for_selector($laybutton2_textformat, '#gridder-root a.laybutton2', false);
        
        $bgcolor = get_theme_mod('laybutton3_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton3_background_color', '#eeeeee');
        $css .= 
        '#gridder-root a.laybutton3{
            color: '.get_theme_mod('laybutton3_text_color', '#000').';
            border-radius: '.get_theme_mod('laybutton3_borderradius', 100).'px;
            background-color: '.$bgcolor.';
            border: '.get_theme_mod('laybutton3_borderwidth', 0).'px solid '.get_theme_mod('laybutton3_border_color', '#000000').';
            padding-left: '.get_theme_mod('laybutton3_paddingleftright', 20).'px;
            padding-right: '.get_theme_mod('laybutton3_paddingleftright', 20).'px;
            padding-top: '.get_theme_mod('laybutton3_paddingtop', 5).'px;
            padding-bottom: '.get_theme_mod('laybutton3_paddingbottom', 5).'px;
            margin-left: '.get_theme_mod('laybutton3_marginleftright', 0).'px;
            margin-right: '.get_theme_mod('laybutton3_marginleftright', 0).'px;
            margin-top: '.get_theme_mod('laybutton3_margintop', 0).'px;
            margin-bottom: '.get_theme_mod('laybutton3_marginbottom', 0).'px;
            text-decoration: none!important;
        }';
        $laybutton3_textformat = get_theme_mod('laybutton3_textformat', 'Default');
        $css .= FormatsManager::get_textformat_css_for_selector($laybutton3_textformat, '#gridder-root a.laybutton3', false);

        // links in texts
        $css .= '#gridder .text a, #gridder .lay-marquee a, #gridder .caption a, #gridder .text-to-add a, #gridder .link-in-text{
            text-underline-offset: '.get_theme_mod('link_underline_offset', 3).get_theme_mod('link_underline_offset_mu', 'px').';
        }';

        $css .= CSS_Output::generate_css('#gridder .text a, #gridder .lay-marquee a, #gridder .caption a, #gridder .text-to-add a, #gridder .link-in-text', 'color', 'link_color', '#000');
        $strokewidth = get_theme_mod('link_underline_strokewidth', 1);
        if( intval($strokewidth) > 0 ) {
            $css .= '#gridder .text a, #gridder .lay-marquee a, #gridder .caption a, #gridder .text-to-add a, #gridder .link-in-text{ 
                text-decoration-thickness:'.$strokewidth.'px;
                text-decoration-style: solid;
                text-decoration-line: underline;
            }';
        }

        echo 
        '<!-- customizer css for gridder -->
        <style>'.$css.'</style>';

    }

}
new Gridder_CSS_Output();