<?php
// including plugin.php so i can use "is_plugin_active"
// https://codex.wordpress.org/Function_Reference/is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class Setup{

	public static $uri;
	public static $dir;
	public static $ver;
    public static $browser;
    public static $is_firefox;

	public static $sizes = array('_265', '_512', '_768', '_1024', '_1280', '_1920', '_2560', '_3200', '_3840', '_4096');

	public function __construct(){
		// somehow a get_template_directory_uri() can have a trailing linebreak, causing things like linebreaks in js that leads to issues:
		/*
		
		tinyMCEPreInit.load_ext("http://michelwagenschuetz.fyi
/wp-content/themes/lay/gridder/assets/js/tinymce-plugins/softhyphen", "de");

		*/
		// so i do a preg_replace on linebreaks:
		Setup::$uri = preg_replace('/\s+/', '', trim(get_template_directory_uri()));
		Setup::$dir = get_template_directory();
		$theme = wp_get_theme();
		Setup::$ver = $theme->get('Version');

        Setup::$browser = array_key_exists('HTTP_USER_AGENT', $_SERVER) ? $_SERVER['HTTP_USER_AGENT'] : false;
        Setup::$is_firefox = false;
        if( Setup::$browser != false && is_string(Setup::$browser) ) {
            Setup::$is_firefox = strpos(Setup::$browser, 'Firefox') === false ? false : true;
        }

        add_action( 'init', array($this, 'custom_wp_remove_global_css') );

		add_filter( 'jpeg_quality', array($this, 'set_jpeg_quality') );
		add_filter( 'jpeg_quality', array($this, 'set_jpeg_quality'), 'image_resize' );
		add_filter( 'jpeg_quality', array($this, 'set_jpeg_quality'), 'edit_image' );
		add_filter( 'wp_editor_set_quality', array($this, 'set_jpeg_quality') );

		add_action( 'after_switch_theme', array($this, 'set_permalinks') );
		add_action( 'after_switch_theme', array($this, 'rename_uncategorized') );
		add_action( 'after_switch_theme', array($this, 'redirect_to_dashboard') );
		add_action( 'after_switch_theme', array($this, 'check_if_laygridder_active'), 10, 2 );

		// add_action( 'after_setup_theme', array($this, 'image_sizes') );
		
		add_action( 'admin_menu', array($this, 'add_customizer_to_menu') );

		add_filter( 'image_size_names_choose', array($this, 'frontend_custom_sizes') );

		add_editor_style( Setup::$uri.'/setup/assets/css/tinymce_defaults.css' );

		add_action( 'after_switch_theme', array( $this, 'after_theme_was_activated' ));

		add_filter( 'custom_menu_order' , '__return_true');
		add_filter( 'menu_order', array( $this, 'lay_admin_menu_order'), 10, 1);

		add_action( 'init', array( $this, 'lay_remove_post_type_support') );

		add_filter( 'manage_posts_columns' , array( $this, 'add_fi_column'));
		add_action( 'manage_posts_custom_column' , array( $this, 'fi_custom_column'), 10, 2 );
		add_action( 'wp_before_admin_bar_render', array( $this, 'remove_admin_bar_links'));
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_theme_style'));
		add_action( 'admin_menu', array( $this, 'remove_submenus'), 999 );
		add_action( 'admin_menu', array( $this, 'remove_menus') );
		add_action( 'init', array( $this, 'change_post_object_label') );
		// add_filter( 'post_updated_messages', array( $this, 'change_post_updated_messages' ) );
		add_filter( 'show_admin_bar', '__return_false' );
		add_action( 'admin_menu', array( $this, 'laytheme_edit_admin_menus') );
		add_filter( 'admin_footer_text', array( $this, 'laytheme_admin_footer_text'));

		add_action( 'admin_enqueue_scripts', array( $this, 'lay_admin_enqueue_scripts'));
		add_action( 'admin_footer-options-permalink.php', array( $this, 'show_permalink_notice'));
		// ajax for hiding texteditor notices
		add_action( 'wp_ajax_set_explanation_expand_status_via_ajax', array( $this, 'set_explanation_expand_status_via_ajax') );

		add_action( 'wp_ajax_lay_set_texteditor_nightmode', array( $this, 'lay_set_texteditor_nightmode' ) );
		add_action( 'admin_head', array( $this, 'lay_admin_head' ) );

		add_action( 'wp_dashboard_setup', array( $this, 'lay_dashboard') );
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

		add_action( 'admin_notices', array( $this, 'lay_project_tip') );
		add_action( 'admin_notices', array( $this, 'lay_page_tip') );
		add_action( 'admin_notices', array( $this, 'show_made_with_lay_notice') );
		add_action( 'admin_notices', array( $this, 'show_disable_jetpack_notice') );
		add_action( 'admin_notices', array( $this, 'show_disable_yoast_notice') );
		add_action( 'admin_notices', array( $this, 'show_disable_velvet_blue_plugin_notice') );
		add_action( 'admin_notices', array( $this, 'show_disable_disablerestapi_notice') );
		add_action( 'admin_notices', array( $this, 'show_disable_passwordprotected_notice') );
		add_action( 'admin_notices', array( $this, 'show_enable_visual_editor_notice') );
		add_action( 'admin_notices', array( $this, 'show_how_to_set_frontpage_message' ) );

		add_action( 'after_theme_support', array( $this, 'remove_feed' ) );

		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		add_action( 'init',  array( $this, 'disable_emojis') );

		// add_action( 'admin_notices', array($this, 'update_lay_theme_nag'), 3 );
		// posts per page in overview admin panel
		add_filter( 'edit_posts_per_page',  array($this, 'set_posts_per_page'), 10, 2 );

		add_action( 'admin_enqueue_scripts', array($this, 'register_scripts'), 5 );

		add_filter( 'use_block_editor_for_post_type', array($this, 'disable_block_editor'), 10, 1 );
		add_action( 'wp_print_styles', array($this, 'block_deregister_styles'), 100 );

		add_action( 'wp_default_scripts', array($this, 'remove_jquery_migrate') );

		// https://make.wordpress.org/core/2019/10/09/introducing-handling-of-big-images-in-wordpress-5-3/
		// makes sure images can be larger than 2560px
		add_filter( 'big_image_size_threshold', '__return_false' );

		if( !class_exists('WooCommerce') ){
			add_action('init', array($this, 'remove_standard_texteditor'), 10);
		}
	
		add_filter('tiny_mce_before_init', array($this, 'tinymce_extend_valid_elements'), 10);
		// add_filter('nav_menu_css_class' , array($this, 'special_nav_class') , 10 , 2);

		add_action( 'wp_enqueue_scripts', array( $this, 'remove_blocks_js_and_css'), 200 );
		add_filter( 'protected_title_format', array($this, 'remove_protected_text' ), 10, 2);

        add_action( 'after_setup_theme', array($this, 'lay_after_setup_theme') );
        // using filter so yoast can override the title tag
        add_filter( 'pre_get_document_title', array($this, 'lay_title'), 10 );
        // https://wordpress.stackexchange.com/questions/40701/changing-the-priority-of-a-custom-taxonomys-metabox
        add_filter( 'get_user_option_meta-box-order_post', array($this, 'metabox_order'), 10, 1 );

        add_filter ( 'site_transient_update_themes', array($this, 'theme_check_for_update') );
	}

    // https://docs.kernl.us/#/pages/api/latest-plugin-theme-version
    // https://stackoverflow.com/questions/58232315/making-update-notice-functionality-for-my-themes
    // https://developer.wordpress.org/apis/handbook/transients/
    public static function theme_check_for_update ( $transient ) {
        // Check Theme is active or not.
        if( empty( $transient->checked['lay'] ) )
            return $transient;

        if ( false === ( $data = get_transient( 'lay_new_version' ) ) ) {
            $request = Setup::theme_fetch_data_of_latest_version();

            if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
                return $transient;
            } else {
                $response = wp_remote_retrieve_body( $request );
            }
    
            $data = json_decode( $response );
            set_transient( 'lay_new_version', $data, 12 * HOUR_IN_SECONDS );
            update_option( 'lay_available_version', $data->version );
        }

        if ( version_compare( Setup::$ver, $data->version, '<' ) ) {
            $transient->response['lay'] = (array) $data;
            add_action('admin_notices', 'Setup::theme_update_admin_notice', 3);
        }

        return $transient;
    }

    public static function custom_wp_remove_global_css(){
        wp_dequeue_style( 'global-styles' );
        remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
        remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
        remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
    }

    public static function theme_fetch_data_of_latest_version() {
        $request = wp_safe_remote_get( 'https://kernl.us/api/v1/latest-version/56a0b3327ba9bc01527df76c' );
        return $request;
    }

    public static function theme_update_admin_notice(){
		$msg = sprintf( __('Lay Theme Update Available! <a target="_blank" href="https://laytheme.com/version-history.html">View version %1$s details</a> or <a href="%2$s">update here</a>.'), get_option('lay_available_version'), network_admin_url( 'update-core.php' ) );
		echo "<div class='update-nag'>$msg</div>";
    }

    // put featured image metabox at top
    // todo: test if that works on a fresh install
    function metabox_order( $order ) {
        if( is_array($order) ) {
            $side = explode(',',$order['side']);
            $ix1 = array_search('postimagediv', $side);
            unset($side[$ix1]);
            $side = array_values($side);
            $ix = array_search('submitdiv', $side);
            $ix++;
            array_splice( $side, $ix, 0, 'postimagediv' );
            $side = implode(',', $side);
            $order['side'] = $side;
        }
        error_log(print_r($order, true));
        return $order;
    }

    function lay_after_setup_theme() {
        add_theme_support( 'title-tag' );

        add_theme_support( 'post-thumbnails' );

		update_option('thumbnail_size_w', 0);
		update_option('thumbnail_size_h', 0);
		update_option('thumbnail_crop', 0);

		update_option('medium_size_w', 150);
		update_option('medium_size_h', 150);

		update_option('large_size_w', 0);
		update_option('large_size_h', 0);

		add_image_size( '_4096', 4096, 0, 0 );
		add_image_size( '_3840', 3840, 0, 0 );
		add_image_size( '_3200', 3200, 0, 0 );
		add_image_size( '_2560', 2560, 0, 0 );
		add_image_size( '_1920', 1920, 0, 0 );
		add_image_size( '_1280', 1280, 0, 0 );
		add_image_size( '_1024', 1024, 0, 0 );
		add_image_size( '_768', 768, 0, 0 );
		add_image_size( '_512', 512, 0, 0 );
		add_image_size( '_265', 265, 0, 0 );
    }

    // https://stackoverflow.com/questions/34266520/wp-title-filter-takes-no-effect-on-the-title-tag
    function lay_title() {
        $title = get_bloginfo('name');
        if(!is_front_page()){ 
            $sep = get_option( 'misc_options_title_separator', '—' );

            $page_title = '';
            
            // from: https://github.com/WordPress/WordPress/blob/183165304fa4a7ec5f9350d7b6bccb3e08ff30c3/wp-includes/general-template.php#L1156

            // If it's a 404 page, use a "Page not found" title.
            if ( is_404() ) {
                $page_title = __( 'Page not found' );
        
                // If it's a search, use a dynamic search results title.
            } elseif ( is_search() ) {
                /* translators: %s: Search query. */
                $page_title = sprintf( __( 'Search Results for &#8220;%s&#8221;' ), get_search_query() );
        
                // If on the front page, use the site title.
            } elseif ( is_front_page() ) {
                $page_title = get_bloginfo( 'name', 'display' );
        
                // If on a post type archive, use the post type archive title.
            } elseif ( is_post_type_archive() ) {
                $page_title = post_type_archive_title( '', false );
        
                // If on a taxonomy archive, use the term title.
            } elseif ( is_tax() ) {
                $page_title = single_term_title( '', false );
        
                /*
                * If we're on the blog page that is not the homepage
                * or a single post of any post type, use the post title.
                */
            } elseif ( is_home() || is_singular() ) {
                $page_title = single_post_title( '', false );
        
                // If on a category or tag archive, use the term title.
            } elseif ( is_category() || is_tag() ) {
                $page_title = single_term_title( '', false );
        
                // If on an author archive, use the author's display name.
            } elseif ( is_author() && get_queried_object() ) {
                $author         = get_queried_object();
                $page_title = $author->display_name;
        
                // If it's a date archive, use the date as the title.
            } elseif ( is_year() ) {
                $page_title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
        
            } elseif ( is_month() ) {
                $page_title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
        
            } elseif ( is_day() ) {
                $page_title = get_the_date();
            }

            $title .= ' '.$sep.' '.trim($page_title);
        }

        return $title;
    }

	function remove_protected_text($prepend, $post) {
		return '%s';
	}

	function remove_blocks_js_and_css() {
		wp_dequeue_style('wp-block-library');
		// WooCommerce - you can remove the following if you don't use Woocommerce
		wp_dequeue_style('wc-block-style');
		wp_dequeue_style('wc-blocks-vendors-style');
		wp_dequeue_style('wc-blocks-style'); 
	}

	// function special_nav_class ($classes, $item) {
	// 	if (in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ){
	// 		$classes[] = 'active ';
	// 	}
	// 	return $classes;
	// }

	public static function lay_admin_head(){
		$nightmode = get_option('lay_nightmode', false);
		if( trim($nightmode) == '' ) {
			$nightmode = false;
		}
		if( is_bool($nightmode) ) {
			$nightmode = $nightmode ? 'true' : 'false';
		}

        $laybutton1_textformat = get_theme_mod('laybutton1_textformat', 'Default');
        $laybutton1_textformat_css = FormatsManager::get_textformat_css_for_selector($laybutton1_textformat, 'a.laybutton1, a.laybutton1[data-mce-selected]', false, false, false);

        $laybutton2_textformat = get_theme_mod('laybutton2_textformat', 'Default');
        $laybutton2_textformat_css = FormatsManager::get_textformat_css_for_selector($laybutton2_textformat, 'a.laybutton2, a.laybutton2[data-mce-selected]', false, false, false);

        $laybutton3_textformat = get_theme_mod('laybutton3_textformat', 'Default');
        $laybutton3_textformat_css = FormatsManager::get_textformat_css_for_selector($laybutton3_textformat, 'a.laybutton3, a.laybutton3[data-mce-selected]', false, false, false);

        $bgcolor3 = get_theme_mod('laybutton3_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton3_background_color', '#eeeeee');
        $bgcolor2 = get_theme_mod('laybutton2_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton2_background_color', '#ffffff');
        $bgcolor1 = get_theme_mod('laybutton1_background_transparent', false) == true ? 'transparent' : get_theme_mod('laybutton1_background_color', '#ffffff');


		echo '<script type="text/javascript">
			var lay_nightmode = '.$nightmode.';
            /* buttonstyle for tinymce */
            
            var lay_buttonstyles_for_tinymce = `.laybutton{ display: inline-block; }
            '.$laybutton1_textformat_css.'
            a.laybutton1, a.laybutton1[data-mce-selected]{
                color: '.get_theme_mod('laybutton1_text_color', '#000').';
                border-radius: '.get_theme_mod('laybutton1_borderradius', 0).'px!important;
                background-color: '.$bgcolor1.'!important;
                border: '.get_theme_mod('laybutton1_borderwidth', 1).'px solid '.get_theme_mod('laybutton1_border_color', '#000000').';
                padding-left: '.get_theme_mod('laybutton1_paddingleftright', 15).'px!important;
                padding-right: '.get_theme_mod('laybutton1_paddingleftright', 15).'px!important;
                padding-top: '.get_theme_mod('laybutton1_paddingtop', 5).'px!important;
                padding-bottom: '.get_theme_mod('laybutton1_paddingbottom', 5).'px!important;
                margin-left: '.get_theme_mod('laybutton1_marginleftright', 0).'px!important;
                margin-right: '.get_theme_mod('laybutton1_marginleftright', 0).'px!important;
                margin-top: '.get_theme_mod('laybutton1_margintop', 0).'px!important;
                margin-bottom: '.get_theme_mod('laybutton1_marginbottom', 0).'px!important;
                box-shadow: none!important;
                text-decoration: none!important;
            }
            '.$laybutton2_textformat_css.'
            a.laybutton2, a.laybutton2[data-mce-selected]{
                color: '.get_theme_mod('laybutton2_text_color', '#000').';
                border-radius: '.get_theme_mod('laybutton2_borderradius', 100).'px!important;
                background-color: '.$bgcolor2.'!important;
                border: '.get_theme_mod('laybutton2_borderwidth', 1).'px solid '.get_theme_mod('laybutton2_border_color', '#000000').';
                padding-left: '.get_theme_mod('laybutton2_paddingleftright', 20).'px!important;
                padding-right: '.get_theme_mod('laybutton2_paddingleftright', 20).'px!important;
                padding-top: '.get_theme_mod('laybutton2_paddingtop', 5).'px!important;
                padding-bottom: '.get_theme_mod('laybutton2_paddingbottom', 5).'px!important;
                margin-left: '.get_theme_mod('laybutton2_marginleftright', 0).'px!important;
                margin-right: '.get_theme_mod('laybutton2_marginleftright', 0).'px!important;
                margin-top: '.get_theme_mod('laybutton2_margintop', 0).'px!important;
                margin-bottom: '.get_theme_mod('laybutton2_marginbottom', 0).'px!important;
                box-shadow: none!important;
                text-decoration: none!important;
            }
            '.$laybutton3_textformat_css.'
            a.laybutton3, a.laybutton3[data-mce-selected]{
                color: '.get_theme_mod('laybutton3_text_color', '#000').';
                border-radius: '.get_theme_mod('laybutton3_borderradius', 100).'px!important;
                background-color: '.$bgcolor3.'!important;
                border: '.get_theme_mod('laybutton3_borderwidth', 0).'px solid '.get_theme_mod('laybutton3_border_color', '#000000').';
                padding-left: '.get_theme_mod('laybutton3_paddingleftright', 20).'px!important;
                padding-right: '.get_theme_mod('laybutton3_paddingleftright', 20).'px!important;
                padding-top: '.get_theme_mod('laybutton3_paddingtop', 5).'px!important;
                padding-bottom: '.get_theme_mod('laybutton3_paddingbottom', 5).'px!important;
                margin-left: '.get_theme_mod('laybutton3_marginleftright', 0).'px!important;
                margin-right: '.get_theme_mod('laybutton3_marginleftright', 0).'px!important;
                margin-top: '.get_theme_mod('laybutton3_margintop', 0).'px!important;
                margin-bottom: '.get_theme_mod('laybutton3_marginbottom', 0).'px!important;
                box-shadow: none!important;
                text-decoration: none!important;
            }`;
		</script>';
	}

	public static function lay_set_texteditor_nightmode(){
		$nightmode = $_POST['nightmode'];
		// error_log(print_r($nightmode, true));
		update_option('lay_nightmode', $nightmode);
	}

	// make it possible to have an onclick handler in tinymce
	public static function tinymce_extend_valid_elements($mceInit) {
		// got it from here: https://www.tiny.cloud/docs-3x/reference/configuration/Configuration3x@valid_elements/#defaultruleset
		$mceInit['valid_elements'] = 
		"@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
		."onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
		."onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
		."name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
		."#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
		."src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
		."-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
		."height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
		."height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
		."#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
		."|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
		."-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
		."|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
		."object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
		."|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
		."button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
		."valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
		."input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
		."kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
		."q[cite],samp,select[disabled|multiple|name|size],small,"
		."textarea[cols|rows|disabled|name|readonly],tt,var,big";
		
		return $mceInit;
	} 

	


	public static function remove_standard_texteditor(){
		$post_type = 'page';
		remove_post_type_support( $post_type, 'editor');
		$post_type = 'post';
		remove_post_type_support( $post_type, 'editor');
	}

	public static function after_theme_was_activated(){
		$user_id = get_current_user_id();
		$args = array(
			'ID' => $user_id,
			'admin_color' => 'light'
		);
		wp_update_user( $args );
	}

	//Remove jquery migrate
	public static function remove_jquery_migrate($scripts){
		if (!is_admin() && isset($scripts->registered['jquery'])) {
			$script = $scripts->registered['jquery'];
			
			if ($script->deps) { // Check whether the script has any dependencies
				$script->deps = array_diff($script->deps, array(
					'jquery-migrate'
				));
			}
		}
	}

	public static function disable_block_editor($use_block_editor) {
		return false;
	}

	public static function block_deregister_styles() {
		wp_dequeue_style( 'wp-block-library' );
	}

	public static function check_if_laygridder_active($oldtheme_name, $oldtheme){
		if(is_plugin_active('laygridder/laygridder.php')){
			switch_theme( $oldtheme->stylesheet );
			wp_die('Sorry, but Lay Theme is not compatible with the "LayGridder" Plugin!<br><a href="' . admin_url( 'themes.php' ) . '">&laquo; Return to Themes</a>');
			return false;
		}
	}

	public static function show_disable_yoast_notice(){
		$screen = get_current_screen();
		if(is_plugin_active('wordpress-seo/wp-seo.php') && ($screen->id == 'plugins')){
			echo
				'<div class="updated lay-cyan-border">
					<p><strong>Yoast SEO Plugin Warning</strong><br>For Yoast\'s metatags to work on your Frontpage you need to do this:<br>Set your Frontpage in "Settings" &rarr; "Reading" &rarr; "Your homepage displays".
                    <br>Set both the "Homepage" and "Posts page" to your Frontpage. 
                    <br>This does not actually set Lay Theme\'s Frontpage, but that setting lets Yoast know which page to get the meta tags from.</p>
				</div>';
		}		
	}

	public static function show_how_to_set_frontpage_message(){
		$screen = get_current_screen();
		if($screen->id == 'options-reading'){
			echo
				'<div class="updated lay-cyan-border">
					<p>Please set your homepage/frontpage in "Customize" &rarr; "Frontpage".</p>
				</div>';
		}		
	}

	public static function show_disable_jetpack_notice(){
		$screen = get_current_screen();
		if(is_plugin_active('jetpack/jetpack.php') && $screen->id == 'plugins'){
			echo
				'<div class="updated lay-cyan-border">
					<p><strong>Jetpack Plugin Warning!</strong> Lay Theme can have problems with showing images when you click "+Image" in the Gridder when Jetpack is active.</p>
				</div>';
		}
	}

	public static function show_enable_visual_editor_notice(){
		if(!user_can_richedit()){
			echo
			'<div class="updated lay-cyan-border">
				<p><strong>Visual Editor disabled Warning!</strong> Please go to "Users" &rarr; "Your Profile" and enable Visual Editor. Otherwise you cannot add Texts in the Gridder.</p>
			</div>';
		}
	}

	public static function show_disable_passwordprotected_notice(){
		$screen = get_current_screen();
		if(is_plugin_active('password-protected/password-protected.php') && $screen->id == 'plugins'){
			echo
				'<div class="updated lay-cyan-border">
					<p><strong>Password Protected Plugin Warning!</strong> Lay Theme content might not be loaded with this plugin activated.</p>
				</div>';
		}		
	}

	public static function show_disable_disablerestapi_notice(){
		if(is_plugin_active('disable-json-api/disable-json-api.php')){
			echo
				'<div class="updated lay-cyan-border">
					<p><strong>Disable REST API Plugin Warning!</strong> Lay Theme does not work with this plugin activated.</p>
				</div>';
		}
	}

	public static function show_disable_velvet_blue_plugin_notice(){
		if(is_plugin_active('velvet-blues-update-urls/velvet-blues-update-urls.php')){
			echo
			'<div class="updated lay-cyan-border">
				<p><strong>Velvet Blues Plugin Incompatibility!</strong> When you use Velvet Blues to update your URL, your Lay Theme content will disappear! Please use the plugin "WP Migrate DB".</p>
			</div>';
		}
	}

	public static function register_scripts(){
		wp_register_script( 'backboneradio', Setup::$uri.'/assets/js/vendor/marionettev4/backbone.radio.min.js' );
		wp_register_script( 'marionettev2', Setup::$uri.'/assets/js/vendor/marionettev2/backbone.marionette.min.js' );
		wp_register_script( 'marionettev3', Setup::$uri.'/assets/js/vendor/marionettev3/backbone.marionette.min.js', array('backbone', 'backboneradio', 'underscore') );
		wp_register_script( 'marionettev4', Setup::$uri.'/assets/js/vendor/marionettev4/backbone.marionette.min.js', array('backbone', 'backboneradio', 'underscore') );
	}

	function set_posts_per_page( $per_page, $post_type ) {
		return 999;
	}

	public static function update_lay_theme_nag() {

        // $newVersion = get_option('lay_latest_version_kernl', 0);
		// // $canUpdate = apply_filters( 'tuc_check_now', true );
		// if( $canUpdate && version_compare($newVersion, Setup::$ver, '>') ){

		// 	global $pagenow;
		// 	if ( 'update-core.php' == $pagenow ){
		// 		return;
		// 	}

		// 	if ( current_user_can('update_core') ) {
		// 		$msg = sprintf( __('Lay Theme Update Available! <a target="_blank" href="https://laytheme.com/version-history.html">View version %1$s details</a> or <a href="%2$s">update here</a>.'), $newVersion, network_admin_url( 'update-core.php' ) );
		// 		echo "<div class='update-nag'>$msg</div>";
		// 	}

		// }
	}

	public static function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	public static function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	public static function remove_feed() {
	   remove_theme_support( 'automatic-feed-links' );
	}

	public static function set_jpeg_quality(){
		$quality = get_option( 'misc_options_image_quality', '90' );
		return $quality;
	}

	public static function lay_project_tip(){
		$screen = get_current_screen();
		if ( $screen->id == 'post' ) {
			// update_option('lay-project-tip', '');
			if( get_option('lay-project-tip', '') != "hide" ){
				echo
			    '<div class="updated lay-cyan-border" data-optionname="lay-project-tip">
		        	<p>Tip: Add your Project to a Page using the "+Project Thumbnail" button. Or add it to your Menu here: "Appearance" &#10141; <a href="'.admin_url('nav-menus.php').'">"Menus"</a>.
		        	 <a href="#" class="lay-hide-admin-notice">Don\'t show again</a></p>
		    	</div>';
			}
		}
	}

	public static function lay_page_tip(){
		$screen = get_current_screen();
		if ( $screen->id == 'page' ) {
			// update_option('lay-page-tip', '');
			if( get_option('lay-page-tip', '') != "hide" ){
				echo
			    '<div class="updated lay-cyan-border" data-optionname="lay-page-tip">
		        	<p>Tip: Add your Page to your Menu here: "Appearance" &#10141; <a href="'.admin_url('nav-menus.php').'">"Menus"</a>.
		        	<a href="#" class="lay-hide-admin-notice">Don\'t show again</a></p>
		    	</div>';
		    }
		}
	}

	public static function show_made_with_lay_notice(){
		$screen = get_current_screen();
		if ( $screen->id == 'page' ) {
			// $alien = '<img style="height:1.3em; vertical-align:middle;" src="'.get_template_directory_uri().'/setup/assets/img/alien.png" alt="">';
			if( get_option('lay-affiliate-hint', '') != "hide" ){
				echo
				'<div class="updated lay-cyan-border" data-optionname="lay-affiliate-hint">
					<p>Want to support Lay Theme?👽 Write a little sentence like "made with Lay Theme" on your About Page :)</a></p>
				</div>';
			}
		}
	}

	public static function redirect_to_dashboard(){
		wp_safe_redirect( admin_url( 'index.php' ) );
	}

	// https://codex.wordpress.org/Dashboard_Widgets_API
	// https://codex.wordpress.org/Function_Reference/wp_add_dashboard_widget
	public static function lay_dashboard(){
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8

		wp_add_dashboard_widget(
			'lay_primary_dashboard_widget',         // Widget slug.
			'Welcome to Lay Theme!',         // Title.
			array('Setup', 'lay_primary_dashboard_widget') // Display function.
        );

	}

	public static function lay_primary_dashboard_widget(){
		$customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );

		echo
		'<h3>Video Tutorial:</h3>
		<p>Visit the "Getting Started" page to see a Video Tutorial: <a href="http://laytheme.com/getting-started.html">laytheme.com/getting-started.html</a></p>
		<h3>First Steps:</h3>
		<ul>
			<li>- Create a new Project: <a href="'.admin_url('post-new.php').'">Add new Project</a></li>
			<li>- Add the Project to your Work Category which is the frontpage by default: <a href="'.admin_url('edit-tags.php?action=edit&taxonomy=category&tag_ID=1&post_type=post').'">Edit Work Category Layout</a></li>
			<li>- Edit the "Default" Text Format to change the Text Style of your whole website: <a href="'.admin_url('admin.php?page=manage-textformats').'">Edit Text Formats</a></li>
			<li>- <a href="'.admin_url('post-new.php?post_type=page').'">Add an "About" Page</a></li>
			<li>- Add your Page to your menu: <a href="'.admin_url('nav-menus.php').'">Edit Menus</a></li>
			<li>- Customize your menu appearance, background color, set the frontpage and more: <a href="'.esc_url( $customize_url ).'">Customize</a></li>
		</ul>
		';
	}

	public static function show_permalink_notice(){
		echo
		'<div class="error">
		    <p>Lay Theme needs pretty permalinks. If you change your permalink structure to "Default" your site won\'t work!</p>
		</div>';
	}

	public static function set_explanation_expand_status_via_ajax(){
		$optionname = $_POST['optionname'];
		$value = $_POST['value'];
		if($value == 'expanded' || $value == "collapsed"){
			update_option( $optionname, $value );
		}
		die();
	}

	public function lay_admin_enqueue_scripts(){
		wp_enqueue_script( 'lay-duplicate-save-button', Setup::$uri."/setup/assets/js/duplicate_save_button.js", array( 'jquery' ), Setup::$ver);
		wp_enqueue_script( 'lay-collapse-and-expand-explanations', Setup::$uri."/setup/assets/js/collapse_and_expand_explanations.js", array( 'jquery', 'underscore' ), Setup::$ver);
		wp_enqueue_script( 'lay-hide-admin-notice-tips', Setup::$uri."/setup/assets/js/hide_admin_notice_tips.js", array( 'jquery', 'underscore' ), Setup::$ver);
		wp_localize_script( 'lay-hide-admin-notice-tips', 'setupPassedData', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) ) );
	}

	public static function add_customizer_to_menu(){
		$customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
		add_menu_page( 'Customize', 'Customize', 'edit_theme_options', esc_url( $customize_url ), '', 'dashicons-visibility' );
	}

	public static function laytheme_admin_footer_text($text) {
	  echo $text.' <span style="font-style: italic;">Need help? <a target="_blank" href="http://laytheme.com/documentation.html">Visit Lay Theme Documentation</a>. Lay Theme by <a target="_blank" href="http://100k.studio">100k Studio</a>.</span>';
	}

	public static function laytheme_edit_admin_menus() {
	    global $menu;
	    global $submenu;

	    foreach ($menu as $key => $value) {
	    	if( isset($value[2]) && $value[2] == 'edit.php' ){
	    		$menu[$key][0] = 'Projects'; // Change Posts to Projects
	    		break;
	    	}
	    }
	    $submenu['edit.php'][5][0] = 'All Projects';
	}

	public static function change_post_updated_messages($messages){
		foreach ($messages['post'] as $key => $value) {
			$messages['post'][$key] = str_replace('Post', 'Project', $value);
			$messages['post'][$key] = str_replace('View post', 'View project', $messages['post'][$key]);
		}
		return $messages;
	}

	public static function change_post_object_label() {
		global $wp_post_types;
		$labels = &$wp_post_types['post']->labels;
		$labels->name = 'Projects';
		$labels->singular_name = 'Project';
		$labels->add_new = 'Add Project';
		$labels->add_new_item = 'Add Project';
		$labels->edit_item = 'Edit Project';
		$labels->new_item = 'Project';
		$labels->view_item = 'View Project';
		$labels->search_items = 'Search Projects';
		$labels->not_found = 'No Projects found';
		$labels->not_found_in_trash = 'No Projects found in Trash';
		$labels->featured_image = 'Project Thumbnail';
		$labels->remove_featured_image = 'Remove project thumbnail';
		$labels->set_featured_image = 'Set project thumbnail';
	}

	public static function remove_menus(){
	    remove_menu_page( 'edit-comments.php' );
	}

	public static function remove_submenus(){
	  // remove discussion
	//   remove_submenu_page( 'options-general.php', 'options-discussion.php' );
	}

	public static function add_fi_column($columns) {
	    return array_slice( $columns, 0, 2, true ) + array('fi' => __('Project Thumbnail')) + array_slice( $columns, 2, NULL, true );
	}

	public static function fi_custom_column( $column, $post_id ) {
	    if($column == "fi"){
	      $result = '<a href="'.get_edit_post_link( $post_id ).'">';
	      $result .= get_the_post_thumbnail( $post_id, 'medium' );
	      $result .= '</a>';
	      echo $result;
	    }
	}

	public static function remove_admin_bar_links() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	  	$wp_admin_bar->remove_menu('new-content');
	}

	public static function admin_theme_style() {
	    wp_enqueue_style('lay-admin-style', get_template_directory_uri() . '/setup/assets/css/admin.css', array(), Setup::$ver );
	}

	public static function lay_remove_post_type_support() {
		remove_post_type_support( 'post', 'excerpt' );
		remove_post_type_support( 'post', 'post-formats' );
		remove_post_type_support( 'post', 'revisions' );
		remove_post_type_support( 'post', 'comments' );
		remove_post_type_support( 'post', 'trackbacks' );
		remove_post_type_support( 'post', 'author' );
		// remove_post_type_support( 'post', 'editor' );
		remove_post_type_support( 'post', 'page-attributes' );
		remove_post_type_support( 'post', 'custom-fields' );

		remove_post_type_support( 'page', 'excerpt' );
		remove_post_type_support( 'page', 'post-formats' );
		remove_post_type_support( 'page', 'thumbnail' );
		remove_post_type_support( 'page', 'revisions' );
		remove_post_type_support( 'page', 'comments' );
		remove_post_type_support( 'page', 'trackbacks' );
		remove_post_type_support( 'page', 'author' );
		// remove_post_type_support( 'page', 'editor' );
		remove_post_type_support( 'page', 'page-attributes' );
		remove_post_type_support( 'page', 'custom-fields' );

		// unregister_taxonomy_for_object_type('post_tag', 'post');
	}

	// http://codex.wordpress.org/Plugin_API/Filter_Reference/custom_menu_order
	// https://wordpress.stackexchange.com/a/315621
	public static function lay_admin_menu_order( $menu_order ) {
		// define your new desired menu positions here
		// for example, move 'upload.php' to position #9 and built-in pages to position #1
		$new_positions = array(
			'edit.php?post_type=page' => 3
		);
		// helper function to move an element inside an array
		function move_element(&$array, $a, $b) {
			$out = array_splice($array, $a, 1);
			array_splice($array, $b, 0, $out);
		}
		// traverse through the new positions and move 
		// the items if found in the original menu_positions
		foreach( $new_positions as $value => $new_index ) {
			if( $current_index = array_search( $value, $menu_order ) ) {
			move_element($menu_order, $current_index, $new_index);
			}
		}
		return $menu_order;
	}

	public static function frontend_custom_sizes( $sizes ) {
	    return array_merge( $sizes, array(
	    	'_4096' => __('_4096'),
	    	'_3840' => __('_3840'),
	    	'_3200' => __('_3200'),
	    	'_2560' => __('_2560'),
	        '_1920' => __('_1920'),
	        '_1280' => __('_1280'),
	        '_1024' => __('_1024'),
	        '_768' => __('_768'),
	        '_512' => __('_512'),
	        '_265' => __('_265'),
	    ));
	}

	// http://wordpress.stackexchange.com/questions/31207/how-to-set-permalink-structure-via-functions-php
	public static function set_permalinks() {
	    global $wp_rewrite;
	    $wp_rewrite->set_permalink_structure( '/%postname%/' );
	    flush_rewrite_rules();
	}

	public static function rename_uncategorized(){
		$term = get_term( 1, 'category' );
		$wasRenamed = get_option('lay_default_cat_was_renamed', false);
		if( $wasRenamed == false){
			//rename default uncategorized category to home
			wp_update_term(1, 'category', array(
			  'name' => 'Work',
			  'slug' => 'work'
			));
			update_option('lay_default_cat_was_renamed', 'wasrenamed');
		}

	}

}

$laySetup = new Setup();