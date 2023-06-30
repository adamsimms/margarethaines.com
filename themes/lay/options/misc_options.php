<?php
// http://codex.wordpress.org/Settings_API#Examples
class MiscOptions{

	public static $phoneLayoutActive;
	public static $phone_breakpoint;
	public static $tablet_breakpoint;
	public static $image_alt_tag;
    public static $locked;
    public static $unlock_notice;
    public static $disabled_input;

	public function __construct(){
		add_action( 'admin_menu', array($this, 'misc_options_setup_menu'), 10 );
		add_action( 'admin_init', array($this, 'misc_options_settings_api_init') );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts_for_misc') );
		add_action( 'wp_head', array($this, 'misc_options_css') );
		add_action( 'admin_head', array($this, 'misc_options_css_for_admin'));

        MiscOptions::$locked = true;
        $key = get_option('lay_license_key', '');
        if( $key != "" ) {
            MiscOptions::$locked = false;
        }

        MiscOptions::$disabled_input = MiscOptions::$locked == true ? 'disabled="disabled"' : '';
        MiscOptions::$unlock_notice = '';
        if( MiscOptions::$locked == true ) {
            MiscOptions::$unlock_notice = '<a class="lay-buy-license-key" href="https://laytheme.com/buy-now.html" target="_blank"><span class="dashicons dashicons-lock"></span><span class="dashicons dashicons-unlock"></span>Buy License Key to Unlock</a>';
        }

		MiscOptions::$phoneLayoutActive = get_option('misc_options_extra_gridder_for_phone', 'on');
		if(MiscOptions::$phoneLayoutActive == "on" && !MiscOptions::$locked){
			MiscOptions::$phoneLayoutActive = true;
		}else{
			MiscOptions::$phoneLayoutActive = false;
		}

		MiscOptions::$phone_breakpoint = get_option('lay_breakpoint', 600);
		MiscOptions::$phone_breakpoint = (int)MiscOptions::$phone_breakpoint;
		MiscOptions::$tablet_breakpoint = get_option( 'misc_options_textformats_tablet_breakpoint', 1024 );
		MiscOptions::$tablet_breakpoint = (int)MiscOptions::$tablet_breakpoint;
		MiscOptions::$image_alt_tag = strip_tags(get_option( 'misc_options_image_alt_tag', '' ));

	}

	public static function misc_options_css_for_admin(){
		$screen = get_current_screen();
		if ( LTUtility::is_admin_page_with_a_gridder($screen) ) {
			MiscOptions::horizontal_lines_css();
            MiscOptions::vertical_lines_css();
		}
	}

	public static function misc_options_css(){
		$placeholder_color = get_option( 'misc_options_image_placeholder_color', '' );
		if($placeholder_color != ""){
			echo
			'<!-- image placeholder background color -->
			<style>
				.col.type-img .ph{
				    background-color: '.$placeholder_color.';
				}
			</style>';
		}
		MiscOptions::horizontal_lines_css();
        MiscOptions::vertical_lines_css();
	}

	public static function horizontal_lines_css(){
		// horizontal lines
		$hr_height = get_option( 'misc_options_hr_height', '1' );
		$hr_color = get_option( 'misc_options_hr_color', '#000000' );
		echo
		'<!-- horizontal lines -->
		<style>
			.lay-hr{
				height:'.$hr_height.'px;
				background-color:'.$hr_color.';
			}
		</style>';
	}

    public static function vertical_lines_css(){
		// vertical lines
		$vl_width = get_option( 'misc_options_vl_width', '1' );
		$vl_color = get_option( 'misc_options_vl_color', '#000000' );
		echo
		'<!-- vertical lines -->
		<style>
            .element.type-vl{
                width:'.$vl_width.'px!important;
            }
			.lay-vl{
				width:'.$vl_width.'px;
				background-color:'.$vl_color.';
			}
		</style>';
	}

	public function misc_options_setup_menu(){
		// http://wordpress.stackexchange.com/questions/66498/add-menu-page-with-different-name-for-first-submenu-item
		add_menu_page( 'Lay Options', 'Lay Options', 'manage_options', 'manage-layoptions', '', '', 999 );

        add_submenu_page( 'manage-layoptions', 'Lay Options', 'Lay Options', 'manage_options', 'manage-layoptions', array($this, 'misc_options_markup') );
	}

	public function misc_options_markup(){
		require_once( Setup::$dir.'/options/misc_options_markup.php' );
	}

	public function enqueue_scripts_for_misc($hook){
		if( $hook == 'toplevel_page_manage-layoptions' ){
			wp_enqueue_media();

			wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'misc_options-colorpicker_controller', Setup::$uri.'/options/assets/js/misc_colorpicker_controller.js', array( 'wp-color-picker' ), Setup::$ver, true );

			wp_enqueue_script( 'misc_options-image_upload', Setup::$uri.'/options/assets/js/image_upload.js', array(), Setup::$ver );
			wp_enqueue_script( 'misc_options-settings_showhide', Setup::$uri.'/options/assets/js/misc_options_showhide_settings.js', array(), Setup::$ver );
		}
	}

	public function misc_options_settings_api_init(){
	 	add_settings_section(
			'extra_features_section',
			'Extra Features',
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-extra-features"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
		);


        add_settings_section(
			'transition_section',
			'Transitions when Navigating',
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-transition"></div>',
                'after_section'  => '<p>Transitions will not work if: WooCommerce is enabled, Shortcode is on a page or footer, "Disable Ajax / Compatibility Mode" is active<br/>or if you created a link by coding it yourself and it doesn\'t contain the data-* attributes.</p>',
                'section_class'  => '',
            )
		);

	 	add_settings_section(
			'textformats_settings_section',
			'Textformats Settings',
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-textformats"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
		);

		add_settings_section(
			'lazyloading_section',
			'Lazy Loading',
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-lazyloading"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
		);

 	 	add_settings_section(
 			'images_section',
 			'Images',
 			'',
 			'manage-miscoptions',
             array(
                 'before_section' => '<div id="lay-images"></div>',
                 'after_section'  => '',
                 'section_class'  => '',
             )
 		);

	 	add_settings_section(
			'appearance_section',
			'Appearance',
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-appearance"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
		);

		// yoast
		$yoast_message = '';
		if ( is_plugin_active('wordpress-seo/wp-seo.php') ) {
			$yoast_message = 
            '<div class="lay-infobox lay-cyan-border">
                <p>
                    <strong>Yoast SEO Plugin Warning</strong><br>
                    Because you have Yoast activated, none of these Meta Tags will be used. Instead, Yoast\'s Meta Tags will be used.
                </p>
                <p>
                    For Yoast\'s metatags to work on your Frontpage you need to do this:<br/>
                    Set your Frontpage in "Settings" → "Reading" → "Your homepage displays".<br/>
                    Set both the "Homepage" and "Posts page" to your Frontpage.<br/>
                    This does not actually set Lay Theme\'s Frontpage, but that setting lets Yoast know which page to get the meta tags from.
                </p>
            </div>';
		}
	 	add_settings_section(
			'meta_section',
			'Meta Tags '.$yoast_message,
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-meta"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
		);

	 	add_settings_section(
			'hr_section',
			'Horizontal Lines',
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-horizontal-lines"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
		);

        add_settings_section(
            'vl_section',
            'Vertical Lines',
            '',
            'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-vertical-lines"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
        );

	 	add_settings_section(
			'other_section',
			'Other',
			'',
			'manage-miscoptions',
            array(
                'before_section' => '<div id="lay-other"></div>',
                'after_section'  => '',
                'section_class'  => '',
            )
		);

		// extra features
		add_settings_field(
			'misc_options_menu_amount',
			'Menu Amount',
			array($this, 'misc_setting_menu_amount'),
			'manage-miscoptions',
			'extra_features_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_menu_amount' );

 	 	add_settings_field(
 			'misc_options_extra_gridder_for_phone',
 			'Activate Custom Phone Layouts',
 			array($this, 'misc_setting_extra_gridder_for_phone'),
 			'manage-miscoptions',
 			'extra_features_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_extra_gridder_for_phone' );

 	 	add_settings_field(
			'misc_options_element_transition_on_scroll',
			'Activate on scroll element transitions',
			array($this, 'misc_setting_element_transition_on_scroll'),
			'manage-miscoptions',
			'extra_features_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_element_transition_on_scroll' );

		$news_feature = true;
		if( $news_feature == true ) {
			add_settings_field(
				'misc_options_activate_news_feature',
				'Activate News Feature',
				array($this, 'misc_setting_activate_news_feature'),
				'manage-miscoptions',
				'extra_features_section'
			);
			register_setting( 'manage-miscoptions', 'misc_options_activate_news_feature' );
	
			add_settings_field(
				'misc_options_news_feature_name',
				'News Feature Name',
				array($this, 'misc_setting_news_feature_name'),
				'manage-miscoptions',
				'extra_features_section'
			);
			register_setting( 'manage-miscoptions', 'misc_options_news_feature_name' );
	
			add_settings_field(
				'misc_options_news_feature_slug',
				'News Feature Slug',
				array($this, 'misc_setting_news_feature_slug'),
				'manage-miscoptions',
				'extra_features_section'
			);
			register_setting( 'manage-miscoptions', 'misc_options_news_feature_slug' );	
		}

        add_settings_field(
            'misc_options_cover',
            'Activate Cover Feature',
            array($this, 'misc_setting_cover'),
            'manage-miscoptions',
            'extra_features_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_cover' );

        add_settings_field(
            'misc_options_activate_project_description',
            'Activate Project Descriptions for Thumbnails',
            array($this, 'misc_setting_activate_project_description'),
            'manage-miscoptions',
            'extra_features_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_activate_project_description' );

        add_settings_field(
            'misc_options_intro',
            'Activate Intro Feature',
            array($this, 'misc_setting_intro'),
            'manage-miscoptions',
            'extra_features_section'
        );
         register_setting( 'manage-miscoptions', 'misc_options_intro' );

         add_settings_field(
            'misc_options_simple_parallax',
            'Activate Simple Parallax',
            array($this, 'misc_setting_simple_parallax'),
            'manage-miscoptions',
            'extra_features_section'
        );
       register_setting( 'manage-miscoptions', 'misc_options_simple_parallax' );

 	 	add_settings_field(
 			'misc_options_show_project_arrows',
 			'Show arrows in projects for navigation (Project Arrows)',
 			array($this, 'misc_setting_show_project_arrows'),
 			'manage-miscoptions',
 			'extra_features_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_show_project_arrows' );
        
        add_settings_field(
            'misc_options_thumbnail_mouseover_image',
            'Activate Mouseover Image for Thumbnails',
            array($this, 'misc_setting_thumbnail_mouseover_image'),
            'manage-miscoptions',
            'extra_features_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_thumbnail_mouseover_image' );

        add_settings_field(
            'misc_options_thumbnail_video',
            'Activate Video for Thumbnails',
            array($this, 'misc_setting_thumbnail_video'),
            'manage-miscoptions',
            'extra_features_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_thumbnail_video' );

 	 	add_settings_field(
 			'misc_options_prevnext_navigate_through',
 			'Next & previous project links navigate through:',
 			array($this, 'misc_setting_prevnext_navigate_through'),
 			'manage-miscoptions',
 			'extra_features_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_prevnext_navigate_through' );

 	 	// textformats settings section
 	 	add_settings_field(
 			'misc_options_textformats_for_tablet',
 			'Add "Tablet" settings to Textformats',
 			array($this, 'textformats_for_tablet_setting'),
 			'manage-miscoptions',
 			'textformats_settings_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_textformats_for_tablet' );

 	 	add_settings_field(
 			'misc_options_textformats_tablet_breakpoint',
 			'Tablet Breakpoint for Textformats',
 			array($this, 'textformats_tablet_breakpoint_setting'),
 			'manage-miscoptions',
 			'textformats_settings_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_textformats_tablet_breakpoint' );

		// lazy loading section
		add_settings_field(
			'misc_options_image_loading',
			'Use Lazy Loading',
			array($this, 'misc_setting_image_loading'),
			'manage-miscoptions',
			'lazyloading_section'
		);
		 register_setting( 'manage-miscoptions', 'misc_options_image_loading' );

 	 	// images section
 	 	add_settings_field(
 			'misc_options_image_placeholder_color',
 			'Image Placeholder Background Color',
 			array($this, 'misc_setting_image_placeholder_color'),
 			'manage-miscoptions',
 			'images_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_image_placeholder_color' );

 	 	add_settings_field(
 			'misc_options_image_quality',
 			'Image Quality (.jpeg)',
 			array($this, 'misc_setting_image_quality'),
 			'manage-miscoptions',
 			'images_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_image_quality' );

 	 	add_settings_field(
 			'misc_options_showoriginalimages',
 			'Never show resized versions of your images',
 			array($this, 'misc_setting_showoriginalimages'),
 			'manage-miscoptions',
 			'images_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_showoriginalimages' );


        // transition section
        add_settings_field(
            'misc_options_use_revealing_transition_on_first_visit',
            'Use "Revealing Transition" when first visiting website or hard reload',
            array($this, 'misc_setting_use_revealing_transition_on_first_visit'),
            'manage-miscoptions',
            'transition_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_use_revealing_transition_on_first_visit' );

        add_settings_field(
            'misc_options_navigation_transition_in',
            'Revealing Transition',
            array($this, 'misc_setting_navigation_transition_in'),
            'manage-miscoptions',
            'transition_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_in' );

        add_settings_field(
            'misc_options_navigation_transition_in_duration',
            'Revealing Transition Duration',
            array($this, 'misc_setting_navigation_transition_in_duration'),
            'manage-miscoptions',
            'transition_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_in_duration' );
        
        add_settings_field(
            'misc_options_navigation_transition_in_easing',
            'Revealing Transition Easing',
            array($this, 'misc_setting_navigation_transition_in_easing'),
            'manage-miscoptions',
            'transition_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_in_easing' );

       add_settings_field(
           'misc_options_navigation_transition_out',
           'Hiding Transition',
           array($this, 'misc_setting_navigation_transition_out'),
           'manage-miscoptions',
           'transition_section'
       );
       register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_out' );

        add_settings_field(
            'misc_options_navigation_transition_out_duration',
            'Hiding Transition Duration',
            array($this, 'misc_setting_navigation_transition_out_duration'),
            'manage-miscoptions',
            'transition_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_out_duration' );

       add_settings_field(
        'misc_options_navigation_transition_out_easing',
        'Hiding Transition Easing',
        array($this, 'misc_setting_navigation_transition_out_easing'),
        'manage-miscoptions',
        'transition_section'
    );
    register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_out_easing' );

    add_settings_field(
        'misc_options_navigation_transition_y_translate_desktop',
        'Up/Down Desktop',
        array($this, 'misc_setting_navigation_transition_y_translate_desktop'),
        'manage-miscoptions',
        'transition_section'
    );
    register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_y_translate_desktop' );

    add_settings_field(
        'misc_options_navigation_transition_y_translate_phone',
        'Up/Down Phone',
        array($this, 'misc_setting_navigation_transition_y_translate_phone'),
        'manage-miscoptions',
        'transition_section'
    );
    register_setting( 'manage-miscoptions', 'misc_options_navigation_transition_y_translate_phone' );

 	 	// appearance section
 	 	add_settings_field(
 			'lay_breakpoint',
 			'Phone Breakpoint',
 			array($this, 'misc_setting_lay_breakpoint'),
 			'manage-miscoptions',
 			'appearance_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'lay_breakpoint' );

		add_settings_field(
			'lay_tablet_breakpoint',
			'Tablet Breakpoint',
			array($this, 'misc_setting_lay_tablet_breakpoint'),
			'manage-miscoptions',
			'appearance_section'
		);
		register_setting( 'manage-miscoptions', 'lay_tablet_breakpoint' );

 	 	add_settings_field(
 			'misc_options_max_width',
 			'Max width of content',
 			array($this, 'misc_setting_max_width'),
 			'manage-miscoptions',
 			'appearance_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_max_width' );

 	 	add_settings_field(
 			'misc_options_max_width_apply_to_logo_and_nav',
 			'Apply max width of content to logo and menu',
 			array($this, 'misc_setting_max_width_apply_to_logo_and_nav'),
 			'manage-miscoptions',
 			'appearance_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_max_width_apply_to_logo_and_nav' );

 	 	add_settings_field(
 			'misc_options_html5video_playicon',
 			'HTML5 Video Play Icon',
 			array($this, 'misc_setting_html5video_playicon'),
 			'manage-miscoptions',
 			'appearance_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_html5video_playicon' );

 	 	// meta section
 	 	add_settings_field(
 			'misc_options_website_description',
 			'Website Description',
 			array($this, 'misc_setting_website_description'),
 			'manage-miscoptions',
 			'meta_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_website_description' );

 	 	add_settings_field(
 			'misc_options_fbimage',
 			'Facebook/Twitter Share Image',
 			array($this, 'misc_setting_fbimage'),
 			'manage-miscoptions',
 			'meta_section'
 		);
		register_setting( 'manage-miscoptions', 'misc_options_fbimage' );
		  
		add_settings_field(
			'misc_options_image_alt_tag',
			'Add to Image Alt Tag',
			array($this, 'misc_setting_image_alt_tag'),
			'manage-miscoptions',
			'meta_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_image_alt_tag' );

 	 	// hr section
 	 	add_settings_field(
 			'misc_options_hr_color',
 			'Line Color',
 			array($this, 'misc_setting_hr_color'),
 			'manage-miscoptions',
 			'hr_section'
 		);
 	 	register_setting( 'manage-miscoptions', 'misc_options_hr_color' );

 	 	add_settings_field(
 			'misc_options_hr_height',
 			'Line Strokewidth',
 			array($this, 'misc_setting_hr_height'),
 			'manage-miscoptions',
 			'hr_section'
 		);
		register_setting( 'manage-miscoptions', 'misc_options_hr_height' );

        // vl section
        add_settings_field(
            'misc_options_vl_color',
            'Line Color',
            array($this, 'misc_setting_vl_color'),
            'manage-miscoptions',
            'vl_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_vl_color' );

        add_settings_field(
            'misc_options_vl_width',
            'Line Strokewidth',
            array($this, 'misc_setting_vl_width'),
            'manage-miscoptions',
            'vl_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_vl_width' );
		  
		// other
		add_settings_field(
			'misc_options_title_separator',
			'Title Separator',
			array($this, 'misc_setting_title_separator'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_title_separator' );

		add_settings_field(
			'misc_options_disable_ajax',
			'Disable Ajax / Compatibility Mode',
			array($this, 'misc_setting_disable_ajax'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_disable_ajax' );

		add_settings_field(
			'misc_options_anchorscroll_offset_desktop',
			'Anchor-/Expandrow Scroll Space Top for Desktop',
			array($this, 'misc_setting_anchorscroll_offset_desktop'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_anchorscroll_offset_desktop' );

		add_settings_field(
			'misc_options_anchorscroll_offset_phone',
			'Anchor-/Expandrow Scroll Space Top for Phone',
			array($this, 'misc_setting_anchorscroll_offset_phone'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_anchorscroll_offset_phone' );

		add_settings_field(
			'misc_options_show_password_protected_posts_in_thumbnailgrid',
			'Show Password Protected Projects in Thumbnailgrid',
			array($this, 'misc_setting_show_password_protected_posts_in_thumbnailgrid'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_show_password_protected_posts_in_thumbnailgrid' );

        add_settings_field(
			'misc_options_hide_current_project_from_thumbnailgrid',
			'Hide current Project from Thumbnailgrid',
			array($this, 'misc_setting_hide_current_project_from_thumbnailgrid'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_hide_current_project_from_thumbnailgrid' );

        add_settings_field(
            'misc_options_never_change_scrolling_position',
            'Never change scrolling position when navigating',
            array($this, 'misc_setting_never_change_scrolling_position'),
            'manage-miscoptions',
            'other_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_never_change_scrolling_position' );

        add_settings_field(
            'misc_options_swap_webfonts',
            'Enable "font-display: swap;"',
            array($this, 'misc_setting_swap_webfonts'),
            'manage-miscoptions',
            'other_section'
        );
        register_setting( 'manage-miscoptions', 'misc_options_swap_webfonts' );

        add_settings_field(
			'misc_options_enable_video_lazyloading_for_firefox',
			'Enable HTML5 Video Lazyloading for Firefox',
			array($this, 'misc_setting_enable_video_lazyloading_for_firefox'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_enable_video_lazyloading_for_firefox' );

        add_settings_field(
			'misc_options_enable_frame_overflows_for_apl',
			'Enable Frame Overflows for automatically generated phone layouts',
			array($this, 'misc_setting_enable_frame_overflows_for_apl'),
			'manage-miscoptions',
			'other_section'
		);
		register_setting( 'manage-miscoptions', 'misc_options_enable_frame_overflows_for_apl' );



	}

    // UNLOCKABLE
    public static function misc_setting_news_feature_name(){
        $val = get_option( 'misc_options_news_feature_name', 'News' );
        if( MiscOptions::$locked ){
            $val = 'News';
        }
        echo '<input '.MiscOptions::$disabled_input.' type="text" name="misc_options_news_feature_name" id="misc_options_news_feature_name" value="'.$val.'">'.MiscOptions::$unlock_notice.'<br>
        Default is "News"';
    }

    public static function misc_setting_news_feature_slug(){
        $val = get_option( 'misc_options_news_feature_slug', 'news' );
        if( MiscOptions::$locked ){
            $val = 'news';
        }
        echo '<input '.MiscOptions::$disabled_input.' type="text" name="misc_options_news_feature_slug" id="misc_options_news_feature_slug" value="'.$val.'">'.MiscOptions::$unlock_notice.'<br>
        Default is "news"';
    }

    public function misc_setting_element_transition_on_scroll(){
        $val = get_option('misc_options_element_transition_on_scroll', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_element_transition_on_scroll" id="misc_options_element_transition_on_scroll" '.$checked.'>
        <a class="lay-options-doc-link" href="https://laytheme.com/documentation/element-transitions-on-scroll.html" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_element_transition_on_scroll">Element will animate in when you scroll to it.</label>';
    }

    public function misc_setting_extra_gridder_for_phone(){
        $val = get_option('misc_options_extra_gridder_for_phone', 'on');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_extra_gridder_for_phone" id="misc_options_extra_gridder_for_phone" '.$checked.'>
        <a class="lay-options-doc-link" href="https://laytheme.com/documentation/custom-phone-layouts.html" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_extra_gridder_for_phone">In the Gridder you will have new buttons to switch between the desktop and phone layout.</label>';
    }

    public function misc_setting_menu_amount(){
        $val = intval(get_option('misc_options_menu_amount', 1));
        if( MiscOptions::$locked || $val == 0 ) {
            $val = 1;
        }
        $selected1 = $val == 1 ? 'selected' : '';
        $selected2 = $val == 2 ? 'selected' : '';
        $selected3 = $val == 3 ? 'selected' : '';
        $selected4 = $val == 4 ? 'selected' : '';

        echo 
        '<select '.MiscOptions::$disabled_input.' name="misc_options_menu_amount">
            <option value="1" '.$selected1.'>1</option> 
            <option value="2" '.$selected2.'>2</option>
            <option value="3" '.$selected3.'>3</option>
            <option value="4" '.$selected4.'>4</option>
            </select> <a class="lay-options-doc-link" href="https://laytheme.com/documentation/menus.html#multiple-menus" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a> '.MiscOptions::$unlock_notice;
    }

    public function misc_setting_thumbnail_video(){
        $val = get_option('misc_options_thumbnail_video', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_thumbnail_video" id="misc_options_thumbnail_video" '.$checked.'>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_thumbnail_video">When editing a project you can insert a video as a project thumbnail.</label>';
    }

    public function misc_setting_thumbnail_mouseover_image(){
        $val = get_option('misc_options_thumbnail_mouseover_image', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_thumbnail_mouseover_image" id="misc_options_thumbnail_mouseover_image" '.$checked.'>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_thumbnail_mouseover_image">When editing a project you can insert another image that will be shown on mouseover.</label>';
    }

    public function misc_setting_activate_project_description(){
        $val = get_option('misc_options_activate_project_description', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_activate_project_description" id="misc_options_activate_project_description" '.$checked.'>
        <a class="lay-options-doc-link" href="https://laytheme.com/documentation/project-description.html" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_activate_project_description">A new description textfield will appear above the Gridder when you edit projects.<br>Project descriptions will show up underneath a project thumbnail.</label>';
    }

    public function misc_setting_simple_parallax(){
        $val = get_option('misc_options_simple_parallax', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        https://laytheme.com/documentation/simple-parallax.html
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_simple_parallax" id="misc_options_simple_parallax" '.$checked.'> <a class="lay-options-doc-link" href="https://laytheme.com/documentation/simple-parallax.html" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.' <br><label for="misc_options_simple_parallax">Right click on an element in the Gridder and define the "y-parallax" value to change the speed of an element while scrolling.</label>';
    }

    public function misc_setting_intro(){
        $val = get_option('misc_options_intro', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_intro" id="misc_options_intro" '.$checked.'>
        <a class="lay-options-doc-link" href="https://laytheme.com/documentation/intro-image-or-video.html" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_intro">When activated, find options in "Customizer" &rarr; "Intro".</label>';
    }

    public function misc_setting_cover(){
        $val = get_option('misc_options_cover', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_cover" id="misc_options_cover" '.$checked.'>
        <a class="lay-options-doc-link" href="https://laytheme.com/documentation/covers.html" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_cover">When activated, find options for Covers in "Lay Options" &rarr; "Cover Options".</label>';
    }

    public function misc_setting_activate_news_feature(){
        $val = get_option('misc_options_activate_news_feature', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_activate_news_feature" id="misc_options_activate_news_feature" '.$checked.'>
        <a class="lay-options-doc-link" href="https://laytheme.com/documentation/newssection.html" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_activate_news_feature">Use the News feature to add a News section to your website.<br>Create News posts in "News", then add a News Element to a page in the Gridder with "+More" &rarr; "+News Element".</label>';
    }

    public function misc_setting_show_project_arrows(){
        $val = get_option('misc_options_show_project_arrows', '');
        $checked = "";
        if( $val == "on" && !MiscOptions::$locked ){
            $checked = "checked";
        }
        echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_show_project_arrows" id="misc_options_show_project_arrows" '.$checked.'>
        <a class="lay-options-doc-link" href="https://laytheme.com/documentation/navigation-between-projects.html#project-arrows" title="Documentation on laytheme.com" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>'.MiscOptions::$unlock_notice.'
        <br><label for="misc_options_show_project_arrows">In projects on the left and right there will be clickable arrows to go to the previous/next project.<br>In "Customize" when you navigate inside a project you can style the arrows in the "Project Arrows" panel.</label>';
    }
    // # UNLOCKABLE

	public static function misc_setting_anchorscroll_offset_desktop(){
		$val = get_option( 'misc_options_anchorscroll_offset_desktop', 0 );
		echo
		'<input type="number" step="1" value="'.$val.'" name="misc_options_anchorscroll_offset_desktop" id="misc_options_anchorscroll_offset_desktop"> px
		<br><label for="misc_options_anchorscroll_offset_desktop">You click on an anchor that is linked to <code>#hey</code>.
		The page scrolls to an element with <code>id="hey"</code>.<br>
		The offset here is the space between your top browser edge and that div.</label>';
	}

	public static function misc_setting_anchorscroll_offset_phone(){
		$val = get_option( 'misc_options_anchorscroll_offset_phone', 0 );
		echo
		'<input type="number" step="1" value="'.$val.'" name="misc_options_anchorscroll_offset_phone" id="misc_options_anchorscroll_offset_phone"> px
		<br><label for="misc_options_anchorscroll_offset_phone">Same as above but just for when you\'re on the phone version.</label>';
	}

	public static function misc_setting_disable_ajax(){

		if( class_exists( 'WooCommerce' ) ) {
			$checked = "checked";

			echo '<input disabled type="checkbox" name="misc_options_disable_ajax" id="misc_options_disable_ajax" '.$checked.'><br>
			<label for="misc_options_disable_ajax">When using WooCommerce, this setting will always be activated.<br>
			When activated there will be no page transitions. And when going to the frontpage the intro will always re-appear.
			</label>';
		} else {
			$val = get_option( 'misc_options_disable_ajax', "" );
			$checked = "";
			if( $val == "on" ){
				$checked = "checked";
			}
			echo '<input type="checkbox" name="misc_options_disable_ajax" id="misc_options_disable_ajax" '.$checked.'><br>
			<label for="misc_options_disable_ajax">Activate this setting if you have issues with plugin compatibility.<br>
			When activated there will be no page transitions. And when going to the frontpage the intro will always re-appear.
			</label>';
		}

	}

	public static function misc_setting_title_separator(){
		$val = get_option( 'misc_options_title_separator', '—' );
        $yoast_message = '';
        if ( is_plugin_active('wordpress-seo/wp-seo.php') ) {
			$yoast_message = 
            '<div class="lay-infobox lay-cyan-border">
                <p>
                    <strong>Yoast SEO Plugin Warning</strong><br>Because Yoast SEO is activated, also set the separator in "Yoast SEO" &rarr; "Search Appearance".
                </p>
            </div>';
		}
		echo $yoast_message.'<input type="text" name="misc_options_title_separator" id="misc_options_title_separator" value="'.$val.'"><br>
		Separator for the page titles that are shown in your browser tab. Example: "My Website – My Page". Default is "–".';
	}

	public static function misc_setting_hr_height(){
		$val = get_option( 'misc_options_hr_height', '1' );
		echo '<input type="number" min="1" step="1" name="misc_options_hr_height" id="misc_options_hr_height" value="'.$val.'"/> px';
	}

	public static function misc_setting_hr_color(){
		$val = get_option( 'misc_options_hr_color', '#000000' );
		echo '<input type="text" name="misc_options_hr_color" id="misc_options_hr_color" value="'.$val.'" class="lay-hr-color-picker"><br>
			Find out how to have a different line color for different pages with <a href="https://laytheme.com/documentation/custom-css-styling.html#css-based-on-current-page" target="_blank">CSS based on current page</a>.<br>
			<code>body.slug-yourslug .lay-hr{ background-color: #f0f; }</code>';
	}

    public static function misc_setting_vl_width(){
		$val = get_option( 'misc_options_vl_width', '1' );
		echo '<input type="number" min="1" step="1" name="misc_options_vl_width" id="misc_options_vl_width" value="'.$val.'"/> px';
	}

	public static function misc_setting_vl_color(){
		$val = get_option( 'misc_options_vl_color', '#000000' );
		echo '<input type="text" name="misc_options_vl_color" id="misc_options_vl_color" value="'.$val.'" class="lay-vl-color-picker"><br>
			Find out how to have a different line color for different pages with <a href="https://laytheme.com/documentation/custom-css-styling.html#css-based-on-current-page" target="_blank">CSS based on current page</a>.<br>
			<code>body.slug-yourslug .lay-vl{ background-color: #f0f; }</code>';
	}

	public static function textformats_for_tablet_setting(){
		$val = get_option( 'misc_options_textformats_for_tablet', "on" );
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_textformats_for_tablet" id="misc_options_textformats_for_tablet" '.$checked.'>';
	}

	public static function textformats_tablet_breakpoint_setting(){
		$breakpoint = get_option( 'misc_options_textformats_tablet_breakpoint', 1024 );
		echo
		'<input type="number" min="0" step="1" value="'.$breakpoint.'" name="misc_options_textformats_tablet_breakpoint" id="misc_options_textformats_tablet_breakpoint"> px
		<br><label for="misc_options_textformats_tablet_breakpoint">Breakpoint between desktop and tablet version. Needs to be bigger than "Phone Breakpoint".</label>';
	}

    public function misc_setting_hide_current_project_from_thumbnailgrid(){
        $val = get_option('misc_options_hide_current_project_from_thumbnailgrid', 'on');
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_hide_current_project_from_thumbnailgrid" id="misc_options_hide_current_project_from_thumbnailgrid" '.$checked.'>';
    }

	public function misc_setting_show_password_protected_posts_in_thumbnailgrid(){
		$val = get_option('misc_options_show_password_protected_posts_in_thumbnailgrid', 'on');
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_show_password_protected_posts_in_thumbnailgrid" id="misc_options_show_password_protected_posts_in_thumbnailgrid" '.$checked.'>';
	}

	public function misc_setting_showoriginalimages(){
		$val = get_option('misc_options_showoriginalimages', '');
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_showoriginalimages" id="misc_options_showoriginalimages" '.$checked.'><label for="misc_options_showoriginalimages">Normally, when appropriate, Lay Theme uses automatically generated smaller image sizes to speed up loading.<br>
			This setting does not apply to the phone version. Activate this if your images seem blurry.</label>';
	}

	public function misc_setting_max_width_apply_to_logo_and_nav(){
		$val = get_option('misc_options_max_width_apply_to_logo_and_nav', '');
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_max_width_apply_to_logo_and_nav" id="misc_options_max_width_apply_to_logo_and_nav" '.$checked.'><br>
		<label for="misc_options_max_width_apply_to_logo_and_nav">Logo and menu will only align to grids that use the same "Frame Left, Right" value as in "Lay Options" &rarr; "Gridder Defaults".</label>';
	}

	public function misc_setting_prevnext_navigate_through(){
		$val = get_option('misc_options_prevnext_navigate_through', 'all_projects');

		$checked1 = $val == 'same_category' ? 'checked' : '';
		$checked2 = $val == 'all_projects' ? 'checked' : '';

		echo '<input type="radio" name="misc_options_prevnext_navigate_through" id="same_category" value="same_category" '.$checked1.'><label for="same_category">Projects of same Category</label><br>';
		echo '<input type="radio" name="misc_options_prevnext_navigate_through" id="all_projects" value="all_projects" '.$checked2.'><label for="all_projects">All Projects</label>';
	}

	public function misc_setting_image_loading(){
        /* 
		i changed the misc option inputs from radio to checkbox
		this used to be either "instant_load" or "lazy_load"
		but now it can be '' or 'on'
		'on' is when lazyload is turned on, '' is when lazyload is off
		i need to make sure in my code the values 'instant_load' and 'lazy_load' are handled too
		*/
		$val = get_option('misc_options_image_loading', 'on');

		$checked = "";
		if( $val == "on" || $val == "lazy_load" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_image_loading" id="misc_options_image_loading" '.$checked.'>
		<br><label for="misc_options_image_loading">When lazy loading is on, images and HTML5 videos will be loaded when you scroll to them.<br>
		Recommended for when you have many images and HTML5 videos on a page.</label>';
	}

	public function misc_setting_image_placeholder_color(){
		$val = get_option( 'misc_options_image_placeholder_color', '' );
		echo '<input type="text" name="misc_options_image_placeholder_color" id="misc_options_image_placeholder_color" value="'.$val.'" class="image-placeholder-color-picker"><br><label>When an image has not loaded yet, a placeholder rectangle of this color will be visible.</label>';
	}

	public function misc_setting_lay_breakpoint(){
		$breakpoint = get_option('lay_breakpoint', 600);
		echo '<input type="number" min="0" step="1" name="lay_breakpoint" id="lay_breakpoint" value="'.$breakpoint.'"> <label for="lay_breakpoint"> px (0 = disable phone version)<br>
		Below this browser-width the phone version is shown.</label>';
	}

	public function misc_setting_lay_tablet_breakpoint(){
		$breakpoint = get_option('lay_tablet_breakpoint', 1024);
		echo '<input type="number" min="0" step="1" name="lay_tablet_breakpoint" id="lay_tablet_breakpoint" value="'.$breakpoint.'"> <label for="lay_breakpoint"> px<br>
		Must be bigger than phone breakpoint. Important for elements like "Thumbnailgrid", "Elementgrid" and "Project Index".</label>';		
	}

	public function misc_setting_max_width(){
		$maxwidth = get_option( 'misc_options_max_width', '0' );
		echo '<input type="number" min="0" step="1" name="misc_options_max_width" id="misc_options_max_width" value="'.$maxwidth.'"> <label for="misc_options_max_width"> px (0 = off)</label>';
	}

	public function misc_setting_image_quality(){
		$quality = get_option( 'misc_options_image_quality', '90' );
		echo '<input type="number" min="0" max="100" step="1" name="misc_options_image_quality" id="misc_options_image_quality" value="'.$quality.'"> <label for="misc_options_image_quality"> % <br>When you change the quality you need to regenerate all images with a plugin like <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a>.<br>In some cases the original uploaded image will be shown on your website. The original image is not affected by the quality set here.</label>';
	}

    public function misc_setting_enable_frame_overflows_for_apl(){
        $val = get_option('misc_options_enable_frame_overflows_for_apl', 'on');

		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_enable_frame_overflows_for_apl" id="misc_options_enable_frame_overflows_for_apl" '.$checked.'>
		<br><label for="misc_options_enable_frame_overflows_for_apl">If enabled, stretch element to edge on phone layouts too. <a href="https://laytheme.com/documentation/gridder-elements.html#full-width-element">Like here</a></label>';
    }

    public function misc_setting_enable_video_lazyloading_for_firefox(){
        $val = get_option('misc_options_enable_video_lazyloading_for_firefox', '');

		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_enable_video_lazyloading_for_firefox" id="misc_options_enable_video_lazyloading_for_firefox" '.$checked.'>
		<br><label for="misc_options_enable_video_lazyloading_for_firefox">If enabled, videos might not show up on Firefox upon navigating on the website.</label>';
    }    

    public function misc_setting_swap_webfonts(){
        $val = get_option('misc_options_swap_webfonts', 'on');

		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_swap_webfonts" id="misc_options_swap_webfonts" '.$checked.'>
		<br><label for="misc_options_swap_webfonts">If enabled, show text even when webfont hasn\'t loaded.</label>';
    }

    public function misc_setting_never_change_scrolling_position(){
        $val = get_option('misc_options_never_change_scrolling_position', '');

		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="misc_options_never_change_scrolling_position" id="misc_options_never_change_scrolling_position" '.$checked.'>
		<br><label for="misc_options_never_change_scrolling_position">This option only makes sense for <a target="_blank" href="https://laytheme.com/tutorials/create-a-splitscreen-website.html">split-screen websites</a> and is active for desktop/tablet only.</label>';
    }

    public function misc_setting_use_revealing_transition_on_first_visit(){
        $val = get_option('misc_options_use_revealing_transition_on_first_visit', 'on');
        if( MiscOptions::$locked ) {
            $val = 'on';
        }
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input '.MiscOptions::$disabled_input.' type="checkbox" name="misc_options_use_revealing_transition_on_first_visit" id="misc_options_use_revealing_transition_on_first_visit" '.$checked.'> '.MiscOptions::$unlock_notice.' <label for="misc_options_use_revealing_transition_on_first_visit">(will also fade in menu, site title etc on first page load)</label>';
    }

    public function misc_setting_navigation_transition_out(){
        $val = get_option( 'misc_options_navigation_transition_out', 'fade' );

        if( MiscOptions::$locked || $val == '' ) {
            $val = 'fade';
        }
        $selected1 = $val == 'fade' ? 'selected' : '';
        $selected2 = $val == 'stagger-fade' ? 'selected' : '';
        $selected3 = $val == 'stagger-up' ? 'selected' : '';
        $selected4 = $val == 'stagger-down' ? 'selected' : '';
        $selected5 = $val == 'up' ? 'selected' : '';
        $selected6 = $val == 'down' ? 'selected' : '';
        $selected7 = $val == 'none' ? 'selected' : '';

        echo 
        '<select '.MiscOptions::$disabled_input.' name="misc_options_navigation_transition_out" id="misc_options_navigation_transition_out">
            <option value="fade" '.$selected1.'>Fade</option> 
            <option value="stagger-fade" '.$selected2.'>Stagger Fade</option>
            <option value="stagger-up" '.$selected3.'>Stagger Up</option>
            <option value="stagger-down" '.$selected4.'>Stagger Down</option>
            <option value="up" '.$selected5.'>Up</option>
            <option value="down" '.$selected6.'>Down</option>
            <option value="none" '.$selected7.'>None</option>
        </select> '.MiscOptions::$unlock_notice.' <label for="misc_options_navigation_transition_out" id="misc_options_navigation_transition_out"> When you leave a page</label>';
    }

    public function misc_setting_navigation_transition_in_easing(){
        $val = get_option( 'misc_options_navigation_transition_in_easing', 'easeOutSine' );
        if( MiscOptions::$locked || $val == '' ) {
            $val = 'easeOutSine';
        }
		echo '<input '.MiscOptions::$disabled_input.' type="text" name="misc_options_navigation_transition_in_easing" id="misc_options_navigation_transition_in_easing" value="'.$val.'"> '.MiscOptions::$unlock_notice.' <span>Find easings <a target="_blank" href="https://animejs.com/documentation/#pennerFunctions">here</a>. Anything with "easeOut" works well here.</span>';
    }

    public function misc_setting_navigation_transition_out_easing(){
        $val = get_option( 'misc_options_navigation_transition_out_easing', 'easeInSine' );
        if( MiscOptions::$locked || $val == '' ) {
            $val = 'easeInSine';
        }
        echo '<input '.MiscOptions::$disabled_input.' type="text" name="misc_options_navigation_transition_out_easing" id="misc_options_navigation_transition_out_easing" value="'.$val.'"> '.MiscOptions::$unlock_notice.' <span>Find easings <a target="_blank" href="https://animejs.com/documentation/#pennerFunctions">here</a>. Anything with "easeIn" works well here.</span>';
    }

    public function misc_setting_navigation_transition_y_translate_desktop(){
        $val = get_option( 'misc_options_navigation_transition_y_translate_desktop', 100 );
        if( MiscOptions::$locked || $val == '' ) {
            $val = 100;
        }
		echo '<input '.MiscOptions::$disabled_input.' type="number" min="10" name="misc_options_navigation_transition_y_translate_desktop" id="misc_options_navigation_transition_y_translate_desktop" value="'.$val.'"> px '.MiscOptions::$unlock_notice.' (Amount of pixel to move for up and down transitions)';
    }

    public function misc_setting_navigation_transition_y_translate_phone(){
        $val = get_option( 'misc_options_navigation_transition_y_translate_phone', 50 );
        if( MiscOptions::$locked || $val == '' ) {
            $val = 50;
        }
        echo '<input '.MiscOptions::$disabled_input.' type="number" min="10" name="misc_options_navigation_transition_y_translate_phone" id="misc_options_navigation_transition_y_translate_phone" value="'.$val.'"> px '.MiscOptions::$unlock_notice.' (Amount of pixel to move for up and down transitions)';
    }

    public function misc_setting_navigation_transition_in(){
        $val = get_option( 'misc_options_navigation_transition_in', 'fade' );

        if( MiscOptions::$locked || $val == '' ) {
            $val = 'fade';
        }
        $selected1 = $val == 'fade' ? 'selected' : '';
        $selected2 = $val == 'stagger-fade' ? 'selected' : '';
        $selected3 = $val == 'stagger-up' ? 'selected' : '';
        $selected4 = $val == 'stagger-down' ? 'selected' : '';
        $selected5 = $val == 'up' ? 'selected' : '';
        $selected6 = $val == 'down' ? 'selected' : '';
        $selected7 = $val == 'none' ? 'selected' : '';

        echo 
        '<select '.MiscOptions::$disabled_input.' name="misc_options_navigation_transition_in" id="misc_options_navigation_transition_in">
            <option value="fade" '.$selected1.'>Fade</option> 
            <option value="stagger-fade" '.$selected2.'>Stagger Fade</option>
            <option value="stagger-up" '.$selected3.'>Stagger Up</option>
            <option value="stagger-down" '.$selected4.'>Stagger Down</option>
            <option value="up" '.$selected5.'>Up</option>
            <option value="down" '.$selected6.'>Down</option>
            <option value="none" '.$selected7.'>None</option>
        </select> '.MiscOptions::$unlock_notice.' <label for="misc_options_navigation_transition_in"> When you arrive on a page</label>';
    }

	public function misc_setting_navigation_transition_in_duration(){
		$default = get_option( 'misc_options_navigation_transition_duration', '0.3' );
        $default = (float)$default;
        $default /= 2;
        $default *= 1000;
        $val = get_option( 'misc_options_navigation_transition_in_duration', $default );
        if( MiscOptions::$locked || $val == '' ) {
            $val = 300;
        }
		echo '<input '.MiscOptions::$disabled_input.' type="number" min="0" step="1" name="misc_options_navigation_transition_in_duration" id="misc_options_navigation_transition_in_duration" value="'.$val.'"> '.MiscOptions::$unlock_notice.' <label for="misc_options_navigation_transition_in_duration"> milliseconds</label>';
	}

	public function misc_setting_navigation_transition_out_duration(){
		$default = get_option( 'misc_options_navigation_transition_duration', '0.3' );
        $default = (float)$default;
        $default /= 2;
        $default *= 1000;
        $val = get_option( 'misc_options_navigation_transition_out_duration', $default );
        if( MiscOptions::$locked || $val == '' ) {
            $val = 300;
        }
		echo '<input '.MiscOptions::$disabled_input.' type="number" min="0" step="1" name="misc_options_navigation_transition_out_duration" id="misc_options_navigation_transition_out_duration" value="'.$val.'"> '.MiscOptions::$unlock_notice.' <label for="misc_options_navigation_transition_out_duration"> milliseconds</label>';
	}

	// public function misc_setting_navigation_transition_duration(){
	// 	$value = get_option( 'misc_options_navigation_transition_duration', '0.3' );
	// 	echo '<input type="number" min="0" step="0.1" name="misc_options_navigation_transition_duration" id="misc_options_navigation_transition_duration" value="'.$value.'"> <label for="misc_options_navigation_transition_duration"> seconds <br>When you click a menu point the content fades out and the new content fades in. This is the duration of that animation.</label>';
	// }

	public function misc_setting_website_description(){
		$description = get_option( 'misc_options_website_description', '' );
		echo
		'<textarea style="max-width: 700px; width: 100%; height: 150px;" name="misc_options_website_description" id="misc_options_website_description">'.$description.'</textarea><br>
		<p>The Website description will show up on Google and when someone shares your website on Facebook or Twitter.</p>';
	}

	public function misc_setting_image_alt_tag(){
		$image_alt_tag = get_option( 'misc_options_image_alt_tag', '' );
		echo '<input type="text" name="misc_options_image_alt_tag" id="misc_options_image_alt_tag" value="'.$image_alt_tag.'"><br>
		<label for="misc_options_image_alt_tag"> This text will be added to all image alt tags. If an image has an Alt text set already, this will just be added to it.<br>
		Alt Tags are important for Search Engines. Here you could write your name or company\'s name or site title.</label>';
	}

	public function misc_setting_fbimage(){
		// https://gist.github.com/hlashbrooke/9267467#file-class-php-L324
		$image_thumb_id = get_option( 'misc_options_fbimage', '' );
		$image_thumb = Setup::$uri.'/options/assets/img/noimage.jpg';
		$noimage_image = $image_thumb;
		$hideRemoveButtonCSS = '';
		if($image_thumb_id != ''){
			$image_thumb = wp_get_attachment_image_src( $image_thumb_id, 'full' );
			$image_thumb = $image_thumb[0];
		}
		else{
			$hideRemoveButtonCSS = 'style="display:none;"';
		}
		$option_name = 'misc_options_fbimage';
		echo
		'<img id="'.$option_name.'_preview" style="max-width: 200px;" class="image_preview" data-noimagesrc="'.$noimage_image.'" src="'.$image_thumb.'">
		<p style="margin-bottom: 10px;">This image will show up when someone posts your website on Facebook or Twitter.<br>
		This should be a .jpg with 1200px width and 630px height to look good on Facebook.<br>
		To let Facebook know you are using a new image go <a href="https://developers.facebook.com/tools/debug/" target="_blank">here</a>, paste your website address, and click "Fetch new scrape information".</p>
		<input id="'.$option_name.'_button" style="margin-bottom: 5px;" type="button" class="image_upload_button button" value="Set image" /><br>
		<input id="'.$option_name.'_delete" '.$hideRemoveButtonCSS.' type="button" class="image_delete_button button" value="Remove image" /><br>
		<input id="'.$option_name.'" class="image_data_field" type="hidden" name="'.$option_name.'" value="'.$image_thumb_id.'"/>';
	}

	public function misc_setting_html5video_playicon(){
		// https://gist.github.com/hlashbrooke/9267467#file-class-php-L324
		$image_thumb_id = get_option( 'misc_options_html5video_playicon', '' );
		$image_thumb = Setup::$uri.'/frontend/assets/img/play.svg';
		$noimage_image = $image_thumb;
		$hideRemoveButtonCSS = '';
		if($image_thumb_id != ''){
			$image_thumb = wp_get_attachment_image_src( $image_thumb_id, 'full' );
			$image_thumb = $image_thumb[0];
		}
		else{
			$hideRemoveButtonCSS = 'style="display:none;"';
		}
		$option_name = 'misc_options_html5video_playicon';
		echo
		'<img id="'.$option_name.'_preview" style="max-width: 100%;" class="image_preview" data-noimagesrc="'.$noimage_image.'" src="'.$image_thumb.'"><br>
		<input id="'.$option_name.'_button" style="margin-bottom: 5px;" type="button" class="image_upload_button button" value="Set image" /><br>
		<input id="'.$option_name.'_delete" '.$hideRemoveButtonCSS.' type="button" class="image_delete_button button" value="Set to default" /><br>
		<input id="'.$option_name.'" class="image_data_field" type="hidden" name="'.$option_name.'" value="'.$image_thumb_id.'"/>';
	}

}
new MiscOptions();
