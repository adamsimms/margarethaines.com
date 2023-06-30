<?php
// http://codex.wordpress.org/Settings_API#Examples
class LayIntro{

	public static $isActive;

	public function __construct(){
		LayIntro::$isActive = get_option('misc_options_intro', '') == 'on' && !MiscOptions::$locked ? true : false;
		if(LayIntro::$isActive){
			add_action('wp_head', array($this, 'intro_frontend_styles'));
		}
	}

	public function intro_frontend_styles(){
		$CSS = '';

		// if a textformat is selected, the html class is used by the dom element, so i don't need to create extra styles
		$intro_text_textformat = get_theme_mod('intro_text_textformat', 'Default');
		if($intro_text_textformat == ""){
			// if no textformat was selected for intro_text, generate css based on the individual customizer controls
			$intro_text_fontsize_mu = CSS_Output::get_mu('intro_text_fontsize_mu', 'px');
			$CSS .= CSS_Output::generate_css('.intro_text', 'font-size', 'intro_text_fontsize', Customizer::$defaults['fontsize'],'', $intro_text_fontsize_mu);
			$CSS .= CSS_Output::generate_css('.intro_text', 'font-weight', 'intro_text_fontweight', Customizer::$defaults['fontweight']);
			$CSS .= CSS_Output::generate_css('.intro_text', 'letter-spacing', 'intro_text_letterspacing', Customizer::$defaults['letterspacing'], '', 'em');
			$CSS .= CSS_Output::generate_css('.intro_text', 'color', 'intro_text_color', Customizer::$defaults['color']);
			$CSS .= CSS_Output::generate_css('.intro_text', 'font-family', 'intro_text_fontfamily', Customizer::$defaults['fontfamily']);
			$CSS .= CSS_Output::generate_css('.intro_text', 'text-align', 'intro_text_align', 'left');
		}     
		$intro_text_spacetop_mu = CSS_Output::get_mu('intro_text_spacetop_mu', 'px');
		$CSS .= CSS_Output::generate_css('.intro_text', 'top', 'intro_text_spacetop', Customizer::$defaults['intro_text_spacetop'], '', $intro_text_spacetop_mu);

		$intro_text_spaceleft_mu = CSS_Output::get_mu('intro_text_spaceleft_mu', '%');
		$CSS .= CSS_Output::generate_css('.intro_text', 'left', 'intro_text_spaceleft', Customizer::$defaults['intro_text_spaceleft'],'', $intro_text_spaceleft_mu);

		$intro_text_spaceright_mu = CSS_Output::get_mu('intro_text_spaceright_mu', '%');
		$CSS .= CSS_Output::generate_css('.intro_text', 'right', 'intro_text_spaceright', Customizer::$defaults['intro_text_spaceright'],'', $intro_text_spaceright_mu);

		$intro_text_spacebottom_mu = CSS_Output::get_mu('intro_text_spacebottom_mu', 'px');
		$CSS .= CSS_Output::generate_css('.intro_text', 'bottom', 'intro_text_spacebottom', Customizer::$defaults['intro_text_spacebottom'], '', $intro_text_spacebottom_mu);

		$CSS .= CSS_Output::generate_position_css('.intro_text', 'intro_text_position', 'center-left');
		 
		$CSS .= CSS_Output::generate_opacity_css_from_option('.intro', 'intro_opacity', 100);
		$CSS .= CSS_Output::generate_brightness_css('.intro .mediawrap', 'intro_media_brightness', 100);

        $intro_background_opacity = get_theme_mod('intro_background_opacity', 100);
        $CSS .= CSS_Output::generate_rgba('.intro', 'background-color', 'intro_background_color', '#ffffff', $intro_background_opacity);

        $honp_default = true;
        if( get_theme_mod('intro_hide_on_phone', 'not_set') == 'not_set' ) {
            $honp_default = false;
        }
        $hide_on_phone = get_theme_mod('intro_hide_on_phone', $honp_default);
        if( $hide_on_phone == true ) {
            $breakpoint = get_option('lay_breakpoint', 600);
            $breakpoint = (int)$breakpoint;
            $CSS .=
            '@media (max-width: '.($breakpoint).'px){
                .intro{
                    display: none;
                }
            }';
        }



		$transition = get_option( 'intro_transition', 'zoom' );
		switch($transition){
			case 'zoom':
				$CSS .=
				'.intro.animatehide{
					opacity: 0;
					-webkit-transform: scale(1.5);
					transform: scale(1.5);
				}';
			break;
			case 'fade':
				$CSS .= '.intro.animatehide{opacity: 0;}';
			break;
			case 'up':
				$CSS .=
				'.intro.animatehide{
					-webkit-transform: translateY(-100vh);
					transform: translateY(-100vh);
				}';
			break;
			case 'upfade':
				$CSS .=
				'.intro.animatehide{
					opacity: 0;
					-webkit-transform: translateY(-100vh);
					transform: translateY(-100vh);
				}';
			break;
		}

		$duration = get_option( 'intro_transition_duration', '500' );
		$CSS .= '.intro{
			transition: opacity '.$duration.'ms ease, transform '.$duration.'ms ease;
			-webkit-transition: opacity '.$duration.'ms ease, -webkit-transform '.$duration.'ms ease;
		}';

		$svg_overlay_width = get_option( 'intro_svg_overlay_width', '30' );
		$mu = get_option( 'intro_svg_overlay_width_in', '%' );
		$CSS .= '.intro-svg-overlay{width:'.$svg_overlay_width.$mu.';}';

		echo
		'<!-- intro style -->
		<style>'.$CSS.'</style>';
	}

	public static function get_svg_overlay_url(){
		$svg_val = get_option('intro_svg_overlay', '');
		// the value used to be an ID, now it will be a url of an attachment
		if( wp_get_attachment_url($svg_val) != false ){
			// svg_val is already an id
			return wp_get_attachment_url($svg_val);
		}
		// svg_val is a url
		return $svg_val;
	}

	public static function get_data($orientation){
        $option_name = ($orientation == 'landscape') ? 'intro_image' : 'phone_intro';

		$intro = new stdClass();
		$intro_url = get_option($option_name, '');
		$intro_attid = $intro_url;
		// the value used to be an ID, now it will be a url of an attachment
		if( wp_get_attachment_url($intro_url) == '' ){
			$intro_attid = attachment_url_to_postid( $intro_attid );
		}

		if($intro_attid != ''){
			$intro = wp_get_attachment_metadata($intro_attid);
			if($intro == false){
				return new stdClass();
			}
			$intro['url'] = wp_get_attachment_url($intro_attid);
			$intro['url'] = LTUtility::filterURL($intro['url']);
			$intro['type'] = false;
			$mime_type = get_post_mime_type($intro_attid);

			// error_log(print_r($mime_type, true));

			switch ($mime_type) {
				case 'image/jpeg':
				case 'image/png':
				case 'image/gif':
				case 'image/svg+xml':
					$intro['type'] = 'image';
					$intro['sizes'] = LayIntro::getSizes($intro_attid);
				break;
				case 'video/mpeg':
				case 'video/mp4': 
				case 'video/quicktime':
					$intro['type'] = 'video';
				break;
			}
		}
		
        return $intro;
	}
	public static function getSizes($attid){
		$sizes = array();
		global $_wp_additional_image_sizes;

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( !in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				if ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
					$attachment = wp_get_attachment_image_src( $attid, $_size );
					$sizes[ $_size ] = LTUtility::filterURL($attachment[0]);
				}
			}
		}

		return $sizes;
	}

}
new LayIntro();