<?php
class FormatsManager {
	public static $customFormats = false;
	public static $fontWeights = array(
		'Thin (100)' => '100',
		'Extra Light (200)' => '200',
		'Light (300)' => '300',
		'Normal (400)' => '400',
		'Medium (500)' => '500',
		'Semi Bold (600)' => '600',
		'Bold (700)' => '700',
		'Extra Bold (800)' => '800',
		'Black (900)' => '900'
	);
	public static $defaultFormat = array(
		'formatname' => 'Default',
		'type' => 'Paragraph',
		'headlinetype' => 'h1',
		'fontfamily' => 'helvetica,sans-serif',
		'fontsize' => '25',
		'color' => '#000000',
		'letterspacing' => '0',
		'fontweight' => '400',
		'spacebottom' => '15',
		'spacetopmu' => 'px',
		'spacetop' => '0',
		'spacebottommu' => 'px',
		'textalign' => 'left',
		'lineheight' => '1.2',
		'textindent' => '0',
		'caps' => false,
		'italic' => false,
		'underline' => false,
		'borderbottom' => false,
		'tablet-spacetop' => "0",
		'tablet-spacetopmu' => 'px',
		'tablet-spacebottom' => '15',
		'tablet-spacebottommu' => 'px',
		'tablet-fontsizemu' => 'px',
		'tablet-fontsize' => '20',
		'phone-spacetop' => "0",
		'phone-spacetopmu' => 'px',
		'phone-spacebottom' => '15',
		'phone-spacebottommu' => 'px',
		'phone-fontsizemu' => 'px',
		'phone-fontsize' => '16',
		'not-deletable' => true
	);
	public static $hasTabletSettings = false;

	public static function init(){
		$customFormatsJSON = FormatsManager::getDefaultFormatsJson();
		if ($customFormatsJSON) {
			FormatsManager::$customFormats = json_decode($customFormatsJSON, true);
		}

		$misc_options_textformats_for_tablet = get_option( 'misc_options_textformats_for_tablet', "on" );
		if ( $misc_options_textformats_for_tablet == "on" ) {
			FormatsManager::$hasTabletSettings = true;
		}


		add_action( 'admin_menu', 'FormatsManager::textformats_setup_menu', 10 );

		add_action( 'admin_init', 'FormatsManager::register_settings' );

		add_action( 'admin_enqueue_scripts', 'FormatsManager::formatsmanager_styles' );

		add_action( 'admin_init', 'FormatsManager::register_scripts', 10 );
		add_action( 'admin_enqueue_scripts', 'FormatsManager::formatsmanager_scripts', 9 );

		add_action( 'admin_head', 'FormatsManager::gridder_textformats_css', 10 );

		add_action( 'admin_footer', 'FormatsManager::print_JSON' );

		add_action( 'mce_external_plugins', 'FormatsManager::tinymce_add_textformatsloader' );
		add_filter( 'tiny_mce_before_init', 'FormatsManager::tinymce_formats' );

		add_action( 'wp_enqueue_scripts', 'FormatsManager::frontend_textformats_css', 13 );
	}

	// http://wordpress.stackexchange.com/questions/144705/unable-to-add-code-button-to-tinymce-toolbar
	// formats dropdown for tinymce
	public static function tinymce_formats($in) {
		// using 'attributes' => array('class' => '_'.$customFormats[$i]['formatname']),
		// instead of 'classes' => '_'.$customFormats[$i]['formatname']
		// this way the user can only have one format applied to a selected text

		$paragraph_formats = array();
		$headline_formats = array();
		$character_formats = array();

		$customFormats = FormatsManager::$customFormats;
		
		$style_formats = array();

		if ($customFormats) {
			for ($i=0; $i<count($customFormats); $i++) {
                // https://www.tiny.cloud/docs/configure/content-formatting/
				switch ($customFormats[$i]['type']) {
					case 'Paragraph':
						$paragraph_formats []= array(
							'title' => $customFormats[$i]['formatname'],
							'attributes' => array('class' => '_'.$customFormats[$i]['formatname']),
							'exact' => true,
                            // instead of using 'block' => 'p' i do this and it makes sure i can apply the formats to list elements too
                            'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,table',
						);
					break;
					case 'Headline':
						$block = 'h1';
						if( array_key_exists('headlinetype', $customFormats[$i]) ) {
							$block = $customFormats[$i]['headlinetype'];
						}
						$headline_formats []= array(
							'title' => $customFormats[$i]['formatname'],
							'attributes' => array('class' => '_'.$customFormats[$i]['formatname']),
							'block' => $block
						);
					break;
					case 'Character':
						$character_formats []= array(
							'title' => $customFormats[$i]['formatname'],
							'attributes' => array('class' => '_'.$customFormats[$i]['formatname']),
							'inline' => 'span'
						);
					break;
				}
			}

			if ($paragraph_formats) {
				$style_formats []= array(
					'title' => 'Paragraph',
					'items' => $paragraph_formats
				);
			}
			if ($headline_formats) {
				$style_formats []= array(
					'title' => 'Headline',
					'items' => $headline_formats
				);
			}
			if ($character_formats) {
				$style_formats []= array(
					'title' => 'Character',
					'items' => $character_formats
				);
			}

			$in['style_formats'] = json_encode( $style_formats );
		} else {
			$style_formats []= array(
				'title' => 'Paragraph',
				'items' => array()
			);

			$style_formats []= array(
				'title' => 'Headline',
				'items' => array()
			);

			$style_formats []= array(
				'title' => 'Character',
				'items' => array()
			);

			$in['style_formats'] = json_encode( $style_formats );
		}

		return $in;
	}

	public static function tinymce_add_textformatsloader( $plugins ) {
		$plugins['textformatsloader'] = Setup::$uri.'/formatsmanager/assets/js/tinymce_plugin/tinymce_textformatsloader.js?ver='.Setup::$ver;
		return $plugins;
	}


	public static function getDefaultFormatsJson() {
		$formats_array = array(
			FormatsManager::$defaultFormat
		);
		if( class_exists('WooCommerce') ) {
			$formats_array = array(
				FormatsManager::$defaultFormat,
				WooCommerceFormats::$Shop_Big,
				WooCommerceFormats::$Shop_Medium,
				WooCommerceFormats::$Shop_Small, 
				WooCommerceFormats::$Shop_Product_Thumbnails,
				WooCommerceFormats::$Shop_Cart,
				WooCommerceFormats::$Shop_Order_Received
			);
		}

		$formats = get_option( 'formatsmanager_json', json_encode($formats_array) );
		$formats = FormatsManager::maybeAddRequiredFormats($formats);
		$formats = json_encode($formats);
		return $formats;
	}

	public static function maybeAddRequiredFormats($formats) {
		$formatsJsonArr = json_decode($formats, true);
		// error_log(print_r(FormatsManager::format_of_name_in_array('Default', $formatsJsonArr), true));
		if( class_exists('WooCommerce') ) {
			if( !FormatsManager::format_of_name_in_array('Shop_Cart', $formatsJsonArr) ){
				array_unshift($formatsJsonArr, WooCommerceFormats::$Shop_Cart);
			}
			if( !FormatsManager::format_of_name_in_array('Shop_Product_Thumbnails', $formatsJsonArr) ){
				array_unshift($formatsJsonArr, WooCommerceFormats::$Shop_Product_Thumbnails);
			}
			if( !FormatsManager::format_of_name_in_array('Shop_Small', $formatsJsonArr) ){
				array_unshift($formatsJsonArr, WooCommerceFormats::$Shop_Small);
			}
			if( !FormatsManager::format_of_name_in_array('Shop_Medium', $formatsJsonArr) ){
				array_unshift($formatsJsonArr, WooCommerceFormats::$Shop_Medium);
			}
			if( !FormatsManager::format_of_name_in_array('Shop_Big', $formatsJsonArr) ){
				array_unshift($formatsJsonArr, WooCommerceFormats::$Shop_Big);
			}
			if( !FormatsManager::format_of_name_in_array('Shop_Order_Received', $formatsJsonArr) ){
				array_unshift($formatsJsonArr, WooCommerceFormats::$Shop_Order_Received);
			}
		}
		if( !FormatsManager::format_of_name_in_array('Default', $formatsJsonArr) ){
			array_unshift($formatsJsonArr, FormatsManager::$defaultFormat);
		}
		return $formatsJsonArr;
	}

	public static function format_of_name_in_array($formatname, $array) {
		for ($i=0; $i < count($array); $i++) { 
			$format = $array[$i];

			// error_log(print_r($format, true));
			if( $formatname == $format['formatname'] ) {
				// error_log(print_r('yes', true));
				return true;
			}
		}
		// error_log(print_r('no', true));
		return false;
	}

	public static function print_JSON() {
		echo '<textarea style="display: none;" id="formatsmanager_json" name="formatsmanager_json">'.FormatsManager::getDefaultFormatsJson().'</textarea>';
	}

	private static function getPhoneSpecificCSS($array, $spaces = true) {
		$phone_fontsize = array_key_exists('phone-fontsize', $array) ? $array['phone-fontsize'] : "16";
		$fontsizemu = array_key_exists('fontsizemu', $array) ? $array['fontsizemu'] : 'px';
		$phone_fontsizemu = array_key_exists('phone-fontsizemu', $array) ? $array['phone-fontsizemu'] : $fontsizemu;

		if($spaces){
			$phone_spacetop = array_key_exists('phone-spacetop', $array) ? $array['phone-spacetop'] : "0";
			$phone_spacetopmu = array_key_exists('phone-spacetopmu', $array) ? $array['phone-spacetopmu'] : "px";
	
			$phone_spacebottom = array_key_exists('phone-spacebottom', $array) ? $array['phone-spacebottom'] : "20";
			$phone_spacebottommu = array_key_exists('phone-spacebottommu', $array) ? $array['phone-spacebottommu'] : "px";
		}

		$return =
			'font-size:'.$phone_fontsize.$phone_fontsizemu.';';
		if($spaces){
			$return .= 'margin:'.$phone_spacetop.$phone_spacetopmu.' 0 '.$phone_spacebottom.$phone_spacebottommu.' 0;';
		}

		return $return;
	}

	private static function getDesktopSpecificCSS($array, $spaces = true) {
		$fontsizemu = array_key_exists('fontsizemu', $array) ? $array['fontsizemu'] : 'px';

		if($spaces){
			$spacetop = array_key_exists('spacetop', $array) ? $array['spacetop'] : '0';
			$spacebottom = array_key_exists('spacebottom', $array) ? $array['spacebottom'] : '20';
			$spacetopmu = array_key_exists('spacetopmu', $array) ? $array['spacetopmu'] : "px";
			$spacebottommu = array_key_exists('spacebottommu', $array) ? $array['spacebottommu'] : "px";
		}

		$return =
			'font-size:'.$array['fontsize'].$fontsizemu.';';
		if($spaces){
			$return .= 'margin:'.$spacetop.$spacetopmu.' 0 '.$spacebottom.$spacebottommu.' 0;';
		}

		return $return;
	}

	private static function getTabletSpecificCSS($array, $spaces = true) {
		// bail out early if tablet textformats is not active
		if (!FormatsManager::$hasTabletSettings) {
			return FormatsManager::getDesktopSpecificCSS($array);
		}
		$tablet_fontsize = array_key_exists('tablet-fontsize', $array) ? $array['tablet-fontsize'] : "16";
		$tablet_fontsizemu = array_key_exists('tablet-fontsizemu', $array) ? $array['tablet-fontsizemu'] : "px";

		if($spaces){
			$tablet_spacetop = array_key_exists('tablet-spacetop', $array) ? $array['tablet-spacetop'] : "0";
			$tablet_spacetopmu = array_key_exists('tablet-spacetopmu', $array) ? $array['tablet-spacetopmu'] : "px";
			$tablet_spacebottom = array_key_exists('tablet-spacebottom', $array) ? $array['tablet-spacebottom'] : "20";
			$tablet_spacebottommu = array_key_exists('tablet-spacebottommu', $array) ? $array['tablet-spacebottommu'] : "px";
		}

		$return =
			'font-size:'.$tablet_fontsize.$tablet_fontsizemu.';';
		if($spaces){
			$return .= 'margin:'.$tablet_spacetop.$tablet_spacetopmu.' 0 '.$tablet_spacebottom.$tablet_spacebottommu.' 0;';
		}

		return $return;
	}

	private static function getFontCSS($array, $simple = false, $important = false) {
		$textindent = array_key_exists('textindent', $array) ? $array['textindent'] : '0';
		$fontweight = array_key_exists('fontweight', $array) ? $array['fontweight'] : '400';
		$textalign = array_key_exists('textalign', $array) ? $array['textalign'] : 'left';

		$caps = "";
		if ( array_key_exists('caps', $array) && $array['caps'] == true ) {
			$caps = "text-transform:uppercase;";
		} else {
			$caps = "text-transform:none;";
		}

		$italic = "";
		if ( array_key_exists('italic', $array) && $array['italic'] == true ) {
			$italic = "font-style:italic;";
		} else {
			$italic = "font-style:normal;";
		}
		$underline = "";
		if ( array_key_exists('underline', $array) && $array['underline'] == true ) {
			$underline = "text-decoration: underline;";
		} else {
			$underline = "text-decoration: none;";
		}

		$borderbottom = "";
		if ( array_key_exists('borderbottom', $array) && $array['borderbottom'] == true ) {
			$borderbottom = "border-bottom: 1px solid;";
		} else {
			$borderbottom = "border-bottom: none;";
		}

		// font-variation-settings: "opsz" 100, "wght" 152, "ital" 12;
		$variablesettings = "";
		if( array_key_exists('variablesettings', $array) && $array['variablesettings'] != '' ){
			$variablesettings = 'font-variation-settings: ';
			$values = array();
			foreach($array['variablesettings'] as $obj){
				$values []= '"'.$obj['tag'].'" '.$obj['value'];
			}
			$variablesettings .= join(', ', $values);
			$variablesettings .= ';';
		}

		$important_css = $important ? '!important' : '';
		// todo: why do i need padding: 0? can i just remove it?
		$return =
		'font-family:'.$array['fontfamily'].$important_css.';'
		.'color:'.$array['color'].';'
		.'letter-spacing:'.$array['letterspacing'].'em;'
		.'line-height:'.$array['lineheight'].';'
		.'font-weight:'.$fontweight.';'
		.$caps
		.$italic
		.$underline
		.$variablesettings;

		if( $simple == false ) {
			$return .=
			'padding: 0;'
			.'text-indent:'.$textindent.'em;'
			.$borderbottom
			.'text-align:'.$textalign.';';
		}

		return $return;
	}

	public static function get_format_arr(){
		$formatsJsonString = FormatsManager::getDefaultFormatsJson();
		$formatsJsonArr = json_decode($formatsJsonString, true);
		return $formatsJsonArr;
	}

	public static function get_textformat_css_for_selector($formatname, $selector, $spaces = true, $important = false, $mediaQueries = true){

		$formatsJsonArr = FormatsManager::get_format_arr();
		$formatsCSS = '';

		for ($i = 0; $i<count($formatsJsonArr); $i++) {
			if ($formatsJsonArr[$i]["formatname"] == $formatname) {
				$formatsCSS .= FormatsManager::get_css_for_selector( $formatsJsonArr[$i], $selector, $spaces, $important, $mediaQueries );
				break;
			}
		}
		// error_log(print_r($formatsCSS, true));
		return $formatsCSS;
	}

	public static function frontend_textformats_css() {
		// Default format must be before all other formats, otherwise the default format's CSS will overwrite other textformats
		// thats why im using a extra variable $defaultFormatCSS here
		// Default format could be somewhere else because of re-ordering feature in textformats

		$formatsJsonArr = FormatsManager::get_format_arr();
		$defaultFormatCSS = '';
		$formatsCSS = '';

		for ($i = 0; $i<count($formatsJsonArr); $i++) {
			if( $formatsJsonArr[$i]["formatname"] == "Default" ) {
				$defaultFormatCSS .= FormatsManager::get_css_for_format( $formatsJsonArr[$i] );
			} else {
				$formatsCSS .= FormatsManager::get_css_for_format( $formatsJsonArr[$i] );
			}
		}

		$combinedFormats = $defaultFormatCSS.$formatsCSS;

		// error_log(print_r($combinedFormats, true));

		if ($combinedFormats != "") {
			wp_add_inline_style( 'frontend-style',
			$combinedFormats );
		}
	}

	public static function get_css_for_format($format){
		$formatsCSS = '';
		if ($format["formatname"] == "Default") {
			// "Default" textformat
			$formatsCSS .=
				'
					/* default text format "Default" */
					.lay-textformat-parent > *, ._Default, ._Default_no_spaces{
						'.FormatsManager::getFontCSS($format).'
					}';

			if (FormatsManager::$hasTabletSettings) {
				$formatsCSS .=
					'@media (min-width: '.(MiscOptions::$tablet_breakpoint+1).'px){
						.lay-textformat-parent > *, ._Default{
							'.FormatsManager::getDesktopSpecificCSS($format, true).'
						}
						._Default_no_spaces{
							'.FormatsManager::getDesktopSpecificCSS($format, false).'
						}
						.lay-textformat-parent > *:last-child, ._Default:last-child{
							margin-bottom: 0;
						}
					}
					@media (min-width: '.(MiscOptions::$phone_breakpoint+1).'px) and (max-width: '.(MiscOptions::$tablet_breakpoint).'px){
						.lay-textformat-parent > *, ._Default{
							'.FormatsManager::getTabletSpecificCSS($format, true).'
						}
						._Default_no_spaces{
							'.FormatsManager::getTabletSpecificCSS($format, false).'
						}
						.lay-textformat-parent > *:last-child, ._Default:last-child{
							margin-bottom: 0;
						}
					}
					@media (max-width: '.(MiscOptions::$phone_breakpoint).'px){
						.lay-textformat-parent > *, ._Default{
							'.FormatsManager::getPhoneSpecificCSS($format, true).'
						}
						._Default_no_spaces{
							'.FormatsManager::getPhoneSpecificCSS($format, false).'
						}
						.lay-textformat-parent > *:last-child, ._Default:last-child{
							margin-bottom: 0;
						}
					}';
			} else {
				$formatsCSS .=
					'.lay-textformat-parent > *, ._Default, ._Default_no_spaces{
						'.FormatsManager::getFontCSS($format).'
					}
					.lay-textformat-parent > *:last-child, ._Default:last-child{
						margin-bottom: 0;
					}
					@media (min-width: '.(MiscOptions::$phone_breakpoint+1).'px){
						.lay-textformat-parent > *, ._Default{
							'.FormatsManager::getDesktopSpecificCSS($format, true).'
						}
						._Default_no_spaces{
							'.FormatsManager::getDesktopSpecificCSS($format, false).'
						}
						.lay-textformat-parent > *:last-child, ._Default:last-child{
							margin-bottom: 0;
						}
					}
					@media (max-width: '.(MiscOptions::$phone_breakpoint).'px){
						.lay-textformat-parent > *, ._Default{
							'.FormatsManager::getPhoneSpecificCSS($format, true).'
						}
						._Default_no_spaces{
							'.FormatsManager::getPhoneSpecificCSS($format, false).'
						}
						.lay-textformat-parent > *:last-child, ._Default:last-child{
							margin-bottom: 0;
						}
					}';
			}
		} else {
			$formatsCSS .=
				'._'.$format['formatname'].', ._'.$format['formatname'].'_no_spaces{'
					.FormatsManager::getFontCSS($format)
				.'}';
			// custom textformats
			if (FormatsManager::$hasTabletSettings) {
				$formatsCSS .=
					'@media (min-width: '.(MiscOptions::$tablet_breakpoint+1).'px){
						._'.$format['formatname'].'{'
							.FormatsManager::getDesktopSpecificCSS($format, true).
						'}
						._'.$format['formatname'].':last-child{
							margin-bottom: 0;
						}
						._'.$format['formatname'].'_no_spaces{'
							.FormatsManager::getDesktopSpecificCSS($format, false).
						'}
					}
						@media (min-width: '.(MiscOptions::$phone_breakpoint+1).'px) and (max-width: '.((int)MiscOptions::$tablet_breakpoint).'px){
							._'.$format['formatname'].'{'
								.FormatsManager::getTabletSpecificCSS($format, true).
							'}
							._'.$format['formatname'].':last-child{
								margin-bottom: 0;
							}
							._'.$format['formatname'].'_no_spaces{'
								.FormatsManager::getTabletSpecificCSS($format, false).
							'}
						}
						@media (max-width: '.(MiscOptions::$phone_breakpoint).'px){
							._'.$format['formatname'].'{'
								.FormatsManager::getPhoneSpecificCSS($format, true).
							'}
							._'.$format['formatname'].':last-child{
								margin-bottom: 0;
							}
							._'.$format['formatname'].'_no_spaces{'
								.FormatsManager::getPhoneSpecificCSS($format, false).
							'}
						}';
			} else {
				$formatsCSS .=
					'@media (min-width: '.(MiscOptions::$phone_breakpoint+1).'px){
						._'.$format['formatname'].'{'
							.FormatsManager::getDesktopSpecificCSS($format, true)
						.'}
						._'.$format['formatname'].':last-child{
							margin-bottom: 0;
						}
						._'.$format['formatname'].'_no_spaces{'
							.FormatsManager::getDesktopSpecificCSS($format, false)
						.'}
					}'
					.'@media (max-width: '.(MiscOptions::$phone_breakpoint).'px){
						._'.$format['formatname'].'{'
							.FormatsManager::getPhoneSpecificCSS($format, true)
						.'}
						._'.$format['formatname'].':last-child{
							margin-bottom: 0;
						}
						._'.$format['formatname'].'_no_spaces{'
							.FormatsManager::getPhoneSpecificCSS($format, false)
						.'}
					}';
			}
		}
		return $formatsCSS;
	}

	public static function get_css_for_selector( $format, $selector, $spaces, $important, $mediaQueries ){
		$formatsCSS = '';
        if( $mediaQueries == false ) {
            return $selector.'{
				'.FormatsManager::getFontCSS($format, true, $important).'
                '.FormatsManager::getDesktopSpecificCSS($format, $spaces).'
			}';
        }
		if (FormatsManager::$hasTabletSettings) {
			$formatsCSS .=
			$selector.'{
				'.FormatsManager::getFontCSS($format, true, $important).'
			}
			@media (min-width: '.(MiscOptions::$tablet_breakpoint+1).'px){
				'.$selector.'{
					'.FormatsManager::getDesktopSpecificCSS($format, $spaces).'
				}
			}
			@media (min-width: '.(MiscOptions::$phone_breakpoint+1).'px) and (max-width: '.(MiscOptions::$tablet_breakpoint).'px){
				'.$selector.'{
					'.FormatsManager::getTabletSpecificCSS($format, $spaces).'
				}
			}
			@media (max-width: '.(MiscOptions::$phone_breakpoint).'px){
				'.$selector.'{
					'.FormatsManager::getPhoneSpecificCSS($format, $spaces).'
				}
			}';
		} else {
			$formatsCSS .=
			$selector.'{
				'.FormatsManager::getFontCSS($format, true, $important).'
			}
			@media (min-width: '.(MiscOptions::$phone_breakpoint+1).'px){
				'.$selector.'{
					'.FormatsManager::getDesktopSpecificCSS($format, $spaces).'
				}
			}
			@media (max-width: '.(MiscOptions::$phone_breakpoint).'px){
				'.$selector.'{
					'.FormatsManager::getPhoneSpecificCSS($format, $spaces).'
				}
			}';
		}
		return $formatsCSS;
	}

	public static function gridder_textformats_css() {
		$screen = get_current_screen();
		if ( LTUtility::is_admin_page_with_a_gridder($screen) ) {
			// $formatsJsonString = FormatsManager::getDefaultFormatsJson();
			$formatsJsonString = FormatsManager::getDefaultFormatsJson();
			$formatsJsonArr = json_decode($formatsJsonString, true);

			$formatsCSS = '';

			for ($i = 0; $i<count($formatsJsonArr); $i++) {
				$format = $formatsJsonArr[$i];
				if ($format["formatname"] == "Default") {
					// "Default" textformat

					echo
						'<!-- default text format "Default" -->
						<style class="textformats-style">
							#gridder .lay-textformat-parent > *,
							#gridder ._Default,
							#gridder ._Default_no_spaces{
								'.FormatsManager::getFontCSS($format).'
							}
							#gridder .show-desktop-version .lay-textformat-parent > *,
							#gridder .show-desktop-version ._Default,
							#gridder .lay-input-modal .preview-desktop ._Default{
								'.FormatsManager::getDesktopSpecificCSS($format, true).'
							}
							#gridder .show-desktop-version ._Default_no_spaces,
							#gridder .lay-input-modal .preview-desktop ._Default_no_spaces{
								'.FormatsManager::getDesktopSpecificCSS($format, false).'
							}
							#gridder .lay-input-modal .preview-tablet ._Default{
								'.FormatsManager::getTabletSpecificCSS($format, true).'
							}
							#gridder .lay-input-modal .preview-tablet ._Default_no_spaces{
								'.FormatsManager::getTabletSpecificCSS($format, false).'
							}
							#gridder .show-phone-version .lay-textformat-parent > *,
							#gridder .show-phone-version ._Default,
							#gridder .lay-input-modal .preview-phone ._Default{
								'.FormatsManager::getPhoneSpecificCSS($format, true).'
							}
							#gridder .show-phone-version ._Default_no_spaces,
							#gridder .lay-input-modal .preview-phone ._Default_no_spaces{
								'.FormatsManager::getPhoneSpecificCSS($format, false).'
							}
							/* for draggable items */
							.lay-textformat-parent > *,
							._Default,
							._Default_no_spaces{
								'.FormatsManager::getFontCSS($format).'
								'.FormatsManager::getDesktopSpecificCSS($format, false).'
							}
						</style>';
				} else {
					// custom textformats
					$formatsCSS .=
						'#gridder .lay-textformat-parent ._'.$format['formatname'].'{'
							.FormatsManager::getFontCSS($format).
						'}
						#gridder ._'.$format['formatname'].'_no_spaces{'
							.FormatsManager::getFontCSS($format).
						'}
						#gridder .show-desktop-version .lay-textformat-parent ._'.$format['formatname'].',
						#gridder .lay-input-modal .preview-desktop ._'.$format['formatname'].'{'
							.FormatsManager::getDesktopSpecificCSS($format, true).
						'}
						#gridder .show-desktop-version ._'.$format['formatname'].'_no_spaces,
						#gridder .lay-input-modal .preview-desktop ._'.$format['formatname'].'_no_spaces{'
							.FormatsManager::getDesktopSpecificCSS($format, false).
						'}
						#gridder .lay-input-modal .preview-tablet ._'.$format['formatname'].'{
							'.FormatsManager::getTabletSpecificCSS($format, true).'
						}
						#gridder .lay-input-modal .preview-tablet ._'.$format['formatname'].'_no_spaces{
							'.FormatsManager::getTabletSpecificCSS($format, false).'
						}
						#gridder .show-phone-version .lay-textformat-parent ._'.$format['formatname'].',
						#gridder .lay-input-modal .preview-phone ._'.$format['formatname'].'{'
							.FormatsManager::getPhoneSpecificCSS($format, true).
						'}
						#gridder .show-phone-version ._'.$format['formatname'].'_no_spaces,
						#gridder .lay-input-modal .preview-phone ._'.$format['formatname'].'_no_spaces{'
							.FormatsManager::getPhoneSpecificCSS($format, false).
						'}
						/* for draggable items */
						.lay-textformat-parent ._'.$format['formatname'].'{'
							.FormatsManager::getFontCSS($format)
							.FormatsManager::getDesktopSpecificCSS($format, true).
						'}
						._'.$format['formatname'].'_no_spaces{'
							.FormatsManager::getFontCSS($format)
							.FormatsManager::getDesktopSpecificCSS($format, false).
						'}';
				}
			}

			if ($formatsCSS != "") {
				echo
				'<!-- custom text formats -->
				<style class="textformats-style" id="custom-textformats-style">
					'.$formatsCSS.'
				</style>';
			}
		}
	}

	// 
	public static function updateCustomizerStylesLinkedWithTextformats(){
		$textFormatsJsonString = FormatsManager::getDefaultFormatsJson();
		$textFormatsJsonArr = json_decode($textFormatsJsonString, true);

		$prefixes  = array('st_', 'pt_', 'nav_', 'pa_', 'tagline_', 'm_st_', 'intro_text_');

		foreach ($prefixes as $prefix) {
			$format_name = get_theme_mod($prefix.'textformat', 'Default');
			if($format_name){
				foreach ($textFormatsJsonArr as $value) {
					if ($format_name == $value['formatname']) {

						$fontweight = array_key_exists('fontweight', $value) ? $value['fontweight'] : '400';
						$fontsizemu = array_key_exists('fontsizemu', $value) ? $value['fontsizemu'] : 'px';

						set_theme_mod($prefix.'color', $value['color']);
						set_theme_mod($prefix.'fontfamily', $value['fontfamily']);
						set_theme_mod($prefix.'fontweight', $fontweight);
						set_theme_mod($prefix.'letterspacing', $value['letterspacing']);
						
						// for mobile site title i need to set phone fontsize and phone fontsizemu instead of desktop versions
						if($prefix == "m_st_"){
							$phonefontsize = array_key_exists('phone-fontsize', $value) ? $value['phone-fontsize'] : '16';
							set_theme_mod('mobile_menu_sitetitle_fontsize', $phonefontsize);

							$phonefontsizemu = array_key_exists('phone-fontsizemu', $value) ? $value['phone-fontsizemu'] : 'px';
							set_theme_mod('m_st_fontsize_mu', $phonefontsizemu);

						} else {
							set_theme_mod($prefix.'fontsize', $value['fontsize']);
							set_theme_mod($prefix.'fontsize_mu', $fontsizemu);
						}

						if ($prefix == "pt_") {
							set_theme_mod($prefix.'lineheight', $value['lineheight']);
							set_theme_mod($prefix.'align', $value['textalign']);
						}

						if ($prefix == "intro_text_") {
							set_theme_mod($prefix.'lineheight', $value['lineheight']);
							set_theme_mod($prefix.'align', $value['textalign']);
						}

					}
				}
			}
		}

	}

	public static function formatsmanager_styles($hook) {
		if ( $hook == 'toplevel_page_manage-textformats' ) {
			wp_enqueue_style( 'formatsmanager-parsley', Setup::$uri.'/assets/css/parsley.css' );
			wp_enqueue_style( 'formatsmanager-iris', Setup::$uri.'/formatsmanager/assets/css/iris.css' );
			wp_enqueue_style( 'formatsmanager-bootstrap', Setup::$uri.'/assets/bootstrap/css/bootstrap.css' );
			wp_enqueue_style( 'formatsmanager-application', Setup::$uri.'/formatsmanager/assets/css/formatsmanager.style.css', array(), Setup::$ver );
		}
	}

	public static function register_scripts(){
		// using modified version of iris to prevent scrolling when user drags inside colorpicker
		wp_register_script( 'lay-opentype', Setup::$uri."/formatsmanager/assets/js/vendor/opentype.js", array(),  Setup::$ver );
		wp_register_script( 'lay-variablefont', Setup::$uri."/formatsmanager/assets/js/vendor/variablefont.js", array(),  Setup::$ver );
		wp_register_script( 'lay-sortable', Setup::$uri."/formatsmanager/assets/js/vendor/sortable.min.js", array(),  Setup::$ver );
	}

	public static function formatsmanager_scripts($hook){
		if ( $hook == 'toplevel_page_manage-textformats' ) {
			wp_enqueue_script( 'plugin-bootstrap', Setup::$uri."/assets/bootstrap/js/bootstrap.min.js", array( 'jquery' ), Setup::$ver);
			wp_enqueue_script( 'plugin-parsley', Setup::$uri."/assets/js/vendor/parsley.js", array( 'jquery' ), Setup::$ver);
			wp_enqueue_script( 'formatsmanager-app', Setup::$uri."/formatsmanager/assets/js/formatsmanager.app.min.js", array( 'jquery', 'lay-iris', 'lay-sortable', 'lay-opentype', 'lay-variablefont', 'marionettev3', 'underscore' ), Setup::$ver, true);
			wp_localize_script( 'formatsmanager-app', 'formatslgPassedData', array(
				'advancedLineHeights' => false,
				'woocommerceActive' => class_exists('WooCommerce')
			) 
		);
		}
	}

	public static function register_settings() {
		register_setting( 'admin-textformats-settings', 'formatsmanager_json' );
	}

	public static function textformats_setup_menu(){
		add_menu_page( 'Text Formats', 'Text Formats', 'manage_options', 'manage-textformats', 'FormatsManager::textformats_markup', 'dashicons-editor-textcolor', 998 );
	}

	public static function textformats_markup(){
		require_once( Setup::$dir.'/formatsmanager/markup.php' );
	}
}
FormatsManager::init();
