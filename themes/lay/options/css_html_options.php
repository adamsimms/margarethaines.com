<?php
// http://codex.wordpress.org/Settings_API#Examples
class CSSHTMLOptions{

	public function __construct(){
		add_action( 'admin_menu', array($this, 'htmlcss_options_setup_menu'), 10 );
		add_action( 'admin_init', array($this, 'options_settings_api_init') );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts_for_ace') );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_styles_for_ace') );
		add_action( 'pre_update_option_custom_css', array($this, 'on_custom_css_option_saved'), 10, 2 );
		add_filter( 'wp_get_custom_css', array($this, 'maybe_turn_off_custom_css' ), 10, 2);
	}

	// this is wordpress' core customc css. it is not an option, but a custom post. so i have to save it differently
	public function on_custom_css_option_saved($new_value, $old_value){
		wp_update_custom_css_post($new_value);
	}

	public function maybe_turn_off_custom_css($css, $stylesheet){
		if(!LayFrontend_Options::$turn_off_custom_code){
			return $css;
		}else{
			if( is_admin() ) {
				return $css;
			}
			return '';
		}
	}

	public function htmlcss_options_setup_menu(){
		// http://wordpress.stackexchange.com/questions/66498/add-menu-page-with-different-name-for-first-submenu-item
        add_submenu_page( 'manage-layoptions', 'Custom CSS & HTML', 'Custom CSS & HTML', 'manage_options', 'manage-htmlcssoptions', array($this, 'htmlcss_options_markup') );
	}

	public function htmlcss_options_markup(){
		require_once( Setup::$dir.'/options/css_html_options_markup.php' );
	}

	public function enqueue_styles_for_ace($hook){
		if( $hook == 'lay-options_page_manage-htmlcssoptions' ){
			wp_enqueue_style( 'ace-style', Setup::$uri.'/options/assets/css/lay-customcss-customhtml-style.css', array(), Setup::$ver );
		}
	}

	public function enqueue_scripts_for_ace($hook){
		if( $hook == 'lay-options_page_manage-htmlcssoptions' ){
			wp_enqueue_script( 'vendor-ace', Setup::$uri.'/assets/js/vendor/ace/ace.js', array(), Setup::$ver );
			wp_enqueue_script( 'misc_options-ace-controller', Setup::$uri.'/options/assets/js/ace_controller.js', array(), Setup::$ver );
		}
	}

	public function options_settings_api_init(){
	 	add_settings_section(
			'htmlcss_options_section',
			'',
			'',
			'manage-htmlcssoptions'
		);

		add_settings_field(
			'misc_setting_turn_off_custom_code',
			'Turn Off All Custom Code',
			array($this, 'misc_setting_turn_off_custom_code_setting'),
			'manage-htmlcssoptions',
			'htmlcss_options_section'
		);
		 register_setting( 'manage-htmlcssoptions', 'misc_setting_turn_off_custom_code' );

 	 	add_settings_field(
 			'misc_options_analytics_code',
 			'Custom &lt;head&gt; content',
 			array($this, 'misc_setting_custom_head_content'),
 			'manage-htmlcssoptions',
 			'htmlcss_options_section'
 		);
 	 	register_setting( 'manage-htmlcssoptions', 'misc_options_analytics_code' );

 	 	add_settings_field(
 			'misc_options_custom_htmltop',
 			'Custom HTML at top',
 			array($this, 'misc_setting_custom_htmltop'),
 			'manage-htmlcssoptions',
 			'htmlcss_options_section'
 		);
 	 	register_setting( 'manage-htmlcssoptions', 'misc_options_custom_htmltop' );

 	 	add_settings_field(
 			'misc_options_custom_htmlbottom',
 			'Custom HTML at bottom',
 			array($this, 'misc_setting_custom_htmlbottom'),
 			'manage-htmlcssoptions',
 			'htmlcss_options_section'
 		);
 	 	register_setting( 'manage-htmlcssoptions', 'misc_options_custom_htmlbottom' );

 	 	add_settings_field(
			'custom_css',
			'CSS',
			array($this, 'misc_setting_css'),
			'manage-htmlcssoptions',
			'htmlcss_options_section'
		);
		register_setting( 'manage-htmlcssoptions', 'custom_css' );

 	 	add_settings_field(
 			'misc_options_desktop_css',
 			'CSS for Desktop',
 			array($this, 'misc_setting_desktop_css'),
 			'manage-htmlcssoptions',
 			'htmlcss_options_section'
 		);
 	 	register_setting( 'manage-htmlcssoptions', 'misc_options_desktop_css' );

 	 	add_settings_field(
 			'misc_options_mobile_css',
 			'CSS for Mobile',
 			array($this, 'misc_setting_mobile_css'),
 			'manage-htmlcssoptions',
 			'htmlcss_options_section'
 		);
 	 	register_setting( 'manage-htmlcssoptions', 'misc_options_mobile_css' );

	}

	public function misc_setting_custom_htmlbottom(){
		$html_content = get_option( 'misc_options_custom_htmlbottom', '' );
		echo
		'<textarea style="max-width: 700px; width: 100%; height: 150px;" name="misc_options_custom_htmlbottom" id="misc_options_custom_htmlbottom">'.$html_content.'</textarea>';
	}

	public function misc_setting_custom_htmltop(){
		$html_content = get_option( 'misc_options_custom_htmltop', '' );
		echo
		'<textarea style="max-width: 700px; width: 100%; height: 150px;" name="misc_options_custom_htmltop" id="misc_options_custom_htmltop">'.$html_content.'</textarea>';
	}

	public function misc_setting_custom_head_content(){
		$custom_head_content = get_option( 'misc_options_analytics_code', '' );
		echo
		'<textarea style="max-width: 700px; width: 100%; height: 150px;" name="misc_options_analytics_code" id="misc_options_analytics_code">'.$custom_head_content.'</textarea>';
	}

	public function misc_setting_css(){
		// this is wordpress' core customc css. it is not an option, but a custom post. so i have to retrieve it differently
		$css = wp_get_custom_css();
		echo '<textarea style="max-width: 700px; width: 100%; height: 150px;" name="custom_css" id="custom_css">'.$css.'</textarea>';
	}

	public function misc_setting_desktop_css(){
		$css = get_option( 'misc_options_desktop_css', '' );
		echo '<textarea style="max-width: 700px; width: 100%; height: 150px;" name="misc_options_desktop_css" id="misc_options_desktop_css">'.$css.'</textarea>';
	}

	public function misc_setting_mobile_css(){
		$css = get_option( 'misc_options_mobile_css', '' );
		echo '<textarea style="max-width: 700px; width: 100%; height: 150px;" name="misc_options_mobile_css" id="misc_options_mobile_css">'.$css.'</textarea>';
	}

	public static function misc_setting_turn_off_custom_code_setting(){
		$val = get_option( 'misc_setting_turn_off_custom_code', "" );
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_setting_turn_off_custom_code" id="misc_setting_turn_off_custom_code" '.$checked.'>';
	}

	public static function getCustomCSSEditorMarkup(){
		echo
		'<div class="lay-ace-editor-wrap">
			<h3>Custom CSS</h3>
			<div id="lay-custom-css-editor">
			</div>
		</div>';
	}

	public static function getCustomDesktopCSSEditorMarkup(){
		$breakpoint = get_option('lay_breakpoint', 600);
		$breakpoint = (int)$breakpoint;
		echo
		'<div class="lay-ace-editor-wrap">
			<h3>Custom CSS for Desktop Version</h3>
			<p>
				Your CSS below is inserted into the media query for the desktop version: <code>@media (min-width: '.($breakpoint+1).'px){&hellip;}</code>
			</p>
			<div id="lay-custom-css-desktop-editor">
			</div>
		</div>';
	}

	public static function getCustomMobileCSSEditorMarkup(){
		$breakpoint = get_option('lay_breakpoint', 600);
		echo
		'<div class="lay-ace-editor-wrap">
			<h3>Custom CSS for Mobile Version</h3>
			<p>
				Your CSS below is inserted into the media query for the mobile version: <code>@media (max-width: '.$breakpoint.'px){&hellip;}</code>
			</p>
			<div id="lay-custom-css-mobile-editor">
			</div>
		</div>';
	}

	public static function getCustomHeadContentEditorMarkup(){
		echo
		'<div class="lay-ace-editor-wrap">
			<h3>Custom &lt;head&gt; content</h3>
			<p>
				Enter custom HTML here (ex. JavaScript, Meta Tags, etc.), which will be appended to the &lt;head&gt; section of your website\'s markup. If you use an Analytics Service like "Google Analytics", paste your Analytics Code below. Malformed code may break your site.
			</p>
			<div id="lay-custom-head-content-editor">
			</div>
		</div>';
	}

	public static function getCustomHTMLTopEditorMarkup(){
		echo
		'<div class="lay-ace-editor-wrap">
			<h3>Custom HTML at top</h3>
			<p>
				This HTML markup will appear right after the opening &lt;body&gt; tag. Malformed code may break your site.
			</p>
			<div id="lay-custom-htmltop-editor">
			</div>
		</div>';
	}

	public static function getCustomHTMLBottomEditorMarkup(){
		echo
		'<div class="lay-ace-editor-wrap">
			<h3>Custom HTML at bottom</h3>
			<p>
				This HTML markup will appear right before the closing &lt;/body&gt; tag. Malformed code may break your site.
			</p>
			<div id="lay-custom-htmlbottom-editor">
			</div>
		</div>';
	}

}

new CSSHTMLOptions();
