<?php
class CSS_Output{

	public function __construct(){
        // if i dont use this hook but set all vars on construct, the latest values are not set when changing these values in customize
        // instead, the old values will still be in use
        // add_action( 'wp_loaded', array($this, 'lay_customize_css') );

        // todo: i dont know why but i need to reload twice for changes made to thumbnailgrid filter customizer settings to show up correctly

        add_action( 'wp_enqueue_scripts', array( $this, 'lay_customize_css' ), 20 );
    }

    public static function lay_customize_css(){
		// $textformats_for_tablet = get_option( 'misc_options_textformats_for_tablet', "" ) == "on" ? true : false;
		//
		// $formatsJsonString = FormatsManager::getDefaultFormatsJson();
		// $formatsJsonArr = json_decode($formatsJsonString, true);

		// $sharedStyles apply to desktop, tablet and mobile
        $sharedStyles = "";
		// $desktopAndTabletStyles applies to desktop and tablet size
        $desktopAndTabletStyles = "";
		$desktopStyles = "";
		$tabletStyles = "";
        $mobileStyles = "";

        // woocommerce
        if( class_exists( 'WooCommerce' ) ) {

            $hide = get_theme_mod('lay_woocommerce_cart_menupoint_hide_empty', 0);
            // error_log(print_r($hide, true));
            if( $hide == 1 ) {
                $sharedStyles .= '.laycart-empty{ display: none!important; }';
            }

            // single product
            $type = get_theme_mod('lay_woocommerce_singleproduct_layout_type', 'one_image_per_row');
            if( $type == 'one_image_per_row' || $type == 'carousel' ) {
                $width = get_theme_mod('lay_woocommerce_singleproduct_image_width', 48.9);
                $desktopAndTabletStyles .= 
                'body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery,
                body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery
                { width:'.$width.'%; }';
                $space_left = get_theme_mod('lay_woocommerce_singleproduct_image_space_left', 0);
                $desktopAndTabletStyles .=
                '.lay-woocommerce-single-product-wrap{ padding-left:'.$space_left.'%; }';
            }

            // button text format
            $button_text_format = get_theme_mod('lay_woocommerce_button_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($button_text_format, '.button', false);
            
            // project thumbnail custom add to cart button text format
            $show_add_to_cart_button = get_theme_mod('lay_woocommerce_pt_show_add_to_cart_button', 0);
            if( $show_add_to_cart_button ) {
                if( get_theme_mod('lay_woocommerce_pt_use_custom_textformat', 1) == true ) {
                    $format = get_theme_mod('lay_woocommerce_pt_add_to_cart_textformat', 'Shop_Small');
                    $sharedStyles .= FormatsManager::get_textformat_css_for_selector($format, '.lay_woocommerce_product_thumbnail_title_wrap .button', false);
                }
            }

            $lay_woocommerce_space_leftright_mu = CSS_Output::get_mu('lay_woocommerce_space_leftright_mu', 'vw');
            $lay_woocommerce_space_top_mu = CSS_Output::get_mu('lay_woocommerce_space_top_mu', 'px');
            $lay_woocommerce_space_bottom_mu = CSS_Output::get_mu('lay_woocommerce_space_bottom_mu', 'px');

            // todo: are these selectors sufficient?
            $desktopAndTabletStyles .= CSS_Output::generate_css('#lay-woocommerce', 'margin-top', 'lay_woocommerce_space_top', 100, '', $lay_woocommerce_space_top_mu);    
            $desktopAndTabletStyles .= CSS_Output::generate_css('#lay-woocommerce', 'padding-bottom', 'lay_woocommerce_space_bottom', 100, '', $lay_woocommerce_space_bottom_mu);
            $desktopAndTabletStyles .= CSS_Output::generate_css('#lay-woocommerce', 'padding-left', 'lay_woocommerce_space_leftright', 2, '', $lay_woocommerce_space_leftright_mu);
            $desktopAndTabletStyles .= CSS_Output::generate_css('#lay-woocommerce', 'padding-right', 'lay_woocommerce_space_leftright', 2, '', $lay_woocommerce_space_leftright_mu);

            // todo: are these selectors sufficient?
            $mobileStyles .= CSS_Output::generate_css('#lay-woocommerce', 'margin-top', 'lay_woocommerce_mobile_space_top', 15, '', 'px');    
            $mobileStyles .= CSS_Output::generate_css('#lay-woocommerce', 'padding-bottom', 'lay_woocommerce_mobile_space_bottom', 25, '', 'px');
            $mobileStyles .= CSS_Output::generate_css('#lay-woocommerce', 'padding-left', 'lay_woocommerce_mobile_space_leftright', 15, '', 'px');
            $mobileStyles .= CSS_Output::generate_css('#lay-woocommerce', 'padding-right', 'lay_woocommerce_mobile_space_leftright', 15, '', 'px');

            // for a single product, i set the padding left and right of #lay-woocommerce to 0. This way the sliders (product slideshow and related slideshow can go to the edges)
            // that is why only the text and buttons in .summary should have the padding left and right
            $mobileStyles .= CSS_Output::generate_css('#lay-woocommerce .summary, .lay-woocommerce-gallery .swiper-slide, .upsells.products h2, .related.products h2, #lay-woocommerce .lay-woocommerce-related-products-scroller ul li', 'padding-left', 'lay_woocommerce_mobile_space_leftright', 15, '', 'px');
            $mobileStyles .= CSS_Output::generate_css('#lay-woocommerce .summary, .lay-woocommerce-gallery .swiper-slide, #lay-woocommerce .lay-woocommerce-related-products-scroller ul', 'padding-right', 'lay_woocommerce_mobile_space_leftright', 15, '', 'px');
            $mobileStyles .= CSS_Output::generate_css('.cart-collaterals', 'padding-top', 'lay_woocommerce_mobile_space_leftright', 15, '', 'px');
            
            // thumbnail
            $sharedStyles .= CSS_Output::generate_css('.lay-woocommerce-product-thumbnail-title', 'margin-top', 'lay_woocommerce_pt_spacetop', '12','', 'px');
            $sharedStyles .= CSS_Output::generate_css('.lay-woocommerce-product-thumbnail-price', 'margin-top', 'lay_woocommerce_pt_price_spacetop', '0','', 'px');
            $sharedStyles .= CSS_Output::generate_css('.lay_woocommerce_product_thumbnail-out_of_stock', 'margin-top', 'lay_woocommerce_pt_outofstock_spacetop', '2','', 'px');
            $sharedStyles .= CSS_Output::generate_css('.lay_woocommerce_product_thumbnail_title_wrap .add_to_cart_inline', 'margin-top', 'lay_woocommerce_pt_cart_button_spacetop', '15','', 'px');
            
            // buttons
            $button_style = get_theme_mod('lay_woocommerce_button_style', 'filled');
            $button_color = get_theme_mod('lay_woocommerce_button_color', '#000');
            $button_mouseover_color = get_theme_mod('lay_woocommerce_mouseover_button_color', '#000');
            $lay_woocommerce_button_padding_top_bottom = get_theme_mod('lay_woocommerce_button_padding_top_bottom', '11');
            $lay_woocommerce_button_padding_left_right = get_theme_mod('lay_woocommerce_button_padding_left_right', '15');
            $lay_woocommerce_button_text_color = get_theme_mod('lay_woocommerce_button_text_color', '#fff');

            // loading icon color in button
            $sharedStyles .= '
            .woocommerce a.button.loading::after, .woocommerce button.button.loading::after, .woocommerce input.button.loading::after, .woocommerce #respond input#submit.loading::after{
                border-color: '.$lay_woocommerce_button_text_color.' '.$lay_woocommerce_button_text_color.' rgba(0,0,0,0.1) rgba(0,0,0,0.1);
            }';

            $sharedStyles .= '#lay-woocommerce .button, .lay-content .button{ color:'.$lay_woocommerce_button_text_color.'; opacity: 1; }';
            $sharedStyles .= '#lay-woocommerce .button:hover, .lay-content .button:hover{ color:'.get_theme_mod('lay_woocommerce_button_mouseover_text_color', '#fff').'; }';
            $sharedStyles .= '#lay-woocommerce .button, .lay-content .button{ padding-top:'.$lay_woocommerce_button_padding_top_bottom.'px; padding-bottom:'.$lay_woocommerce_button_padding_top_bottom.'px; }';
            $sharedStyles .= '#lay-woocommerce .button, .lay-content .button{ padding-left:'.$lay_woocommerce_button_padding_left_right.'px; padding-right:'.$lay_woocommerce_button_padding_left_right.'px; }';
            $sharedStyles .= '#lay-woocommerce .button, .lay-content .button{ border-radius:'.get_theme_mod('lay_woocommerce_button_border_radius', 0).'px; }';
            
            $button_border_width = get_theme_mod('lay_woocommerce_button_border_width', '1');

            switch($button_style){
                case 'filled':
                    $sharedStyles .= '
                    #lay-woocommerce .button,
                    .lay-content .button{
                        background-color: '.$button_color.';
                        border-bottom: none!important;
                        border: none!important;
                    }
                    #lay-woocommerce .button:hover,
                    .lay-content .button:hover{
                        background-color: '.$button_mouseover_color.';
                    }
                    ';
                break;
                case 'outlines':
                    $sharedStyles .= '
                    #lay-woocommerce .button, 
                    .lay-content .button{
                        border-color: '.$button_color.';
                        border-bottom: '.$button_border_width.'px solid '.$button_color.'!important;
                        border-width: '.$button_border_width.'px;
                        border-style: solid;
                        background-color: transparent;
                    }
                    #lay-woocommerce .button:hover,
                    .lay-content .button:hover{
                        border-color: '.$button_mouseover_color.';
                        border-bottom-color: '.$button_mouseover_color.'!important;
                        background-color: transparent;
                    }
                    ';
                break;
            }
            if( get_theme_mod('lay_woocommerce_animate_mouseover_button_color', 0) == true ) {
                $sharedStyles .= '#lay-woocommerce .button, .lay-content .button{ transition: background-color 300ms ease, border-color 300ms ease, color 300ms ease; }';
            } else {
                $sharedStyles .= '#lay-woocommerce .button, .lay-content .button{ transition: none; }';
            }

            // store notice
            $lay_woocommerce_store_notice_textformat = get_theme_mod('lay_woocommerce_store_notice_textformat', 'Shop_Medium');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($lay_woocommerce_store_notice_textformat, '.woocommerce-store-notice', false);

            $lay_woocommerce_store_notice_background_color = get_theme_mod('lay_woocommerce_store_notice_background_color', '#e4e6e6');
            $lay_woocommerce_store_notice_text_color = get_theme_mod('lay_woocommerce_store_notice_text_color', '#000');
            $lay_woocommerce_store_notice_bottom_border_width = get_theme_mod('lay_woocommerce_store_notice_bottom_border_width', 0);
            $lay_woocommerce_store_notice_bottom_border_color = get_theme_mod('lay_woocommerce_store_notice_bottom_border_color', '#e4e6e6');
            $lay_woocommerce_store_notice_height = get_theme_mod('lay_woocommerce_store_notice_height', 40);

            $spaceright_mu = CSS_Output::get_mu('lay_woocommerce_store_notice_spaceright_mu', 'px');
            $sharedStyles .= CSS_Output::generate_css('.woocommerce-store-notice__dismiss-link', 'padding-right', 'lay_woocommerce_store_notice_spaceright', 12,'', $spaceright_mu);    

            if ( get_theme_mod('lay_woocommerce_show_dismiss_button', 1) != 1 ) {
                $sharedStyles .= '.woocommerce-store-notice__dismiss-link{ display: none; }';
            } 

            $sharedStyles .= '
            .woocommerce-store-notice .woocommerce-store-notice__dismiss-link svg > g > g{
                stroke: '.$lay_woocommerce_store_notice_text_color.';
            }
            .woocommerce-store-notice a{
                color:'.$lay_woocommerce_store_notice_text_color.'!important;
                border-bottom: 1px solid '.$lay_woocommerce_store_notice_text_color.';
            }
            .woocommerce-store-notice{ 
                color:'.$lay_woocommerce_store_notice_text_color.'!important;
                background-color:'.$lay_woocommerce_store_notice_background_color.';
                border-bottom-style: solid;
                border-bottom-color: '.$lay_woocommerce_store_notice_bottom_border_color.';
                border-bottom-width: '.$lay_woocommerce_store_notice_bottom_border_width.'px;
            }';

            // single product
            $headline_textformat = get_theme_mod('lay_woocommerce_singleproduct_headline_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($headline_textformat, '.lay-woocommerce-single-product-wrap h1.product_title', false);
            
            $sharedStyles .= CSS_Output::generate_css('body.single-product .lay-woocommerce-single-product-wrap h1.product_title', 'margin-bottom', 'lay_woocommerce_singleproduct_headline_spacebelow', '0', '', 'em');

            $shortdescr_textformat = get_theme_mod('lay_woocommerce_singleproduct_shortdescription_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($shortdescr_textformat, '.lay-woocommerce-single-product-wrap .woocommerce-product-details__short-description', false);
            
            $price_textformat = get_theme_mod('lay_woocommerce_singleproduct_price_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($price_textformat, '.lay-woocommerce-single-product-wrap .lay-woocommerce-summary-inner > .price', false);

            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product .lay-woocommerce-summary-inner>.price', 'margin-top', 'lay_woocommerce_singleproduct_price_spacetop', '1.3', '', 'em');
            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product .lay-woocommerce-summary-inner>.price', 'margin-bottom', 'lay_woocommerce_singleproduct_price_spacebelow', '1.3', '', 'em');

            $qty_textformat = get_theme_mod('lay_woocommerce_singleproduct_qty_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($qty_textformat, 'body.single-product div.product .quantity input.qty', false);
            
            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .lay-woocommerce-product-text', 'width', 'lay_woocommerce_singleproduct_text_width_2', '30', '', 'vw');

            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .summary', 'margin-top', 'lay_woocommerce_singleproduct_text_spacetop', '100', '', 'px');
            // for sticky
            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .summary', 'top', 'lay_woocommerce_singleproduct_text_sticky_spacetop', '100', '', 'px');

            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .summary', 'padding-left', 'lay_woocommerce_singleproduct_text_spaceleft', '2', '', '%');

            $related_headline_textformat = get_theme_mod('lay_woocommerce_singleproduct_related_products_headline_textformat', 'Shop_Product_Thumbnails');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($related_headline_textformat, 'body.single-product .related.products > h2, body.single-product .upsells.products > h2', false);

            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .upsells.products > h2', 'margin-top', 'lay_woocommerce_singleproduct_related_products_spacetop', '3', '', '%');
            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .related.products > h2', 'margin-top', 'lay_woocommerce_singleproduct_related_products_spacetop', '3', '', '%');

            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .upsells.products > h2', 'margin-bottom', 'lay_woocommerce_singleproduct_related_products_spacebottom', '1.5', '', '%');
            $desktopAndTabletStyles .= CSS_Output::generate_css('body.single-product #lay-woocommerce .related.products > h2', 'margin-bottom', 'lay_woocommerce_singleproduct_related_products_spacebottom', '1.5', '', '%');

            $variations_selectbox_textformat = get_theme_mod('lay_woocommerce_singleproduct_variations_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($variations_selectbox_textformat, '.lay-woocommerce-variations-select', false);

            // variations text like, variation price, variation description, stock
            $variation_text_textformat = get_theme_mod('lay_woocommerce_singleproduct_variations_text_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($variation_text_textformat, '.woocommerce-variation', false);

            // tabs or product description text format
            $product_tabs_text_textformat = get_theme_mod('lay_woocommerce_singleproduct_product_description_textformat', 'Shop_Small');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($product_tabs_text_textformat, '.lay-woocommerce-product-tab', false);

            // side cart
            if( LTUtility::is_sidecart_active() ) {
                $sharedStyles .= CSS_Output::generate_css('.xoo-wsc-container .xoo-wsc-header, .xoo-wsc-container .xoo-wsc-product, .xoo-wsc-container .xoo-wsc-ft-totals', 'border-color', 'lay_woocommerce_sidecart_line_color', '#000', '', '');
                $sharedStyles .= CSS_Output::generate_css('.xoo-wsc-body .xoo-wsc-sm-info .xoo-wsc-smr-del', 'color', 'lay_woocommerce_remove_item_color', '#aeaeae', '', '!important');
                
                // $format = get_theme_mod('lay_woocommerce_sidecart_header_textformat', 'Default');
                // $sharedStyles .= FormatsManager::get_textformat_css_for_selector($format, '.xoo-wsc-header .xoo-wscb-count, .xoo-wsc-header .xoo-wsch-close:before', false);

                $format = get_theme_mod('lay_woocommerce_sidecart_body_textformat', 'Shop_Cart');
                $sharedStyles .= FormatsManager::get_textformat_css_for_selector($format, '.xoo-wsc-body .xoo-wsc-sm-info, .xoo-wsc-body .xoo-wsc-sm-info span.amount, .xoo-wsc-body .xoo-wsc-sm-info a, .xoo-wsc-body .xoo-wsc-sm-info .xoo-wsc-smr-del', false, true);

                $format = get_theme_mod('lay_woocommerce_sidecart_footer_textformat', 'Shop_Big');
                $sharedStyles .= FormatsManager::get_textformat_css_for_selector($format, '.xoo-wsc-footer .xoo-wsc-ft-totals>div, .xoo-wsc-footer .xoo-wsc-ft-totals .amount', false);
                
                $sharedStyles .= CSS_Output::generate_css('.xoo-wsc-opac', 'background-color', 'lay_woocommerce_sidecart_background_color', '#000', '', '!important');
                $sharedStyles .= CSS_Output::generate_opacity_css('.xoo-wsc-cart-active .xoo-wsc-opac', 'lay_woocommerce_sidecart_background_opacity', 30, true);

                $sharedStyles .= CSS_Output::generate_css('.xoo-wsc-body .xoo-wsc-sm-info, .xoo-wsc-body .xoo-wsc-sm-info span.amount, .xoo-wsc-body .xoo-wsc-sm-info a, .xoo-wsc-header .xoo-wscb-count, .xoo-wsc-footer .xoo-wsc-ft-totals>div, .xoo-wsc-footer .xoo-wsc-ft-totals .amount', 'color', 'scb-txtcolor', Lay_SideCart::$sidecart_style_options['scb-txtcolor'], '', '!important');
            
                // side cart buttons
                // button text format
                $button_text_format = get_theme_mod('lay_woocommerce_sidecart_button_textformat', 'Shop_Big');
                $sharedStyles .= FormatsManager::get_textformat_css_for_selector($button_text_format, '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button', false);
            
                $button_style = get_theme_mod('lay_woocommerce_sidecart_button_style', 'filled');
                $button_color = get_theme_mod('lay_woocommerce_sidecart_button_color', '#000');
                $button_mouseover_color = get_theme_mod('lay_woocommerce_sidecart_mouseover_button_color', '#000');
                $lay_woocommerce_sidecart_button_padding_top_bottom = get_theme_mod('lay_woocommerce_sidecart_button_padding_top_bottom', '17');
                // $lay_woocommerce_sidecart_button_padding_left_right = get_theme_mod('lay_woocommerce_sidecart_button_padding_left_right', '20');
                $lay_woocommerce_sidecart_button_text_color = get_theme_mod('lay_woocommerce_sidecart_button_text_color', '#fff');

                $sharedStyles .= '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{ color:'.$lay_woocommerce_sidecart_button_text_color.'; }';
                $sharedStyles .= '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button:hover{ color:'.get_theme_mod('lay_woocommerce_sidecart_button_mouseover_text_color', '#fff').'; }';
                $sharedStyles .= '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{ padding-top:'.$lay_woocommerce_sidecart_button_padding_top_bottom.'px; padding-bottom:'.$lay_woocommerce_sidecart_button_padding_top_bottom.'px; }';
                // $sharedStyles .= '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{ padding-left:'.$lay_woocommerce_sidecart_button_padding_left_right.'px; padding-right:'.$lay_woocommerce_sidecart_button_padding_left_right.'px; }';
                $sharedStyles .= '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{ border-radius:'.get_theme_mod('lay_woocommerce_sidecart_button_border_radius', 0).'px }';

                $button_border_width = get_theme_mod('lay_woocommerce_sidecart_button_border_width', '0');

                switch($button_style){
                    case 'filled':
                        $sharedStyles .= '
                        .xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{
                            background-color: '.$button_color.';
                            border-bottom: none!important;
                            border: none!important;
                        }
                        .xoo-wsc-container .xoo-wsc-ft-buttons-cont .button:hover{
                            background-color: '.$button_mouseover_color.';
                        }
                        ';
                    break;
                    case 'outlines':
                        $sharedStyles .= '
                        .xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{
                            border-color: '.$button_color.';
                            border-bottom: '.$button_border_width.'px solid '.$button_color.'!important;
                            border-width: '.$button_border_width.'px;
                            border-style: solid;
                            background-color: transparent;
                        }
                        .xoo-wsc-container .xoo-wsc-ft-buttons-cont .button:hover{
                            border-color: '.$button_mouseover_color.';
                            border-bottom-color: '.$button_mouseover_color.'!important;
                            background-color: transparent;
                        }
                        ';
                    break;
                }

                if( get_theme_mod('lay_woocommerce_sidecart_animate_mouseover_button_color', 0) == true ) {
                    $sharedStyles .= '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{ transition: background-color 300ms ease, border-color 300ms ease, color 300ms ease; }';
                } else {
                    $sharedStyles .= '.xoo-wsc-container .xoo-wsc-ft-buttons-cont .button{ transition: none; }';
                }
            }
        
            // checkout
            $checkout_textformat = get_theme_mod('lay_woocommerce_checkout_product_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($checkout_textformat, '#lay-woocommerce .checkout.woocommerce-checkout input, #lay-woocommerce .checkout.woocommerce-checkout label, #lay-woocommerce .checkout.woocommerce-checkout textarea, #lay-woocommerce .checkout.woocommerce-checkout .selectize-input, #lay-woocommerce .checkout.woocommerce-checkout .selectize-dropdown, #lay-woocommerce .checkout.woocommerce-checkout h3', false);

            $cart_review_textformat = get_theme_mod('lay_woocommerce_checkout_order_review', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($cart_review_textformat, '#lay-woocommerce #order_review th, #lay-woocommerce #order_review td', false);

            $cart_payment_textformat = get_theme_mod('lay_woocommerce_checkout_payment', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($cart_payment_textformat, '#lay-woocommerce #payment', false);


            // normal cart
            $bordercolor = get_theme_mod('lay_woocommerce_cart_line_color', '#000');

            $cart_textformat = get_theme_mod('lay_woocommerce_cart_product_textformat', 'Shop_Cart');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($cart_textformat, '.lay-woocommerce-cart-inner', false);

            $cart_collaterals_textformat = get_theme_mod('lay_woocommerce_cart_collaterals_textformat', 'Shop_Big');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($cart_collaterals_textformat, '.cart-collaterals, #coupon_code', false);
            $sharedStyles .= 
            '#lay-woocommerce .woocommerce-cart-form__cart-item,
            .woocommerce .lay-woocommerce-cart-totals-inner table{
                border-color: '.$bordercolor.';
            }
            .cart-collaterals .actions{
                border-color: '.$bordercolor.';
            }
            .cart-column-1{
                width: '.get_theme_mod('lay_woocommerce_cart_product_image_width', 120).'px;
            }
            #lay-woocommerce .woocommerce-cart-form__cart-item a.lay-woocommerce-cart-remove-item{
                color: '.get_theme_mod('lay_woocommerce_normal_cart_remove_item_color', '#aeaeae').';
            }';

            // order page, the page that appears after sth was bought
            $orderpage_thankyou_textformat = get_theme_mod('lay_woocommerce_orderpage_thankyou', 'Shop_Order_Received');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($orderpage_thankyou_textformat, '.woocommerce-thankyou-order-received', false);

            $orderpage_titles_textformat = get_theme_mod('lay_woocommerce_orderpage_titles', 'Shop_Order_Received');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($orderpage_titles_textformat, '.woocommerce-order .woocommerce-column__title, .woocommerce-order .woocommerce-order-details__title, .woocommerce-order .wc-bacs-bank-details-heading, .woocommerce-order .wc-bacs-bank-details-account-name', false);

            $orderpage_textformat = get_theme_mod('lay_woocommerce_orderpage', 'Shop_Order_Received');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($orderpage_textformat, '.woocommerce-order', false);
        }

        // project title visibility
        $ptVisibility = get_theme_mod('pt_visibility', 'always-show');

        //project tags
        $sharedStyles .= CSS_Output::generate_visibility_css('.thumb .thumbnail-tags', 'ptags_visibility');
        // project tags should also only show up on mouseover if title should just show up on mouseover
        if($ptVisibility != 'show-on-mouseover'){
            $sharedStyles .= CSS_Output::generate_opacity_css('.thumb .thumbnail-tags', 'ptags_opacity', 100);
        }
        $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'margin-top', 'ptags_spacetop', '0','', 'px');
        $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'margin-bottom', 'ptags_spacebottom', '0','', 'px');
        if( get_theme_mod("ptags_textformat", "_Default") == "" ){
            $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'font-weight', 'ptags_fontweight', Customizer::$defaults['fontweight'], '', '');
            $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'letter-spacing', 'ptags_letterspacing', Customizer::$defaults['letterspacing'],'', 'em');
            $ptags_fontsize_mu = CSS_Output::get_mu('ptags_fontsize_mu', 'px');
            $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'font-size', 'ptags_fontsize', Customizer::$defaults['fontsize'],'', $ptags_fontsize_mu);
            $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'color', 'ptags_color', Customizer::$defaults['color']);
            $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'font-family', 'ptags_fontfamily', Customizer::$defaults['fontfamily']);
        }
        $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'text-align', 'ptags_align', 'left');
        $sharedStyles .= CSS_Output::generate_css('.thumb .thumbnail-tags', 'line-height', 'ptags_lineheight', Customizer::$defaults['lineheight'],'', '');

        // project title
        $sharedStyles .= CSS_Output::generate_mouseover_animate_visibility_css( '.thumb .title, .thumb .thumbnail-tags', 'pt_animate_visibility' );

        $sharedStyles .= CSS_Output::generate_visibility_css('.title', 'pt_visibility');
        if( $ptVisibility == 'show-on-mouseover' ) {
            $sharedStyles .= '.thumb .thumbnail-tags{opacity:0;}';
        }
        // project tags should also only show up on mouseover if title should just show up on mouseover
        $ptagsVisibility = get_theme_mod('ptags_visibility', 'always-show');
        if( $ptagsVisibility == 'always-show' && $ptVisibility == 'show-on-mouseover' ) {
            $sharedStyles .= CSS_Output::generate_opacity_css('.no-touchdevice .thumb:hover .thumbnail-tags, .touchdevice .thumb.hover .thumbnail-tags', 'ptags_opacity', 100);
        }

        if($ptVisibility == 'show-on-mouseover'){
            $sharedStyles .= CSS_Output::generate_opacity_css('.no-touchdevice .thumb:hover .title, .touchdevice .thumb.hover .title', 'pt_opacity', 100);  
        }else{
            $sharedStyles .= CSS_Output::generate_opacity_css('.title', 'pt_opacity', 100);
        }

        if( get_theme_mod("pt_textformat", "_Default") == "" ){
            $sharedStyles .= CSS_Output::generate_css('.title', 'font-weight', 'pt_fontweight', Customizer::$defaults['fontweight'], '', '');
            $sharedStyles .= CSS_Output::generate_css('.title', 'letter-spacing', 'pt_letterspacing', Customizer::$defaults['letterspacing'],'', 'em');
            $pt_fontsize_mu = CSS_Output::get_mu('pt_fontsize_mu', 'px');
            $sharedStyles .= CSS_Output::generate_css('.title', 'font-size', 'pt_fontsize', Customizer::$defaults['fontsize'],'', $pt_fontsize_mu);
            $sharedStyles .= CSS_Output::generate_css('.title', 'color', 'pt_color', Customizer::$defaults['color']);
            $sharedStyles .= CSS_Output::generate_css('.title', 'font-family', 'pt_fontfamily', Customizer::$defaults['fontfamily']);
        }
        $sharedStyles .= CSS_Output::generate_css('.title', 'text-align', 'pt_align', 'left');

        $sharedStyles .= CSS_Output::generate_css('.below-image .title', 'margin-top', 'pt_spacetop', '5','', 'px');
        $sharedStyles .= CSS_Output::generate_css('.above-image .title', 'margin-bottom', 'pt_spacetop', '5','', 'px');

        $sharedStyles .= CSS_Output::generate_css('.title', 'line-height', 'pt_lineheight', Customizer::$defaults['lineheight'],'', '');
        $sharedStyles .= CSS_Output::pt_generate_position_css('.titlewrap-on-image');


        //project description
        $sharedStyles .= CSS_Output::generate_mouseover_animate_visibility_css( '.thumb .descr', 'pd_animate_visibility' );

        $sharedStyles .= CSS_Output::generate_visibility_css('.thumb .descr', 'pd_visibility');
        $pdVisibility = get_theme_mod('pd_visibility', 'always-show');
        if($pdVisibility == 'show-on-mouseover'){
            $sharedStyles .= CSS_Output::generate_opacity_css('.no-touchdevice .thumb:hover .descr, .touchdevice .thumb.hover .descr', 'pd_opacity', 100);
        }else{
            $sharedStyles .= CSS_Output::generate_opacity_css('.thumb .descr', 'pd_opacity', 100);
        }

        $sharedStyles .= CSS_Output::generate_css('.thumb .descr', 'margin-top', 'pd_spacetop', '0','', 'px');
        $sharedStyles .= CSS_Output::generate_css('.thumb .descr', 'margin-bottom', 'pd_spacebottom', '0','', 'px');


        // pd position
        $pd_position = get_theme_mod('pd_position', 'below-image');
        $pt_position = get_theme_mod('pt_position', 'below-image');
        // when pt position is below or above and pd pos is on-image, do center css
        // otherwise, the pt alignment defines where pt and pd are (can be on-image-top-left, or on-image-top-right, on-image-bottom-left etc)
        if( $pd_position == 'on-image' && strpos($pt_position, 'on-image') === false ){
            $sharedStyles .= 
            '.titlewrap-on-image{
                top: 50%;
                left: 50%;
                -webkit-transform: translate(-50%,-50%);
                -moz-transform: translate(-50%,-50%);
                -ms-transform: translate(-50%,-50%);
                -o-transform: translate(-50%,-50%);
                transform: translate(-50%,-50%);
            }';
        }

        // project thumbnail mouseover
        $mod = get_theme_mod('fi_mo_show_color', '');
        if($mod == "1"){
            $sharedStyles .= CSS_Output::generate_css('.thumb .ph span', 'background-color', 'fi_mo_background_color', '#fff', '', '');
            if( LayFrontend_Options::$fi_mo_touchdevice_behaviour == 'mo_on_tap_alt' ) {
                $sharedStyles .= CSS_Output::generate_featured_image_opacity_css('.thumb:hover .ph span', 'fi_mo_color_opacity', 50);
            } else {
                $sharedStyles .= CSS_Output::generate_featured_image_opacity_css('.no-touchdevice .thumb:hover .ph span, .touchdevice .thumb.hover .ph span', 'fi_mo_color_opacity', 50);
            }
            $sharedStyles .= CSS_Output::generate_fi_mouseover_animate_bgcolor_css();
        }

        $mod = get_theme_mod('fi_mo_change_brightness', '');
        if($mod == "1"){
            if( LayFrontend_Options::$fi_mo_touchdevice_behaviour == 'mo_on_tap_alt' ) {
                $sharedStyles .= CSS_Output::generate_featured_image_brightness_css('.thumb:hover .ph', 'fi_mo_brightness', 50);
            } else {
                $sharedStyles .= CSS_Output::generate_featured_image_brightness_css('.no-touchdevice .thumb:hover .ph, .touchdevice .thumb.hover .ph', 'fi_mo_brightness', 50);
            }
            $sharedStyles .= CSS_Output::generate_fi_mouseover_animate_brightness_css();
        }

        $sharedStyles .= CSS_Output::generate_fi_mouseover_blur();
        $sharedStyles .= CSS_Output::generate_fi_mouseover_animate_blur();
        $sharedStyles .= CSS_Output::generate_fi_mouseover_zoom_css();

        // project arrows
        $pa_active = get_option('misc_options_show_project_arrows', '');

        if($pa_active == "on" && !MiscOptions::$locked){

            $pa_type = get_theme_mod('pa_type', 'icon');
            switch($pa_type){
                case 'icon':
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'color', 'pa_icon_color', '#000', '', '');
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'font-size', 'pa_icon_size', '20', '', 'px');
                break;
                case 'text':
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'font-family', 'pa_fontfamily', Customizer::$defaults['fontfamily']);
                    $pa_fontsize_mu = CSS_Output::get_mu('pa_fontsize_mu', 'px');
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'font-size', 'pa_fontsize', Customizer::$defaults['fontsize'],'', $pa_fontsize_mu);
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'font-weight', 'pa_fontweight', Customizer::$defaults['fontweight']);
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'letter-spacing', 'pa_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'color', 'pa_color', Customizer::$defaults['color'], '', '');
                break;
                case 'project-thumbnails':
                case 'custom-image':
                    $pa_width_mu = CSS_Output::get_mu('pa_width_mu', '%');
                    $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'width', 'pa_width', '10', '', $pa_width_mu);
                break;
            }

            $sharedStyles .= CSS_Output::generate_opacity_css('.project-arrow', 'pa_opacity', 100);
            $sharedStyles .= CSS_Output::generate_opacity_css('.no-touchdevice .project-arrow:hover', 'pa_mouseover_opacity', 100);

            $pa_spacetopbottom_mu = CSS_Output::get_mu('pa_spacetopbottom_mu', 'px');
            $sharedStyles .= CSS_Output::generate_css('.project-arrow.top', 'top', 'pa_spacetopbottom', '20', '', $pa_spacetopbottom_mu);
            $sharedStyles .= CSS_Output::generate_css('.project-arrow.bottom', 'bottom', 'pa_spacetopbottom', '20', '', $pa_spacetopbottom_mu);

            $pa_spaceleftright_mu = CSS_Output::get_mu('pa_spaceleftright_mu', 'px');
            $sharedStyles .= CSS_Output::generate_css('.project-arrow.pa-prev', 'left', 'pa_spaceleftright', '20', '', $pa_spaceleftright_mu);
            $sharedStyles .= CSS_Output::generate_css('.project-arrow.pa-next', 'right', 'pa_spaceleftright', '20', '', $pa_spaceleftright_mu);

            $sharedStyles .= CSS_Output::generate_css('.no-touchdevice .project-arrow:hover', 'color', 'pa_mouseover_color', '#000000', '', '');

            $sharedStyles .= CSS_Output::generate_css('.project-arrow', 'padding', 'pa_padding', '10', '', 'px');

            $mobileStyles .= CSS_Output::generate_hide_css('.project-arrow', 'pa_hide_on_phone');
        }

        // intro in intro.php

        // site title

		// if a textformat is selected, the html class is used by the dom element, so i don't need to create extra styles
		$st_textformat = get_theme_mod('st_textformat', 'Default');
		if($st_textformat == ""){
			// if no textformat was selected for st, generate css based on the individual customizer controls
			$st_fontsize_mu = CSS_Output::get_mu('st_fontsize_mu', 'px');
			$desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle-txt-inner', 'font-size', 'st_fontsize', Customizer::$defaults['fontsize'],'', $st_fontsize_mu);
			$desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle-txt-inner', 'font-weight', 'st_fontweight', Customizer::$defaults['fontweight']);
			$desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle-txt-inner', 'letter-spacing', 'st_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
			$desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle-txt-inner', 'color', 'st_color', Customizer::$defaults['color']);
			$desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle-txt-inner', 'font-family', 'st_fontfamily', Customizer::$defaults['fontfamily']);
			$desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle-txt-inner', 'text-align', 'st_align', 'left');
		}

        $st_spacetop_mu = CSS_Output::get_mu('st_spacetop_mu', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle', 'top', 'st_spacetop', Customizer::$defaults['st_spacetop'], '', $st_spacetop_mu);

        // !woocommerce! sticky top nav! needs same margin-top as top value, this way sticky will work properly
        // $desktopAndTabletStyles .= CSS_Output::generate_css('body.lay-woocommerce-show-store-notice .sitetitle.position-top', 'margin-top', 'st_spacetop', Customizer::$defaults['st_spacetop'], '', $st_spacetop_mu);

        $spaceleft_mu = CSS_Output::get_mu('st_spaceleft_mu', '%');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle', 'left', 'st_spaceleft', Customizer::$defaults['st_spaceleft'],'', $spaceleft_mu);

        $spaceright_mu = CSS_Output::get_mu('st_spaceright_mu', '%');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle', 'right', 'st_spaceright', Customizer::$defaults['st_spaceright'],'', $spaceright_mu);

        $spacebottom_mu = CSS_Output::get_mu('st_spacebottom_mu', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle', 'bottom', 'st_spacebottom', Customizer::$defaults['st_spacebottom'], '', $spacebottom_mu);

        $st_img_width_mu = CSS_Output::get_mu('st_img_width_mu', 'vw');
        if($st_img_width_mu == "%"){
            $st_img_width_mu = "vw";
        }
        $desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle img', 'width', 'st_img_width', '20', '', $st_img_width_mu);

        $desktopAndTabletStyles .= CSS_Output::generate_opacity_css('.sitetitle', 'st_opacity', 100);
        $desktopAndTabletStyles .= CSS_Output::generate_position_css('.sitetitle', 'st_position', 'top-left');
        $desktopAndTabletStyles .= CSS_Output::generate_is_fixed_css('.sitetitle', 'st_isfixed');

        $desktopAndTabletStyles .= CSS_Output::generate_hide_css('.sitetitle', 'st_hide', true);
        // $desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle.txt .sitetitle-txt-inner span', 'text-decoration-thickness', 'st_underline_strokewidth', Customizer::$defaults['underline_width'],'', 'px');
        $strokewidth = get_theme_mod('st_underline_strokewidth', Customizer::$defaults['underline_width']);
        if( $strokewidth > 0 ) {
            $desktopAndTabletStyles .= '.sitetitle.txt .sitetitle-txt-inner span{ 
                text-decoration-thickness:'.$strokewidth.'px;
                text-decoration-style: solid;
                text-decoration-line: underline;
            }';
        }

		// need to apply image alignment to .sitetitle wrapper, because img is display inline, this will not affect text-align of possible multiline tagline
		$desktopAndTabletStyles .= CSS_Output::generate_css('.sitetitle.img', 'text-align', 'st_image_alignment_in_relation_to_tagline', 'left', '', '');

        // site title mouseover
        $desktopAndTabletStyles .= CSS_Output::generate_css('.no-touchdevice .sitetitle.txt:hover .sitetitle-txt-inner span, .no-touchdevice .sitetitle:hover .tagline', 'color', 'stmouseover_color', Customizer::$defaults['color']);
        $desktopAndTabletStyles .= CSS_Output::generate_opacity_css('.no-touchdevice .sitetitle:hover', 'stmouseover_opacity', 100);

        if( get_theme_mod('stmouseover_fontweight', 'default') != 'default' ) {
            $desktopAndTabletStyles .= CSS_Output::generate_css('.no-touchdevice .sitetitle:hover span', 'font-weight', 'stmouseover_fontweight', '400');
        }

        $strokewidth = get_theme_mod('stmouseover_underline_strokewidth', Customizer::$defaults['underline_width']);
        if( $strokewidth > 0 ) {
            $desktopAndTabletStyles .= '.no-touchdevice .sitetitle.txt:hover .sitetitle-txt-inner span{ 
                text-decoration-thickness:'.$strokewidth.'px;
                text-decoration-style: solid;
                text-decoration-line: underline;
            }';
        } else {
            $desktopAndTabletStyles .= '.no-touchdevice .sitetitle.txt:hover .sitetitle-txt-inner span{ 
                text-decoration: none;
            }';
        }

        // tagline
		$tagline_textformat = get_theme_mod('tagline_textformat', 'Default');
		if($tagline_textformat == ""){
			$desktopAndTabletStyles .= CSS_Output::generate_css('.tagline', 'color', 'tagline_color', Customizer::$defaults['color']);
			$desktopAndTabletStyles .= CSS_Output::generate_css('.tagline', 'font-family', 'tagline_fontfamily', Customizer::$defaults['fontfamily']);

			$tagline_fontsize_mu = CSS_Output::get_mu('tagline_fontsize_mu', 'px');
			$desktopAndTabletStyles .= CSS_Output::generate_css('.tagline', 'font-size', 'tagline_fontsize', Customizer::$defaults['fontsize'],'', $tagline_fontsize_mu);

			$desktopAndTabletStyles .= CSS_Output::generate_css('.tagline', 'font-weight', 'tagline_fontweight', Customizer::$defaults['fontweight']);
			$desktopAndTabletStyles .= CSS_Output::generate_css('.tagline', 'letter-spacing', 'tagline_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');

			$desktopAndTabletStyles .= CSS_Output::generate_css('.tagline', 'text-align', 'tagline_align', 'left');
		}

        $desktopAndTabletStyles .= CSS_Output::generate_css('.tagline', 'margin-top', 'tagline_spacetop', 5, '', 'px');

        $desktopAndTabletStyles .= CSS_Output::generate_opacity_css('.tagline', 'tagline_opacity', 100);

        // navigation / menu
        $menuStyles = &$desktopAndTabletStyles;
        // this setting now doesn't show the desktop menu "primary menu" but it shows the "mobile-nav" in a desktop menu style
        $use_desktop_menu_as_mobile_menu = get_theme_mod('mobile_menu_style', 'style_1') == 'style_desktop_menu' ? 1 : 0;
        if($use_desktop_menu_as_mobile_menu == 1){
            $menuStyles = &$sharedStyles;
        }

        // get css of menus
        foreach( LayMenuCustomizerManager::$menu_customizer_instances as $menu ){
            $menu->get_css($desktopAndTabletStyles, $mobileStyles, $menuStyles, $sharedStyles, $use_desktop_menu_as_mobile_menu);
        }

        // navigation active
        // added .current_page_item for woocommerce pages, like "Shop"
        // .current-menu-parent, .current-menu-ancestor is needed for submenu parent menu point 
        $active_menupoint_selectors = ['.current-menu-item', '.current_page_item', '.current-menu-parent', '.current-menu-ancestor', '.current-lang'];
        for( $i = 0; $i < count($active_menupoint_selectors); $i++ ) {
            $active_menupoint_target = $active_menupoint_selectors[$i];
            $menuStyles .= CSS_Output::generate_css('nav.laynav '.$active_menupoint_target.'>a', 'color', 'navactive_color', Customizer::$defaults['color']);
            $menuStyles .= CSS_Output::generate_css('nav.laynav '.$active_menupoint_target.'>a', 'font-weight', 'navactive_fontweight', Customizer::$defaults['fontweight']);
            $strokewidth = get_theme_mod('navactive_underline_strokewidth', Customizer::$defaults['underline_width']);
            if( $strokewidth > 0 ) {
                $menuStyles .= CSS_Output::generate_css('nav.laynav '.$active_menupoint_target.'>a span', 'text-decoration-color', 'navactive_color', Customizer::$defaults['color'],'', '');
                $menuStyles .= CSS_Output::generate_css('nav.laynav '.$active_menupoint_target.'>a span', 'text-decoration-thickness', 'navactive_underline_strokewidth', Customizer::$defaults['underline_width'],'', 'px');
                $menuStyles .= 'nav.laynav '.$active_menupoint_target.'>a span{
                    text-decoration-style: solid;
                    text-decoration-line: underline;
                }';
            } else {
                $menuStyles .= 'nav.laynav '.$active_menupoint_target.'>a span{
                    text-decoration: none;
                }';
            }
            $menuStyles .= CSS_Output::generate_opacity_css('nav.laynav '.$active_menupoint_target.'>a', 'navactive_opacity', 100);
        }

        // navigation mouseover
        $menuStyles .= CSS_Output::generate_css('.no-touchdevice nav.laynav a:hover', 'color', 'navmouseover_color', Customizer::$defaults['color']);
        $menuStyles .= CSS_Output::generate_css('.no-touchdevice nav.laynav a:hover span', 'text-decoration-color', 'navmouseover_color', Customizer::$defaults['color']);
        if( get_theme_mod('navmouseover_fontweight', 'default') != 'default' ) {
            $menuStyles .= CSS_Output::generate_css('.no-touchdevice nav.laynav a:hover', 'font-weight', 'navmouseover_fontweight', Customizer::$defaults['fontweight']);
        }


        $navmouseover_underline_strokewidth = get_theme_mod('navmouseover_underline_strokewidth', Customizer::$defaults['underline_width']);
        
        if($navmouseover_underline_strokewidth > 0){
            $menuStyles .= CSS_Output::generate_css('.no-touchdevice nav.laynav a:hover span', 'text-decoration-thickness', 'navmouseover_underline_strokewidth', Customizer::$defaults['underline_width'],'', 'px');
            $menuStyles .= '.no-touchdevice nav.laynav a:hover span{ 
                text-decoration-style: solid;
                text-decoration-line: underline;
             }';
        } else {
            $menuStyles .= '.no-touchdevice nav.laynav a:hover span{ 
                text-decoration: none;
             }';
        }
        
        $menuStyles .= CSS_Output::generate_opacity_css('.no-touchdevice nav.laynav a:hover', 'navmouseover_opacity', 100);

        // background

        // #rows-region and .cover-region only exist if there is a cover
        // need to set bg color and bg image also for .lay-content.hascover #grid and .cover-region-placeholder and #footer-region to make cover feature work right
        // otherwise, the div below the first 100vh row will not overlay that row properly, because its bg would be transparent
        // a grid's background color needs to be able to overwrite the global background image and background color set here
        $background_targets = 'body, .hascover #footer-region, .cover-content, .cover-region';

        $sharedStyles .= CSS_Output::generate_css($background_targets, 'background-color', 'bg_color', '#ffffff');

        $bg_image = get_theme_mod('bg_image', "");
        $bg_video = get_theme_mod('bg_video', "");

        if($bg_image != "" && $bg_video == ""){
            $desktopAndTabletStyles .= $background_targets.'{ background-image:url('.$bg_image.'); }';
        }

        $bg_position = get_theme_mod('bg_position', 'standard');
        if($bg_position != 'standard'){
            switch ($bg_position) {
                case 'stretch':
                    $desktopAndTabletStyles .= $background_targets.'{ background-size:cover; background-attachment:fixed; background-repeat:no-repeat; background-position:center center;}';
                break;
                case 'center':
                    $desktopAndTabletStyles .= $background_targets.'{ background-repeat:no-repeat; background-attachment:fixed; background-position:center;}';
                break;
            }
        }

		// mobile background image
		$mobile_bg_image = get_theme_mod('mobile_bg_image', "");
        if($mobile_bg_image != ""){
            $mobileStyles .= $background_targets.'{ background-image:url('.$mobile_bg_image.'); }';
        }

        $mobile_bg_position = get_theme_mod('mobile_bg_position', 'standard');
        if($mobile_bg_position != 'standard'){
            switch ($mobile_bg_position) {
                case 'stretch':
                    $mobileStyles .= $background_targets.'{ background-size:cover; background-attachment:fixed; background-repeat:no-repeat; background-position:center center;}';
                break;
                case 'center':
                    $mobileStyles .= $background_targets.'{ background-repeat:no-repeat; background-attachment:fixed; background-position:center;}';
                break;
            }
        }

        // submenu
        $submenu_space_around = get_theme_mod('menu_submenu_spacearound', 10);
        $desktopAndTabletStyles .= '.laynav.desktop-nav.arrangement-horizontal .sub-menu{ left:-'.$submenu_space_around.'px; padding:'.$submenu_space_around.'px; }';
        $desktopAndTabletStyles .= '.laynav.desktop-nav.arrangement-vertical .sub-menu{ padding-left:'.$submenu_space_around.'px; padding-right:'.$submenu_space_around.'px; }';

        if( get_theme_mod('menu_submenu_show_on', 'hover') == 'always' ) {
            $desktopAndTabletStyles .= '.menu-item-has-children>.sub-menu{ display:block; }';
        }

        // space between menu points
        $desktopAndTabletStyles .= '.laynav.desktop-nav.arrangement-horizontal.submenu-type-vertical .menu-item-has-children .sub-menu li a{ padding-bottom: '.get_theme_mod('menu_submenu_space_between_submenu_points', 4).'px; }';
        $desktopAndTabletStyles .= '.laynav.desktop-nav.arrangement-horizontal.submenu-type-horizontal .menu-item-has-children .sub-menu li{ margin-right: '.get_theme_mod('menu_submenu_space_between_submenu_points', 4).'px; }';
        $desktopAndTabletStyles .= '.laynav.desktop-nav.arrangement-vertical .menu-item-has-children .sub-menu li{ margin-bottom: '.get_theme_mod('menu_submenu_space_between_submenu_points', 4).'px; }';

        // submenu spacetop/bottom
        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-horizontal.show-submenu-on-hover.position-top .menu-item-has-children:hover', 'padding-bottom', 'menu_submenu_spacetop', '0', '', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-horizontal.show-submenu-on-click.position-top .menu-item-has-children.show-submenu-desktop', 'padding-bottom', 'menu_submenu_spacetop', '0', '', 'px');
        // show always
        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-horizontal.show-submenu-on-always.position-top .menu-item-has-children', 'padding-bottom', 'menu_submenu_spacetop', '0', '', 'px');

        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-horizontal.show-submenu-on-hover.position-not-top .menu-item-has-children:hover', 'padding-top', 'menu_submenu_spacetop', '0', '', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-horizontal.show-submenu-on-click.position-not-top .menu-item-has-children.show-submenu-desktop', 'padding-top', 'menu_submenu_spacetop', '0', '', 'px');
        // show always
        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-horizontal.show-submenu-on-always.position-not-top .menu-item-has-children', 'padding-top', 'menu_submenu_spacetop', '0', '', 'px');

        // vertical
        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-vertical .sub-menu', 'padding-top', 'menu_submenu_spacetop', '0', '', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.laynav.desktop-nav.arrangement-vertical .sub-menu', 'padding-bottom', 'menu_submenu_spacetop', '0', '', 'px');


        // todo: check mobile desktop menu style for submenus!
        $menu_submenu_show_background = get_theme_mod('menu_submenu_show_background', 0);
        if( $menu_submenu_show_background ) {
            $menu_submenu_background_opacity = get_theme_mod('menu_submenu_background_opacity', '100');
            $desktopAndTabletStyles .= CSS_Output::generate_rgba('.sub-menu', 'background-color', 'menu_submenu_background_color', '#ffffff', $menu_submenu_background_opacity);

            $submenu_blurry = get_theme_mod('menu_submenu_blurry', '');
            if( $submenu_blurry == '1' ) {
                $blur = get_theme_mod('submenu_blur_amount', 20);
                $desktopAndTabletStyles .= 
                '.sub-menu{
                    -webkit-backdrop-filter: saturate(180%) blur('.$blur.'px);
                    backdrop-filter: saturate(180%) blur('.$blur.'px);
                }';
            }
        
        }

        // navigation bar
        $desktopAndTabletStyles .= CSS_Output::generate_navbar_position();

        $navbar_height_mu = CSS_Output::get_mu('navbar_height_mu', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.navbar', 'height', 'navbar_height', '60', '', $navbar_height_mu);
        $mod = get_theme_mod('navbar_hide', 0);
        if($mod == '1') {
            $desktopAndTabletStyles .= '.navbar{display:none;}';
        } else {
            $desktopAndTabletStyles .= '.navbar{display:block;}';
        }

        $navbar_blurry = get_theme_mod('navbar_blurry', '');
        if( $navbar_blurry == '1' ) {
            $blur = get_theme_mod('navbar_blur_amount', 20);
            $desktopAndTabletStyles .= 
            '.navbar{
                -webkit-backdrop-filter: saturate(180%) blur('.$blur.'px);
                backdrop-filter: saturate(180%) blur('.$blur.'px);
            }';
        }

        if(CSS_Output::navbar_get_hide_when_scrolling_down() == 1){
            $desktopAndTabletStyles .=
            '.navbar{
                -webkit-transition: transform 350ms ease;
                -moz-transition: transform 350ms ease;
                transition: transform 350ms ease;
            }';            
        }
        
        if(CSS_Output::nav_get_hide_when_scrolling_down('primary') == 1){
            $desktopAndTabletStyles .=
            'nav.primary{
                -webkit-transition: transform 350ms ease;
                -moz-transition: transform 350ms ease;
                transition: transform 350ms ease;
            }';
        }
        if(CSS_Output::nav_get_hide_when_scrolling_down('second_menu') == 1){
            $desktopAndTabletStyles .=
            'nav.second_menu{
                -webkit-transition: transform 350ms ease;
                -moz-transition: transform 350ms ease;
                transition: transform 350ms ease;
            }';
        }
        if(CSS_Output::nav_get_hide_when_scrolling_down('third_menu') == 1){
            $desktopAndTabletStyles .=
            'nav.third_menu{
                -webkit-transition: transform 350ms ease;
                -moz-transition: transform 350ms ease;
                transition: transform 350ms ease;
            }';
        }
        if(CSS_Output::nav_get_hide_when_scrolling_down('fourth_menu') == 1){
            $desktopAndTabletStyles .=
            'nav.fourth_menu{
                -webkit-transition: transform 350ms ease;
                -moz-transition: transform 350ms ease;
                transition: transform 350ms ease;
            }';
        }

        // fadeout when scrolling down
        if(CSS_Output::navbar_get_fadeout_when_scrolling_down() == 1){
            $desktopAndTabletStyles .=
            '.navbar{
                -webkit-transition: transform 350ms ease, opacity 350ms ease;
                -moz-transition: transform 350ms ease, opacity 350ms ease;
                transition: transform 350ms ease, opacity 350ms ease;
            }';            
        }
        
        if(CSS_Output::nav_get_fadeout_when_scrolling_down('primary') == 1){
            $desktopAndTabletStyles .=
            'nav.primary{
                -webkit-transition: transform 350ms ease, opacity 350ms ease;
                -moz-transition: transform 350ms ease, opacity 350ms ease;
                transition: transform 350ms ease, opacity 350ms ease;
            }';
        }
        if(CSS_Output::nav_get_fadeout_when_scrolling_down('second_menu') == 1){
            $desktopAndTabletStyles .=
            'nav.second_menu{
                -webkit-transition: transform 350ms ease, opacity 350ms ease;
                -moz-transition: transform 350ms ease, opacity 350ms ease;
                transition: transform 350ms ease, opacity 350ms ease;
            }';
        }
        if(CSS_Output::nav_get_fadeout_when_scrolling_down('third_menu') == 1){
            $desktopAndTabletStyles .=
            'nav.third_menu{
                -webkit-transition: transform 350ms ease, opacity 350ms ease;
                -moz-transition: transform 350ms ease, opacity 350ms ease;
                transition: transform 350ms ease, opacity 350ms ease;
            }';
        }
        if(CSS_Output::nav_get_fadeout_when_scrolling_down('fourth_menu') == 1){
            $desktopAndTabletStyles .=
            'nav.fourth_menu{
                -webkit-transition: transform 350ms ease, opacity 350ms ease;
                -moz-transition: transform 350ms ease, opacity 350ms ease;
                transition: transform 350ms ease, opacity 350ms ease;
            }';
        }
        // # fade out when scrolling down

        $st_hidewhenscroll = CSS_Output::st_get_hide_when_scrolling_down();
        if($st_hidewhenscroll == 1){
            $desktopAndTabletStyles .=
            '.sitetitle{
                -webkit-transition: transform 350ms ease;
                -moz-transition: transform 350ms ease;
                transition: transform 350ms ease;
            }';
        }

        $st_fadeout_whenscroll = CSS_Output::st_get_fadeout_when_scrolling_down();
        if($st_fadeout_whenscroll == 1){
            $desktopAndTabletStyles .=
            '.sitetitle{
                -webkit-transition: transform 350ms ease, opacity 350ms ease;
                -moz-transition: transform 350ms ease, opacity 350ms ease;
                transition: transform 350ms ease, opacity 350ms ease;
            }';
        }
        // $desktopAndTabletStyles .= CSS_Output::generate_opacity_css('.navbar', 'navbar_opacity', 90);
        $menubar_opacity = get_theme_mod('navbar_opacity', 90);
        $desktopAndTabletStyles .= CSS_Output::generate_rgba('.navbar', 'background-color', 'navbar_color', '#ffffff', $menubar_opacity);

        $desktopAndTabletStyles .= CSS_Output::generate_navbar_border_color_css();
        $desktopAndTabletStyles .= CSS_Output::generate_css('.navbar', 'border-color', 'navbar_border_color', '#cccccc');

        // links in texts and next project / prev project links, and in carousel captions, woocommerce, site title and navigation, and project arrows as text :D
        $sharedStyles .= '
        .sitetitle.txt .sitetitle-txt-inner span,
        nav.laynav a span{
            text-underline-offset: '.get_theme_mod('link_underline_offset', 3).get_theme_mod('link_underline_offset_mu', 'px').';
        }';

        $link_fontweight = get_theme_mod('link_fontweight', 'default');
        if( $link_fontweight != 'default' ) {
            $sharedStyles .= CSS_Output::generate_css(
                '.lay-textformat-parent a:not(.laybutton),
                a.projectlink .lay-textformat-parent>*:not(.laybutton),
                .lay-carousel-sink .single-caption-inner a:not(.laybutton),
                .lay-marquee p a:not(.laybutton), .link-in-text', 'font-weight', 'link_fontweight', '400');        
        }

        $sharedStyles .= CSS_Output::generate_css(
            '.lay-textformat-parent a:not(.laybutton),
            a.projectlink .lay-textformat-parent>*:not(.laybutton),
            .lay-carousel-sink .single-caption-inner a:not(.laybutton),
            .lay-marquee p a:not(.laybutton), .link-in-text', 'color', 'link_color', '#000');
        $strokewidth = get_theme_mod('link_underline_strokewidth', 1);

        if( intval($strokewidth) > 0 ) {
            $sharedStyles .= '.lay-textformat-parent a:not(.laybutton),
            a.projectlink .lay-textformat-parent>*:not(.laybutton),
            .lay-carousel-sink .single-caption-inner a:not(.laybutton),
            .lay-marquee p a:not(.laybutton), .link-in-text,
            .pa-text .pa-inner{
                text-decoration-thickness:'.$strokewidth.'px;
                text-decoration-style: solid;
                text-decoration-line: underline;
                text-underline-offset: '.get_theme_mod('link_underline_offset', 3).get_theme_mod('link_underline_offset_mu', 'px').';
            }';
        }

        // links in texts mouseover / prev project links mouseover, and in carousel captions, woocommerce
        $desktopAndTabletStyles .= CSS_Output::generate_css(
            '.no-touchdevice .lay-textformat-parent a:not(.laybutton):hover,
            .no-touchdevice a.projectlink .lay-textformat-parent>*:not(.laybutton):hover,
            .no-touchdevice .lay-carousel-sink .single-caption-inner a:not(.laybutton):hover,
            .no-touchdevice .lay-marquee p a:not(.laybutton):hover,
            .no-touchdevice .link-in-text:hover',
            'color', 'link_hover_color', '#000');
        $strokewidth = get_theme_mod('link_hover_underline_strokewidth', get_theme_mod('link_underline_strokewidth', 1));
        if( intval($strokewidth) > 0 ) {
            $desktopAndTabletStyles .= 
            '.no-touchdevice .lay-textformat-parent a:not(.laybutton):hover,
            .no-touchdevice a.projectlink .lay-textformat-parent>*:not(.laybutton):hover,
            .no-touchdevice .lay-carousel-sink .single-caption-inner a:not(.laybutton):hover,
            .no-touchdevice .lay-marquee p a:not(.laybutton):hover,
            .no-touchdevice .link-in-text:hover,
            .no-touchdevice .pa-text:hover .pa-inner{
                text-decoration-thickness:'.$strokewidth.'px;
                text-decoration-style: solid;
                text-decoration-line: underline;
             }';
        } else {
            $desktopAndTabletStyles .= 
            '.no-touchdevice .lay-textformat-parent a:not(.laybutton):hover,
            .no-touchdevice a.projectlink .lay-textformat-parent>*:not(.laybutton):hover,
            .no-touchdevice .lay-carousel-sink .single-caption-inner a:not(.laybutton):hover,
            .no-touchdevice .lay-marquee p a:not(.laybutton):hover,
            .no-touchdevice .link-in-text:hover,
            .no-touchdevice .pa-text:hover .pa-inner{
                text-decoration: none;
             }';
        }

        $link_hover_fontweight = get_theme_mod('link_hover_fontweight', $link_fontweight);
        if( $link_hover_fontweight != 'default' ) {
            $desktopAndTabletStyles .= 
            '.no-touchdevice .lay-textformat-parent a:not(.laybutton):hover,
            .no-touchdevice a.projectlink .lay-textformat-parent>*:not(.laybutton):hover,
            .no-touchdevice .lay-carousel-sink .single-caption-inner a:not(.laybutton):hover,
            .no-touchdevice .lay-marquee p a:not(.laybutton):hover,
            .no-touchdevice .link-in-text:hover{
                font-weight: '.$link_hover_fontweight.';
             }';
        }
        
        $desktopAndTabletStyles .= CSS_Output::generate_opacity_css(
            '.no-touchdevice .lay-textformat-parent a:not(.laybutton):hover,
            .no-touchdevice a.projectlink .lay-textformat-parent>*:not(.laybutton):hover,
            .no-touchdevice .lay-carousel-sink .single-caption-inner a:not(.laybutton):hover,
            .no-touchdevice .lay-marquee p a:not(.laybutton):hover,
            .no-touchdevice .link-in-text:hover', 'link_hover_opacity', 100);

        // thumbnailgrid filter category
        // if a textformat is selected, the html class is used by the dom element, so i don't need to create extra styles
		$tgf_textformat = get_theme_mod('tgf_textformat', 'Default');
		if($tgf_textformat == ""){
			// if no textformat was selected for st, generate css based on the individual customizer controls
			$tgf_fontsize_mu = CSS_Output::get_mu('tgf_fontsize_mu', 'px');
			$sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'font-size', 'tgf_fontsize', Customizer::$defaults['fontsize'],'', $tgf_fontsize_mu);
			$sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'font-weight', 'tgf_fontweight', Customizer::$defaults['fontweight']);
			$sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'letter-spacing', 'tgf_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
			$sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'color', 'tgf_color', Customizer::$defaults['color']);
			$sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'font-family', 'tgf_fontfamily', Customizer::$defaults['fontfamily']);
			$sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'text-align', 'tgf_align', 'left');
        }
        $d = get_theme_mod('tgf_color', Customizer::$defaults['color']);
        $sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter .lay-filter-active', 'color', 'tgf_active_color', $d);

        $sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter', 'margin-bottom', 'tgf_spacebelow', '20', '', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-filter-anchor', 'margin-right', 'tgf_spacebetween_2', '10', '', 'px');
        $mobileStyles .= CSS_Output::generate_css('.mobile-one-line .lay-thumbnailgrid-filter-anchor', 'margin-right', 'tgf_spacebetween_mobile', '10', '', 'px');
        // $mobileStyles .= CSS_Output::generate_css('.mobile-one-line .lay-thumbnailgrid-filter-anchor', 'margin-left', 'tgf_spacebetween_mobile', '10', '', 'px');

        $mobileStyles .= CSS_Output::generate_css('.mobile-not-one-line .lay-thumbnailgrid-filter-anchor', 'margin', 'tgf_spacebetween_mobile', '10', '', 'px');

        $sharedStyles .= CSS_Output::generate_opacity_css('.lay-thumbnailgrid-filter-anchor', 'tgf_opacity', 50);

        $sharedStyles .= CSS_Output::generate_opacity_css('.lay-thumbnailgrid-filter-anchor.lay-filter-active', 'tgf_active_opacity', 100);
        $sharedStyles .= CSS_Output::generate_opacity_css('@media (hover) {.lay-thumbnailgrid-filter-anchor:hover', 'tgf_mouseover_opacity', 100);
        // close media query
        $sharedStyles .= '}';
        $tgf_active_strokewidth = get_theme_mod('tgf_active_strokewidth', 0);
        if( $tgf_active_strokewidth > 0 ) {
            $sharedStyles .= '
            .lay-thumbnailgrid-filter-anchor{
                text-decoration-thickness:'.$tgf_active_strokewidth.'px;
                text-decoration-color: transparent;
                text-decoration-style: solid;
                text-decoration-line: underline;
                text-underline-offset: '.get_theme_mod('link_underline_offset', 3).get_theme_mod('link_underline_offset_mu', 'px').';
            }
            .lay-thumbnailgrid-filter-anchor.lay-filter-active{
                text-decoration-color: inherit;
            }';
        }

        // tags filter for thumbnailgrid
        // if a textformat is selected, the html class is used by the dom element, so i don't need to create extra styles
		$tgtf_textformat = get_theme_mod('tgtf_textformat', 'Default');
		if($tgtf_textformat == ""){
			// if no textformat was selected for st, generate css based on the individual customizer controls
			$tgtf_fontsize_mu = CSS_Output::get_mu('tgtf_fontsize_mu', 'px');
			$sharedStyles .= CSS_Output::generate_css('.tag-bubble', 'font-size', 'tgtf_fontsize', Customizer::$defaults['fontsize'],'', $tgtf_fontsize_mu);
			$sharedStyles .= CSS_Output::generate_css('.tag-bubble', 'font-weight', 'tgtf_fontweight', Customizer::$defaults['fontweight']);
			$sharedStyles .= CSS_Output::generate_css('.tag-bubble', 'letter-spacing', 'tgtf_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
			$sharedStyles .= CSS_Output::generate_css('.tag-bubble', 'color', 'tgtf_color', Customizer::$defaults['color']);
			$sharedStyles .= CSS_Output::generate_css('.tag-bubble', 'font-family', 'tgtf_fontfamily', Customizer::$defaults['fontfamily']);
        }
        $sharedStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-tagfilter', 'margin-bottom', 'tgtf_spacebelow', '20', '', 'px');
        $desktopAndTabletStyles .= CSS_Output::generate_css('.tag-bubble', 'margin', 'tgtf_spacebetween', '10', '', 'px');
        
        $mobileStyles .= CSS_Output::generate_css('.mobile-one-line .tag-bubble', 'margin-right', 'tgtf_spacebetween_mobile', '10', '', 'px');
        $mobileStyles .= CSS_Output::generate_css('.mobile-not-one-line .tag-bubble', 'margin', 'tgtf_spacebetween_mobile', '10', '', 'px');

        $desktopAndTabletStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-tagfilter', 'margin-left', 'tgtf_spacebetween', '10', '-', 'px');
        $mobileStyles .= CSS_Output::generate_css('.lay-thumbnailgrid-tagfilter', 'margin-left', 'tgtf_spacebetween_mobile', '10', '-', 'px');

        $sharedStyles .= CSS_Output::generate_css('.tag-bubble', 'background-color', 'tgtf_bubble_color', '#eeeeee');
        $sharedStyles .= CSS_Output::generate_css('.tag-bubble', 'border-radius', 'tgtf_bubble_border_radius', '100', '', 'px');
        $sharedStyles .= CSS_Output::generate_css('@media (hover:hover) {.tag-bubble:hover', 'background-color', 'tgtf_bubble_active_color', '#d0d0d0');
        // close media query
        $sharedStyles .= '}';
        $sharedStyles .= CSS_Output::generate_css('.tag-bubble.lay-tag-active', 'background-color', 'tgtf_bubble_active_color', '#d0d0d0');

        // mobile
        // all of this just applies to automatically generated phone layouts (#grid), not custom phone layouts (.hascustomphonegrid)
        $mobile_space_between_elements_mu = CSS_Output::get_mu('mobile_space_between_elements_mu', '%');
        $mobile_space_leftright_mu = CSS_Output::get_mu('mobile_space_leftright_mu', 'vw');
        $mobile_space_top_mu = CSS_Output::get_mu('mobile_space_top_mu', 'vw');
        $mobile_space_bottom_mu = CSS_Output::get_mu('mobile_space_bottom_mu', 'vw');

        $mobile_space_top_footer_mu = CSS_Output::get_mu('mobile_space_top_footer_mu', 'vw');
        $mobile_space_bottom_footer_mu = CSS_Output::get_mu('mobile_space_bottom_footer_mu', 'vw');

        // on mobile, I just have margin between elements(cols), not between rows
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid #grid .col, .lay-content.footer-nocustomphonegrid #footer .col', 'margin-bottom', 'mobile_space_between_elements', 5, '', $mobile_space_between_elements_mu);
        // for cols in cover
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid .cover-region .col', 'margin-bottom', 'mobile_space_between_elements', 5, '', $mobile_space_between_elements_mu);

        // when a row is empty and height of browserheight (probably with a row bg) then it should have a margin-bottom like a col
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid #grid .row.empty._100vh, .lay-content.footer-nocustomphonegrid #footer .row.empty._100vh', 'margin-bottom', 'mobile_space_between_elements', 5, '', $mobile_space_between_elements_mu);
        // when a row has a background image, it should have a margin-bottom like a col 
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid #grid .row.has-background, .lay-content.footer-nocustomphonegrid #footer .row.has-background', 'margin-bottom', 'mobile_space_between_elements', 5, '', $mobile_space_between_elements_mu);
				
        // space between when cover - this gives a "space between" to the top of the content region after the cover
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid.hascover #grid', 'padding-top', 'mobile_space_between_elements', 5, '', $mobile_space_between_elements_mu);

        // left and right space, only for APL
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid #grid .row, .lay-content.nocustomphonegrid .cover-region-desktop .row, .lay-content.footer-nocustomphonegrid #footer .row', 'padding-left', 'mobile_space_leftright', 5, '', $mobile_space_leftright_mu);
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid #grid .row, .lay-content.nocustomphonegrid .cover-region-desktop .row, .lay-content.footer-nocustomphonegrid #footer .row', 'padding-right', 'mobile_space_leftright', 5, '', $mobile_space_leftright_mu);

        // new: apl overflow
        $lr = get_theme_mod('mobile_space_leftright', 5);
        $lr_mu = $mobile_space_leftright_mu;

        $fovl_sel = '.frame-overflow-left';
        $fovr_sel = '.frame-overflow-right';
        $fovb_sel = '.frame-overflow-both';
        
        $do_overflow_on_apl = get_option('misc_options_enable_frame_overflows_for_apl', 'on');

        if($do_overflow_on_apl == 'on') {
                 // overflow both apl
                $mobileStyles .= 
                '.lay-content.nocustomphonegrid #grid .col'.$fovb_sel.',
                .lay-content.nocustomphonegrid .cover-region-desktop .col'.$fovb_sel.',
                .lay-content.footer-nocustomphonegrid #footer .col'.$fovb_sel.'{
                    width: calc( 100% + '.$lr.$lr_mu.' * 2 );
                    left: -'.$lr.$lr_mu.';
                }';

                // overflow left apl
                $mobileStyles .= 
                '.lay-content.nocustomphonegrid #grid .col'.$fovr_sel.',
                .lay-content.nocustomphonegrid .cover-region-desktop .col'.$fovr_sel.',
                .lay-content.footer-nocustomphonegrid #footer .col'.$fovr_sel.'{
                    width: calc( 100% + '.$lr.$lr_mu.' );
                }';

                // overflow right apl
                $mobileStyles .= 
                '.lay-content.nocustomphonegrid #grid .col'.$fovl_sel.',
                .lay-content.nocustomphonegrid .cover-region-desktop .col'.$fovl_sel.',
                .lay-content.footer-nocustomphonegrid #footer .col'.$fovl_sel.'{
                    width: calc( 100% + '.$lr.$lr_mu.' );
                    left: -'.$lr.$lr_mu.';
                }';   
        }

        // new: space top and bottom, only for APL
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid #grid', 'padding-bottom', 'mobile_space_bottom', 5, '', $mobile_space_bottom_mu);
        $mobileStyles .= CSS_Output::generate_css('.lay-content.nocustomphonegrid #grid', 'padding-top', 'mobile_space_top', 5, '', $mobile_space_top_mu);
        // space top for cover
        // TODO: i think i dont need this, i think i never need space top for a cover, bc theres never supposed to be a gap above cover, it is supposed to be always 100vh
        // $mobileStyles .= CSS_Output::generate_css('.nocustomphonegrid .cover-region', 'padding-top', 'mobile_space_top', 5, '', $mobile_space_top_mu);
        $mobileStyles .= CSS_Output::generate_css('.nocustomphonegrid .cover-region .column-wrap', 'padding-top', 'mobile_space_top', 5, '', $mobile_space_top_mu);

        // new: space top and bottom footer
        $mobileStyles .= CSS_Output::generate_css('.lay-content.footer-nocustomphonegrid #footer', 'padding-bottom', 'mobile_space_bottom_footer', 5, '', $mobile_space_bottom_footer_mu);
        $mobileStyles .= CSS_Output::generate_css('.lay-content.footer-nocustomphonegrid #footer', 'padding-top', 'mobile_space_top_footer', 5, '', $mobile_space_top_footer_mu);

        // cursor
        $cursor = get_theme_mod('lay_cursor', '');
        if( $cursor != '' ) {
            $sharedStyles .= 'body, a{ cursor: url('.get_theme_mod('lay_cursor', '').') '.get_theme_mod('lay_cursor_x', 0).' '.get_theme_mod('lay_cursor_y', 0).', auto }';
        }

        // search
        // public static function generate_css( $selector, $style, $mod_name, $default, $prefix='', $postfix='' ) {

        // $search_autosuggest_hide = get_theme_mod('search_autosuggest_hide', false);
        $sharedStyles .= CSS_Output::generate_css('input#search-query, .suggest-item', 'font-family', 'search_fontfamily', Customizer::$defaults['fontfamily']);

        $search_bg_opacity = get_theme_mod('search_background_opacity', 85);
        $sharedStyles .= CSS_Output::generate_rgba('.search-view', 'background-color', 'search_background_color', '#ffffff', $search_bg_opacity);

        $sharedStyles .= CSS_Output::generate_css('input#search-query::selection', 'background', 'search_text_selection_color', '#f5f5f5', '', '');

        $sharedStyles .= CSS_Output::generate_css('.close-search', 'color', 'search_close_color', '#000000', '', '');
        // $sharedStyles .= CSS_Output::generate_css('input#search-query', 'border-bottom-color', 'search_bar_line_color', '#000000', '', '');
        // $sharedStyles .= CSS_Output::generate_css('.search-view .search-icon path', 'fill', 'search_bar_placeholder_color', '#ccc', '', '');
        $sharedStyles .= CSS_Output::generate_css('input#search-query::placeholder', 'color', 'search_bar_placeholder_color', '#ccc', '', '');
        $sharedStyles .= CSS_Output::generate_css('input#search-query', 'color', 'search_text_color', '#000', '', '');

        $sharedStyles .= CSS_Output::generate_css('.suggest-item', 'color', 'search_autosuggest_text_color', '#aaa', '', '');
        $sharedStyles .= CSS_Output::generate_css('@media (hover:hover) {.suggest-item:hover', 'color', 'search_autosuggest_mouseover_text_color', '#000', '', '');
        // close media query
        $sharedStyles .= '}';
        $blurry = get_theme_mod('search_background_blurry', true);
        if( $blurry == true ) {
            $sharedStyles .= '.search-view{ -webkit-backdrop-filter: saturate(180%) blur(10px);
            backdrop-filter: saturate(180%) blur(10px); }';
        }

        if( get_theme_mod('search_use_textformat', false) == 1 ) {
            $search_textformat = get_theme_mod('search_textformat', 'Default');
            $sharedStyles .= FormatsManager::get_textformat_css_for_selector($search_textformat, 'input#search-query', false);
        }
        
        // get_theme_mod('search_background_color', '#ffffff');

        // buttons
        $bgcolor1 = get_theme_mod('laybutton1_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton1_background_color', '#ffffff');
        $bgcolor1_mo = get_theme_mod('laybutton1_mo_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton1_mo_background_color', '#ffffff');

        $laybutton1_textformat = get_theme_mod('laybutton1_textformat', 'Default');
        $sharedStyles .= FormatsManager::get_textformat_css_for_selector($laybutton1_textformat, '.laybutton1', false);
        $sharedStyles .= 
        '.laybutton1{
            color: '.get_theme_mod('laybutton1_text_color', '#000').';
            border-radius: '.get_theme_mod('laybutton1_borderradius', 0).'px;
            background-color: '.$bgcolor1.';
            border: '.get_theme_mod('laybutton1_borderwidth', 1).'px solid '.get_theme_mod('laybutton1_border_color', '#000000').';
            padding-left: '.get_theme_mod('laybutton1_paddingleftright', 15).'px;
            padding-right: '.get_theme_mod('laybutton1_paddingleftright', 15).'px;
            padding-top: '.get_theme_mod('laybutton1_paddingtop', 5).'px;
            padding-bottom: '.get_theme_mod('laybutton1_paddingbottom', 5).'px;
            margin-left: '.get_theme_mod('laybutton1_marginleftright', 0).'px;
            margin-right: '.get_theme_mod('laybutton1_marginleftright', 0).'px;
            margin-top: '.get_theme_mod('laybutton1_margintop', 0).'px;
            margin-bottom: '.get_theme_mod('laybutton1_marginbottom', 0).'px;
            '.( get_theme_mod('laybutton1_animate_mouseover', false) == true ? 'transition: all 200ms ease;' : '' ).'
        }';
        if( get_theme_mod('laybutton1_use_mouseover', false) == true ) {
            $sharedStyles .= 
            '.laybutton1:hover{
                color: '.get_theme_mod('laybutton1_mo_text_color', '#000').';
                background-color: '.$bgcolor1_mo.';
                border: '.get_theme_mod('laybutton1_mo_borderwidth', 1).'px solid '.get_theme_mod('laybutton1_mo_border_color', '#000000').';
            }';
        }

        $bgcolor2 = get_theme_mod('laybutton2_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton2_background_color', '#ffffff');
        $bgcolor2_mo = get_theme_mod('laybutton2_mo_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton2_mo_background_color', '#ffffff');

        $laybutton2_textformat = get_theme_mod('laybutton2_textformat', 'Default');
        $sharedStyles .= FormatsManager::get_textformat_css_for_selector($laybutton2_textformat, '.laybutton2', false);
        $sharedStyles .= 
        '.laybutton2{
            color: '.get_theme_mod('laybutton2_text_color', '#000').';
            border-radius: '.get_theme_mod('laybutton2_borderradius', 100).'px;
            background-color: '.$bgcolor2.';
            border: '.get_theme_mod('laybutton2_borderwidth', 1).'px solid '.get_theme_mod('laybutton2_border_color', '#000000').';
            padding-left: '.get_theme_mod('laybutton2_paddingleftright', 20).'px;
            padding-right: '.get_theme_mod('laybutton2_paddingleftright', 20).'px;
            padding-top: '.get_theme_mod('laybutton2_paddingtop', 5).'px;
            padding-bottom: '.get_theme_mod('laybutton2_paddingbottom', 5).'px;
            margin-left: '.get_theme_mod('laybutton2_marginleftright', 0).'px;
            margin-right: '.get_theme_mod('laybutton2_marginleftright', 0).'px;
            margin-top: '.get_theme_mod('laybutton2_margintop', 0).'px;
            margin-bottom: '.get_theme_mod('laybutton2_marginbottom', 0).'px;
            '.( get_theme_mod('laybutton2_animate_mouseover', false) == true ? 'transition: all 200ms ease;' : '' ).'
        }';
        if( get_theme_mod('laybutton2_use_mouseover', false) == true ) {
            $sharedStyles .= 
            '.laybutton2:hover{
                color: '.get_theme_mod('laybutton2_mo_text_color', '#000').';
                background-color: '.$bgcolor2_mo.';
                border: '.get_theme_mod('laybutton2_mo_borderwidth', 1).'px solid '.get_theme_mod('laybutton2_mo_border_color', '#000000').';
            }';
        }

        $bgcolor3 = get_theme_mod('laybutton3_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton3_background_color', '#eeeeee');
        $bgcolor3_mo = get_theme_mod('laybutton3_mo_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton3_mo_background_color', '#eeeeee');

        $laybutton3_textformat = get_theme_mod('laybutton3_textformat', 'Default');
        $sharedStyles .= FormatsManager::get_textformat_css_for_selector($laybutton3_textformat, '.laybutton3', false);
        $sharedStyles .= 
        '.laybutton3{
            color: '.get_theme_mod('laybutton3_text_color', '#000').';
            border-radius: '.get_theme_mod('laybutton3_borderradius', 100).'px;
            background-color: '.$bgcolor3.';
            border: '.get_theme_mod('laybutton3_borderwidth', 0).'px solid '.get_theme_mod('laybutton3_border_color', '#000000').';
            padding-left: '.get_theme_mod('laybutton3_paddingleftright', 20).'px;
            padding-right: '.get_theme_mod('laybutton3_paddingleftright', 20).'px;
            padding-top: '.get_theme_mod('laybutton3_paddingtop', 5).'px;
            padding-bottom: '.get_theme_mod('laybutton3_paddingbottom', 5).'px;
            margin-left: '.get_theme_mod('laybutton3_marginleftright', 0).'px;
            margin-right: '.get_theme_mod('laybutton3_marginleftright', 0).'px;
            margin-top: '.get_theme_mod('laybutton3_margintop', 0).'px;
            margin-bottom: '.get_theme_mod('laybutton3_marginbottom', 0).'px;
            '.( get_theme_mod('laybutton3_animate_mouseover', false) == true ? 'transition: all 200ms ease;' : '' ).'
        }';
        if( get_theme_mod('laybutton3_use_mouseover', false) == true ) {
            $sharedStyles .= 
            '.laybutton3:hover{
                color: '.get_theme_mod('laybutton3_mo_text_color', '#000').';
                background-color: '.$bgcolor3_mo.';
                border: '.get_theme_mod('laybutton3_mo_borderwidth', 0).'px solid '.get_theme_mod('laybutton3_mo_border_color', '#000000').';
            }';
        }

        $breakpoint = get_option('lay_breakpoint', 600);
        $breakpoint = (int)$breakpoint;

        wp_add_inline_style( 'frontend-style',
        '/* customizer css */
            '.$sharedStyles.'
            @media (min-width: '.($breakpoint+1).'px){'
                .$desktopAndTabletStyles.
            '}
            @media (max-width: '.($breakpoint).'px){'
                .$mobileStyles.
            '}'
        );
    }

    public static function get_mu( $theme_mod_name, $defaultmu ){
        // example: it's a fresh Lay Theme install. "px" is the default. but when a user never actually selects "px" and saves the customizer, a value of "" is saved
        $mu = get_theme_mod($theme_mod_name, $defaultmu);
        if($mu == ""){
            $mu = $defaultmu;
        }
        return $mu;
    }

    public static function navbar_get_hide_when_scrolling_down(){
		// get_theme_mod('nav_hidewhenscrolling', "") is default for backwards compatibility
		$navbar_hidewhenscrolling_default = get_theme_mod('nav_hidewhenscrolling', "");
		return get_theme_mod('navbar_hidewhenscrolling', $navbar_hidewhenscrolling_default);
	}

    public static function navbar_get_fadeout_when_scrolling_down(){
		$navbar_fadeout_whenscrolling_default = get_theme_mod('navbar_fadeout_whenscrolling', "");
		return get_theme_mod('navbar_fadeout_whenscrolling', $navbar_fadeout_whenscrolling_default);
	}

    public static function st_get_hide_when_scrolling_down(){
        $mod = get_theme_mod('st_hidewhenscrolling', "");

        if($mod == 1){
            $stisFixed = get_theme_mod('st_isfixed', '1');

            if($stisFixed == 1){
                return 1;
            }
        }

        return "";
    }

    public static function st_get_fadeout_when_scrolling_down(){
        $mod = get_theme_mod('st_fadeout_whenscrolling', "");

        if($mod == 1){
            $stisFixed = get_theme_mod('st_isfixed', '1');

            if($stisFixed == 1){
                return 1;
            }
        }

        return "";
    }

    public static function nav_get_fadeout_when_scrolling_down($identifier){

        $suffix = LayMenuManager::get_suffix_based_on_identifier($identifier);
        $mod = get_theme_mod('nav_fadeout_whenscrolling'.$suffix, "");

        if($mod == 1){
            $navisFixed = get_theme_mod('nav_isfixed'.$suffix, '1');

            if($navisFixed == 1){
                return 1;
            }
        }

        return "";
    }

    public static function nav_get_hide_when_scrolling_down($identifier){

        $suffix = LayMenuManager::get_suffix_based_on_identifier($identifier);
        $mod = get_theme_mod('nav_hidewhenscrolling'.$suffix, "");

        if($mod == 1){
            $navisFixed = get_theme_mod('nav_isfixed'.$suffix, '1');

            if($navisFixed == 1){
                return 1;
            }
        }

        return "";
    }

    public static function generate_fi_mouseover_blur(){
        $return = "";
        $mod = get_theme_mod('fi_mo_do_blur', '');
        if($mod == '1'){
            if( LayFrontend_Options::$fi_mo_touchdevice_behaviour == 'mo_on_tap_alt' ) {
                $return =
                '.thumb:hover .ph{
                    -webkit-filter: blur(2px);
                    -moz-filter: blur(2px);
                    -ms-filter: blur(2px);
                    -o-filter: blur(2px);
                    filter: blur(2px);
                }';
            } else {
                $return =
                '.no-touchdevice .thumb:hover .ph, .touchdevice .thumb.hover .ph{
                    -webkit-filter: blur(2px);
                    -moz-filter: blur(2px);
                    -ms-filter: blur(2px);
                    -o-filter: blur(2px);
                    filter: blur(2px);
                }';
            }

            return $return;
        }
    }

    public static function generate_fi_mouseover_animate_blur(){
        $return = "";
        $mod = get_theme_mod('fi_animate_blur', '1');
        if($mod == '1'){
            $return =
            '.thumb .ph{
                transition: -webkit-filter 400ms ease-out;
            }';
            return $return;
        }
    }

    public static function generate_fi_mouseover_animate_bgcolor_css(){
        $return = "";
        $mod = get_theme_mod('fi_animate_color', '1');
        if($mod == '1'){
            $return =
            '.thumb .ph span{
                -webkit-transition: all 400ms ease-out;
                -moz-transition: all 400ms ease-out;
                transition: all 400ms ease-out;
            }';
            return $return;
        }
    }

    public static function generate_fi_mouseover_animate_brightness_css(){
        $return = "";
        $mod = get_theme_mod('fi_mo_animate_brightness', '1');
        if($mod == '1'){
            $return =
            '.thumb .ph{
                -webkit-transition: all 400ms ease-out;
                -moz-transition: all 400ms ease-out;
                transition: all 400ms ease-out;
            }';
            return $return;
        }
    }

    public static function generate_mouseover_animate_visibility_css( $selector, $mod_name ){
        $return = "";
        $mod = get_theme_mod($mod_name, '1');
        if($mod == '1'){
            $return =
            $selector.'{
                -webkit-transition: all 400ms ease-out;
                -moz-transition: all 400ms ease-out;
                transition: all 400ms ease-out;
            }';
            return $return;
        }
    }

    public static function generate_fi_mouseover_zoom_css(){
        $return = '';
        $mod = get_theme_mod('fi_mo_do_zoom', 'none');
        // case '1': zoom in
        switch ($mod) {
            case '1':
                if( LayFrontend_Options::$fi_mo_touchdevice_behaviour == 'mo_on_tap_alt' ) {
                    $return =
                    '.thumb:hover img,
                    .thumb:hover video{
                        -webkit-transform: translateZ(0) scale(1.05);
                        -moz-transform: translateZ(0) scale(1.05);
                        -ms-transform: translateZ(0) scale(1.05);
                        -o-transform: translateZ(0) scale(1.05);
                        transform: translateZ(0) scale(1.05);
                    }';
                } else {
                    $return =
                    '.no-touchdevice .thumb:hover img, .touchdevice .thumb.hover img,
                    .no-touchdevice .thumb:hover video, .touchdevice .thumb.hover video{
                        -webkit-transform: translateZ(0) scale(1.05);
                        -moz-transform: translateZ(0) scale(1.05);
                        -ms-transform: translateZ(0) scale(1.05);
                        -o-transform: translateZ(0) scale(1.05);
                        transform: translateZ(0) scale(1.05);
                    }';
                }

            break;
            case 'zoom-out':
                if( LayFrontend_Options::$fi_mo_touchdevice_behaviour == 'mo_on_tap_alt' ) {
                    // zoom out image and background color
                    $return =
                    '.thumb:hover img,
                    .thumb:hover video{
                        -webkit-transform: translateZ(0) scale(0.97);
                        -moz-transform: translateZ(0) scale(0.97);
                        -ms-transform: translateZ(0) scale(0.97);
                        -o-transform: translateZ(0) scale(0.97);
                        transform: translateZ(0) scale(0.97);
                    }
                    .thumb:hover .ph span{
                        -webkit-transform: translateZ(0) scale(0.97);
                        -moz-transform: translateZ(0) scale(0.97);
                        -ms-transform: translateZ(0) scale(0.97);
                        -o-transform: translateZ(0) scale(0.97);
                        transform: translateZ(0) scale(0.97);
                    }';
                } else {
                    // zoom out image and background color
                    $return =
                    '.no-touchdevice .thumb:hover img, .touchdevice .thumb.hover img,
                    .no-touchdevice .thumb:hover video, .touchdevice .thumb.hover video{
                        -webkit-transform: translateZ(0) scale(0.97);
                        -moz-transform: translateZ(0) scale(0.97);
                        -ms-transform: translateZ(0) scale(0.97);
                        -o-transform: translateZ(0) scale(0.97);
                        transform: translateZ(0) scale(0.97);
                    }
                    .no-touchdevice .thumb:hover .ph span, .touchdevice .thumb.hover .ph span{
                        -webkit-transform: translateZ(0) scale(0.97);
                        -moz-transform: translateZ(0) scale(0.97);
                        -ms-transform: translateZ(0) scale(0.97);
                        -o-transform: translateZ(0) scale(0.97);
                        transform: translateZ(0) scale(0.97);
                    }';
                }

            break;
        }
        return $return;
    }

    public static function nav_generate_menupoints_spacebetween_css( $selector, $mod_name, $default, $prefix='', $postfix='', $arrangement_mod_name='' ) {
        $return = '';
        $mod = get_theme_mod($mod_name, $default);
        $arrangement = get_theme_mod($arrangement_mod_name, 'horizontal');
        if($arrangement == "horizontal"){
            $style = "margin-right";
        }
        else if($arrangement == "vertical"){
            $style = "margin-bottom";
        }
        if ( ! empty( $mod ) ) {
                $return = sprintf('%s { %s:%s; }',
                $selector,
                $style,
                $prefix.$mod.$postfix
            );
        }
        return $return;
    }

    public static function nav_generate_menupoints_arrangement($selector, $mod_name){
        $return = $selector;
        $arrangement = get_theme_mod($mod_name, 'horizontal');
        if($arrangement == 'vertical'){
            $return .= '{display: block; }';
        }
        else if($arrangement == 'horizontal'){
            $return .= '{display: inline-block;}';
        }
        return $return;
    }

    public static function get_navbar_position(){
        $nav_position = get_theme_mod('nav_position', 'top-right');
        if (strpos($nav_position,'bottom') !== false){
            return 'bottom';
        }
        else if (strpos($nav_position,'top') !== false){
            return 'top';
        }       
    }

    public static function generate_navbar_position(){
        $nav_position = get_theme_mod('nav_position', 'top-right');
        if (strpos($nav_position,'bottom') !== false){
            return '.navbar{ bottom:0; top: auto; }';
        }
        else if (strpos($nav_position,'top') !== false){
            return '.navbar{ top:0; bottom: auto; }';
        }
    }

    public static function generate_navbar_border_color_css(){
        $nav_position = get_theme_mod('nav_position', 'top-right');
        $navbar_show_border = get_theme_mod('navbar_show_border', '');

        if($navbar_show_border == "1"){
            if (strpos($nav_position,'bottom') !== false){
                return '.navbar{ border-top-style: solid; border-top-width: 1px; }';
            }
            else if (strpos($nav_position,'top') !== false){
                return '.navbar{ border-bottom-style: solid; border-bottom-width: 1px; }';
            }
        }
    }

    public static function generate_featured_image_brightness_css($selector, $mod_name, $default){
        $return = $selector;
        $mod = (int)get_theme_mod($mod_name, $default);
        $mod /= 100;

        if($mod < 0){ $mod = 0; }
        else if($mod > 2){ $mod = 2; }
        $return .= '{filter: brightness('.$mod.'); -webkit-filter: brightness('.$mod.');}';

        return $return;
    }

    public static function generate_featured_image_opacity_css($selector, $mod_name, $default){
        $return = $selector;
        $mod = (int)get_theme_mod($mod_name, $default);
        $mod /= 100;

        if($mod < 0){ $mod = 0; }
        else if($mod > 1){ $mod = 1; }
        $return .= '{opacity: '.$mod.';}';

        return $return;
    }

    public static function generate_brightness_css($selector, $mod_name, $default){
        $return = $selector;
        $mod = (int)get_theme_mod($mod_name, $default);
        $mod /= 100;

        if($mod < 0){ $mod = 0; }

        $return .= '{filter: brightness('.$mod.'); -webkit-filter: brightness('.$mod.');}';

        return $return;
    }

    public static function generate_opacity_css($selector, $mod_name, $default, $important = false){
        $return = $selector;
        $mod = (int)get_theme_mod($mod_name, $default);
        $mod /= 100;

        if($mod < 0){ $mod = 0; }
        else if($mod > 1){ $mod = 1; }

        $important_css = $important ? '!important' : '';
        $return .= '{opacity: '.$mod.$important_css.';}';

        return $return;
    }

    public static function generate_opacity_css_from_option($selector, $option_name, $default){
        $return = $selector;
        $val = (int)get_option($option_name, $default);
        $val /= 100;

        if($val < 0){ $val = 0; }
        else if($val > 1){ $val = 1; }

        $return .= '{opacity: '.$val.';}';

        return $return;
    }

    public static function generate_hide_mobile_menu(){
        $mod = get_theme_mod('mobile_hide_menu', 0);
        if($mod == '1'){
            return
            '.navbar{
                background-color: transparent!important;
                border-bottom: none!important;
                height: 0!important;
                min-height: 0!important;
            }
            .mobile-title.text{
                min-height: 0!important;
            }
            .lay-mobile-icons-wrap{
                display: none;
            }
            body{
                padding-top: 0!important;
            }
            nav.mobile-nav{
                display: none;
            }';
        }
    }

    public static function generate_hide_css($selector, $mod_name, $inline = false){
        $return = $selector;
        $mod = get_theme_mod($mod_name, 0);

        if($mod == '1'){
            $return .= '{display: none;}';
        }
        else{
            $block = $inline ? 'inline-block' : 'block';
            $return .= '{display: '.$block.';}';
        }
        return $return;
    }

    public static function pt_generate_position_css($selector){
        $return = $selector;
        $mod = get_theme_mod('pt_position', 'below-image');

        switch($mod){
            case 'on-image-top-left':
                $return .= '{
                    top: '.get_theme_mod('pt_onimage_spacetop', 10).'px;
                    left: '.get_theme_mod('pt_onimage_spaceleft', 10).'px;
                }';
            break;
            case 'on-image-top-right':
                $return .= '{
                    top: '.get_theme_mod('pt_onimage_spacetop', 10).'px;
                    right: '.get_theme_mod('pt_onimage_spaceright', 10).'px;
                }';
            break;
            // (center)
            case 'on-image':
                $return .= '{
                    top: 50%;
                    left: 50%;
                    -webkit-transform: translate(-50%,-50%);
                    -moz-transform: translate(-50%,-50%);
                    -ms-transform: translate(-50%,-50%);
                    -o-transform: translate(-50%,-50%);
                    transform: translate(-50%,-50%);
                }';
            break;
            case 'on-image-bottom-left':
                $return .= '{
                    bottom: '.get_theme_mod('pt_onimage_spacebottom', 10).'px;
                    left: '.get_theme_mod('pt_onimage_spaceleft', 10).'px;
                }';
            break;
            case 'on-image-bottom-right':
                $return .= '{
                    bottom: '.get_theme_mod('pt_onimage_spacebottom', 10).'px;
                    right: '.get_theme_mod('pt_onimage_spaceright', 10).'px;
                }';
            break;
            case 'below-image':
                $return .= '{}';
            break;
            case 'above-image':
                $return .= '{}';
            break;
        }

        return $return;
    }

    public static function generate_visibility_css($selector, $mod_name){
        $return = $selector;
        $mod = get_theme_mod($mod_name, 'always-show');

        if($mod == 'show-on-mouseover'){
            $return .= '{opacity: 0;}';
            return $return;
        }
        else if($mod == 'hide'){
            $return .= '{display:none!important;}';
            return $return;
        }

    }

    public static function generate_is_fixed_css($selector, $mod_name){
        $return = $selector;
        $mod = get_theme_mod($mod_name, '1');

        if($mod == '1'){
            $return .= '{position: fixed;}';
        }
        else{
            $return .= '{position: absolute;}';
        }
        return $return;

    }

    public static function generate_position_css($selector, $mod_name, $default){
        $return = $selector;
        $mod = get_theme_mod($mod_name, $default);
        if ( ! empty( $mod ) ) {
            switch($mod){
                case 'top-left':
                    $return .= '{bottom: auto; right: auto;}';
                break;
                case 'top-center':
                    $return .=
                    '{bottom: auto; right: auto; left: 50%;
                    -webkit-transform: translateX(-50%);
                    -moz-transform: translateX(-50%);
                    -ms-transform: translateX(-50%);
                    -o-transform: translateX(-50%);
                    transform: translateX(-50%);}';
                break;
                case 'top-right':
                    $return .= '{bottom: auto; left: auto;}';
                break;
                case 'center-left':
                    $return .=
                    '{bottom: auto; right: auto; top:50%;
                    -webkit-transform: translate(0, -50%);
                    -moz-transform: translate(0, -50%);
                    -ms-transform: translate(0, -50%);
                    -o-transform: translate(0, -50%);
                    transform: translate(0, -50%);}';
                break;
                case 'center':
                    $return .=
                    '{bottom: auto; right: auto; left: 50%; top:50%;
                    -webkit-transform: translate(-50%, -50%);
                    -moz-transform: translate(-50%, -50%);
                    -ms-transform: translate(-50%, -50%);
                    -o-transform: translate(-50%, -50%);
                    transform: translate(-50%, -50%);}';
                break;
                case 'center-right':
                    $return .=
                    '{bottom: auto; left: auto; top:50%;
                    -webkit-transform: translate(auto, -50%);
                    -moz-transform: translate(auto, -50%);
                    -ms-transform: translate(auto, -50%);
                    -o-transform: translate(auto, -50%);
                    transform: translate(auto, -50%);}';
                break;
                case 'bottom-left':
                    $return .= '{top: auto; right: auto;}';
                break;
                case 'bottom-center':
                    $return .=
                    '{top: auto; right: auto; left: 50%;
                    -webkit-transform: translateX(-50%);
                    -moz-transform: translateX(-50%);
                    -ms-transform: translateX(-50%);
                    -o-transform: translateX(-50%);
                    transform: translateX(-50%);}';
                break;
                case 'bottom-right':
                    $return .= '{top: auto; left: auto;}';
                break;
            }
            return $return;
        }
    }

    // http://codex.wordpress.org/Theme_Customization_API#Sample_Theme_Customization_Class
    public static function generate_css( $selector, $style, $mod_name, $default, $prefix='', $postfix='' ) {
        $return = '';
        $mod = get_theme_mod($mod_name, $default);
        if ( isset( $mod ) ) {
            $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
            );
        }
        return $return;
    }

    public static function generate_rgba( $selector, $style, $mod_name, $default, $opacity ) {
        $return = '';
        $color = get_theme_mod($mod_name, $default);
        if ( isset( $color ) ) {
            $rgb_array = CSS_Output::hex2rgb($color);
            $opacity = (int)$opacity / 100;
            $rgba = 'rgba('.$rgb_array['red'].','.$rgb_array['green'].','.$rgb_array['blue'].','.$opacity.')';
            $return = sprintf('%s { %s:%s; }', $selector, $style, $rgba);
        }
        return $return;
    }

    public static function get_mobile_menu_txt_color(){
        $txtColor = get_theme_mod('nav_color', false);
        if($txtColor == false){

            $formatsJsonString = FormatsManager::getDefaultFormatsJson();
            $formatsJsonArr = json_decode($formatsJsonString, true);

            for($i = 0; $i<count($formatsJsonArr); $i++) {
                if($formatsJsonArr[$i]["formatname"] == "Default"){
                    $txtColor = $formatsJsonArr[$i]["color"];
                }
            }
        }
        return $txtColor;
    }

    public static function get_mobile_menu_light_color(){
        $bgColor = CSS_Output::get_mobile_basecolor();
        $lighterBgColor = CSS_Output::tintColor($bgColor, 7);
        return $lighterBgColor;
    }

    public static function get_mobile_menu_dark_color(){
        $bgColor = CSS_Output::get_mobile_basecolor();
        $darker = CSS_Output::tintColor($bgColor, -7);
        return $darker;
    }

    public static function get_mobile_basecolor(){
        $navBarHidden = get_theme_mod('navbar_hide', 0);
        $bgColor = '';
        if(!$navBarHidden){
            $bgColor = get_theme_mod('navbar_color', '#ffffff');
            $navbar_opacity = get_theme_mod('navbar_opacity', '90');
            $offset = 100 - (int)$navbar_opacity;
            $bgColor = CSS_Output::tintColor($bgColor, $offset);
        }
        else{
            $bgColor = get_theme_mod('bg_color', '#ffffff');
        }
        return $bgColor;
    }

    // http://www.kirupa.com/forum/showthread.php?366845-Make-hex-colours-lighter-with-PHP-(using-existing-code)
    public static function tintColor($color, $per){
        $color = substr( $color, 1 ); // Removes first character of hex string (#)
        if(strlen($color) == 3){
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        }
        $rgb = ''; // Empty variable
        $per = $per/100*255; // Creates a percentage to work with. Change the middle figure to control color temperature

        if  ($per < 0 ){
            // DARKER
            $per =  abs($per); // Turns Neg Number to Pos Number
            for ($x=0;$x<3;$x++){
                $c = hexdec(substr($color,(2*$x),2)) - $per;
                $c = ($c < 0) ? 0 : dechex((int)$c);
                $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
            }
        }
        else{
            // LIGHTER
            for ($x=0;$x<3;$x++){
                $c = hexdec(substr($color,(2*$x),2)) + $per;
                $c = ($c > 255) ? 'ff' : dechex((int)$c);
                $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
            }
        }
        return '#'.$rgb;
    }

    public static function hex2rgb( $color ) {
            if ( $color[0] == '#' ) {
                    $color = substr( $color, 1 );
            }
            if ( strlen( $color ) == 6 ) {
                    list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                    list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                    return false;
            }
            $r = hexdec( $r );
            $g = hexdec( $g );
            $b = hexdec( $b );
            return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }

    public static function echo_lay_customize_css(){
        echo CSS_Output::lay_customize_css();
    }

}
new CSS_Output();