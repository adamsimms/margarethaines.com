<?php
class FontManager{

	public static $customFonts = NULL;
	public static $originalFonts;

	public function __construct(){

		$customFontsJSON = get_option('fontmanager_json', false);
		if($customFontsJSON){
			FontManager::$customFonts = json_decode($customFontsJSON, true);
		}

		FontManager::$originalFonts = array(
			'Andale Mono' => 'andale mono,times,serif',
			'Arial' => 'arial,helvetica,sans-serif',
			'Arial Black' => 'arial black,avant garde,sans-serif',
			'Book Antiqua' => 'book antiqua,palatino,serif',
			'Comic Sans MS' => 'comic sans ms,sans-serif',
			'Courier New' => 'courier new,courier,monospace',
			'Georgia' => 'georgia,palatino,serif',
			'Helvetica' => 'helvetica,sans-serif',
			'Helvetica Neue' => 'helvetica neue,sans-serif',
			'Impact' => 'impact,chicago,sans-serif',
			'Tahoma' => 'tahoma,arial,helvetica,sans-serif',
			'Terminal' => 'terminal,monaco,monospace',
			'Times New Roman' => 'times new roman,times,serif',
			'Trebuchet MS' => 'trebuchet ms,geneva,sans-serif',
			'Verdana' => 'verdana,geneva,sans-serif'
		);

		add_action( 'admin_menu', array($this, 'font_setup_menu'), 11 );
		add_action( 'admin_init', array($this, 'fontmanager_json_settings_api_init') );

		add_action( 'admin_enqueue_scripts', array( $this, 'fontmanager_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'fontmanager_scripts' ) );
		
		add_filter( 'upload_mimes', array( $this, 'add_files_to_allowed_mimes' ), 10, 1 );
        // add_filter( 'wp_check_filetype_and_ext', array( $this, 'add_multiple_mime_types'), 99, 3 );

		add_filter( 'wp_check_filetype_and_ext', array( $this, 'update_mime_types' ), 10, 3 );


		add_action( 'admin_enqueue_scripts', array( $this, 'backend_add_attachment_webfonts' ), 9 );
		add_action( 'admin_head', array( $this, 'backend_add_external_webfonts' ), 9 );

		add_action( 'wp_head', array( $this, 'frontend_add_attachment_webfonts' ) );
		add_action( 'wp_head', array( $this, 'frontend_add_external_webfonts' ) );

		add_action( 'admin_footer', array( $this, 'print_fontmanager_JSON' ) );
		add_action( 'mce_external_plugins', array( $this, 'tinymce_add_fontloader') );
		add_filter( 'tiny_mce_before_init', array( $this, 'tinymce_add_fontmanager_fonts') );

	}

	// add link tags to gridder
	public function backend_add_external_webfonts(){
		$screen = get_current_screen();
		if ( $screen->id == 'toplevel_page_manage-textformats' || $screen->id == 'lay-options_page_manage-webfonts' || LTUtility::is_admin_page_with_a_gridder($screen) ) {
			if (is_array(FontManager::$customFonts)) {
				for($i=0; $i<count(FontManager::$customFonts); $i++){
					if(array_key_exists('type', FontManager::$customFonts[$i]) && FontManager::$customFonts[$i]['type'] == "link" ){
						echo FontManager::$customFonts[$i]['link'];
					}
					if(array_key_exists('type', FontManager::$customFonts[$i]) && FontManager::$customFonts[$i]['type'] == "script" ){
						echo FontManager::$customFonts[$i]['script'];
					}
				}
			}
		}
	}

	// add font face css to gridder
	public function backend_add_attachment_webfonts(){
		$screen = get_current_screen();
		if ( $screen->id == 'toplevel_page_manage-textformats' || $screen->id == 'lay-options_page_manage-webfonts' || LTUtility::is_admin_page_with_a_gridder($screen) ) {
			$newfontsCSS = '';
			if (is_array(FontManager::$customFonts)) {
				for($i=0; $i<count(FontManager::$customFonts); $i++){
					if(!array_key_exists('type', FontManager::$customFonts[$i]) || FontManager::$customFonts[$i]['type'] == "attachment" ){
						$url = FontManager::$customFonts[$i]['url'];
						$url = LTUtility::filterURL($url);
						if( array_key_exists('id', FontManager::$customFonts[$i]) ){
							$temp_url = wp_get_attachment_url(FontManager::$customFonts[$i]['id']);
                            if( $temp_url != '' && $temp_url != false ) {
                                $url = $temp_url;
                                // somehow wp_get_attachment_url does not account for whether I'm on http or https
							    // maybe this is a wordpress bug
                                $url = LTUtility::filterURL($url);
                            }
						}

						$fileformat = 'woff';
						if(array_key_exists('filetype', FontManager::$customFonts[$i]) && FontManager::$customFonts[$i]['filetype'] != ''){
							$fileformat = FontManager::$customFonts[$i]['filetype'];
						}

						$newfontsCSS .= '@font-face{ font-family: "'.FontManager::$customFonts[$i]['fontname'].'"; src: url("'.$url.'") format("'.$fileformat.'"); '.(get_option('misc_options_swap_webfonts', 'on') == 'on' ? 'font-display: swap;' : '').' } ';
					}
				}
			}
			wp_add_inline_style( 'wp-admin', $newfontsCSS );
		}
	}

	public function frontend_add_external_webfonts(){
		if (is_array(FontManager::$customFonts)) {
			for($i=0; $i<count(FontManager::$customFonts); $i++){
				if(array_key_exists('type', FontManager::$customFonts[$i]) && FontManager::$customFonts[$i]['type'] == "link" ){
					echo FontManager::$customFonts[$i]['link'];
				}
				if(array_key_exists('type', FontManager::$customFonts[$i]) && FontManager::$customFonts[$i]['type'] == "script" ){
					echo FontManager::$customFonts[$i]['script'];
				}
			}
		}
	}

	public function frontend_add_attachment_webfonts(){
		$newfontsCSS =
		'<!-- webfonts -->
		<style type="text/css">';
		if (is_array(FontManager::$customFonts)) {
			for($i=0; $i<count(FontManager::$customFonts); $i++){
				if(!array_key_exists('type', FontManager::$customFonts[$i]) || FontManager::$customFonts[$i]['type'] == "attachment" ){
					$url = FontManager::$customFonts[$i]['url'];
					$url = LTUtility::filterURL($url);
					if( array_key_exists('id', FontManager::$customFonts[$i]) ){
						$temp_url = wp_get_attachment_url(FontManager::$customFonts[$i]['id']);
                        if( $temp_url != '' && $temp_url != false ) {
                            $url = $temp_url;
						    // somehow wp_get_attachment_url does not account for whether I'm on http or https
						    // maybe this is a wordpress bug
						    $url = LTUtility::filterURL($url);
                        }

					}

					$fileformat = 'woff';
					if(array_key_exists('filetype', FontManager::$customFonts[$i]) && trim(FontManager::$customFonts[$i]['filetype']) != ''){
						$fileformat = FontManager::$customFonts[$i]['filetype'];
					}

					$newfontsCSS .= '@font-face{ font-family: "'.FontManager::$customFonts[$i]['fontname'].'"; src: url("'.$url.'") format("'.$fileformat.'"); '.(get_option('misc_options_swap_webfonts', 'on') == 'on' ? 'font-display: swap;' : '').' } ';
				}
			}
		}
		$newfontsCSS .= '</style>';
		echo $newfontsCSS;
	}

	public function tinymce_add_fontmanager_fonts( $initArray ) {
		// $original = 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
		$original = '';

		foreach (FontManager::$originalFonts as $key => $value) {
			$original .= $key.'='.$value.';';
		}

		$newfonts = '';

		if(is_array(FontManager::$customFonts)){
			for($i=0; $i<count(FontManager::$customFonts); $i++){
				if(!array_key_exists('type', FontManager::$customFonts[$i]) || FontManager::$customFonts[$i]['type'] == "attachment" ){
					$newfonts .= FontManager::$customFonts[$i]['fontname'].'='.FontManager::$customFonts[$i]['fontname'].';';
				}
				else if(FontManager::$customFonts[$i]['type'] == "link" || FontManager::$customFonts[$i]['type'] == "script"){
					$css = FontManager::$customFonts[$i]['css'];

					$css = str_replace('font-family: ', '', $css);
					$css = str_replace('font-family:', '', $css);
					$css = str_replace(';', '', $css);

					$newfonts .= FontManager::$customFonts[$i]['fontname'].'='.$css.';';
				}
			}
		}

		$initArray['font_formats'] = $newfonts.$original;

		return $initArray;
	}

	public function tinymce_add_fontloader( $plugins ) {
		$plugins['fontloader'] = Setup::$uri.'/fontmanager/assets/js/tinymce_plugin/tinymce_fontloader.js?ver='.Setup::$ver;
		return $plugins;
	}

	// needed for "repositionAfterWebfontsLoaded"
	public function print_fontmanager_JSON(){
		$screen = get_current_screen();
		if ( $screen->id == 'post' || $screen->id == 'page' || $screen->id == 'edit-category' ||  LTUtility::is_admin_page_with_a_gridder($screen) ) {
			echo '<textarea style="display: none;" id="fontmanager_json" name="fontmanager_json">'.get_option('fontmanager_json').'</textarea>';
		}
	}

    // public static function add_multiple_mime_types( $check, $file, $filename ) {
    //     if ( empty( $check['ext'] ) && empty( $check['type'] ) ) {
    //         foreach ( FontManager::get_allowed_mime_types() as $mime ) {
    //             remove_filter( 'wp_check_filetype_and_ext', array( $this, 'add_multiple_mime_types' ), 99 );
    //             $mime_filter = function($mimes) use ($mime) {
    //                 return array_merge($mimes, $mime);
    //             };

    //             add_filter('upload_mimes', $mime_filter, 99);
    //             $check = wp_check_filetype_and_ext( $file, $filename, $mime );
    //             remove_filter('upload_mimes', $mime_filter, 99);
    //             add_filter( 'wp_check_filetype_and_ext', array( $this, 'add_multiple_mime_types' ), 99, 3 );
    //             if ( ! empty( $check['ext'] ) || ! empty( $check['type'] ) ) {
    //                 return $check;
    //             }
    //         }
    //     }

    //     return $check;
    // }


    // public static function get_allowed_mime_types(){
    //     return [
    //         [ 'woff2' => 'font/woff2' ],
    //         [ 'woff2' => 'application/font-woff2' ],
    //         [ 'woff2' => 'application/x-font-woff2' ],
    //         [ 'woff' => 'font/woff' ],
    //         [ 'woff' => 'application/font-woff' ],
    //         [ 'woff' => 'application/x-font-woff' ],
    //     ];
    // }

	public function add_files_to_allowed_mimes( $mimes ) {
		$mimes['woff']  = 'font/woff';
		$mimes['woff2'] = 'font/woff2';
		$mimes['ttf']   = 'application/x-font-ttf';
		$mimes['svg']   = 'image/svg+xml';
		$mimes['eot']   = 'application/vnd.ms-fontobject';
		$mimes['otf']   = 'font/otf';

		return $mimes;
	}

	public function update_mime_types( $defaults, $file, $filename ) {
		if ( 'ttf' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
			$defaults['type'] = 'application/x-font-ttf';
			$defaults['ext']  = 'ttf';
		}

        if ( 'woff' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
			$defaults['type'] = 'font/woff';
			$defaults['ext']  = 'woff';
		}

        if ( 'woff2' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
			$defaults['type'] = 'font/woff2';
			$defaults['ext']  = 'woff2';
		}

		if ( 'otf' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
			$defaults['type'] = 'application/x-font-otf';
			$defaults['ext']  = 'otf';
		}

		return $defaults;
	}

	public function fontmanager_styles($hook) {
		if ( $hook == 'lay-options_page_manage-webfonts' ) {
			wp_enqueue_style( 'fontmanager-parsley', Setup::$uri.'/assets/css/parsley.css' );
			wp_enqueue_style( 'fontmanager-bootstrap', Setup::$uri.'/assets/bootstrap/css/bootstrap.css' );
			wp_enqueue_style( 'fontmanager-application', Setup::$uri.'/fontmanager/assets/css/fontmanager.style.css', array(), Setup::$ver );
		}
	}

	public function fontmanager_scripts($hook){
		if ( $hook == 'lay-options_page_manage-webfonts' ) {
			wp_enqueue_media();
			// wp_enqueue_script( 'testapp', Setup::$uri."/fontmanager/assets/js/testapp.js", array( 'jquery' ), Setup::$ver, true );
			wp_enqueue_script( 'plugin-bootstrap', Setup::$uri."/assets/bootstrap/js/bootstrap.min.js", array( 'jquery' ), Setup::$ver, true );
			wp_enqueue_script( 'plugin-parsley', Setup::$uri."/assets/js/vendor/parsley.js", array( 'jquery' ), Setup::$ver, true );
			wp_enqueue_script( 'fontmanager-app', Setup::$uri."/fontmanager/assets/js/fontmanager.app.min.js", array( 'jquery', 'marionettev3', 'underscore' ), Setup::$ver, true );
		}
	}

	public function fontmanager_json_settings_api_init() {
		// register_setting( 'admin-fonts-settings', 'fontmanager_json' );
		add_settings_section(
			'manage-webfonts-section',
			'',
			'',
			'manage-webfonts'
		);
	 	add_settings_field(
			'fontmanager_json',
			'Font Manager JSON',
			array($this, 'fontmanager_json_txtarea'),
			'manage-webfonts',
			'manage-webfonts-section'
		);
		register_setting( 'manage-webfonts', 'fontmanager_json' );
	}

	public function fontmanager_json_txtarea(){
		echo
		'<textarea name="fontmanager_json" id="fontmanager_json">'.get_option('fontmanager_json', '').'</textarea>';
	}

	public function font_setup_menu(){
		// add_menu_page( 'Webfonts', 'Webfonts', 'manage_options', 'manage-webfonts', array($this,'fonts_markup'), 'dashicons-editor-bold' );
		add_submenu_page( 'manage-layoptions', 'Webfonts', 'Webfonts', 'manage_options', 'manage-webfonts', array($this, 'fonts_markup') );
	}

	public function fonts_markup(){
		require_once( Setup::$dir.'/fontmanager/markup.php' );
	}

}
$fontmanager = new FontManager();
