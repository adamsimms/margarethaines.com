<?php
// http://codex.wordpress.org/Settings_API#Examples
class FooterOptions{

	public static $pagesArray;

	public function __construct(){
		add_action( 'admin_init', array($this, 'set_pages_array') );

		add_action( 'admin_menu', array($this, 'footeroptions_setup_menu'), 10 );
		add_action( 'admin_init', array($this, 'footer_options_settings_api_init') );

		add_action( 'admin_enqueue_scripts', array($this, 'footer_options_enqueue_scripts') );

		add_action( 'wp_head', array($this, 'add_sticky_footer_css'));
	}

	public function add_sticky_footer_css(){
		$lay_sticky_footer = get_option('lay_sticky_footer', 'on');
		if($lay_sticky_footer == "on"){

			$mobile_hide_menu = get_theme_mod('mobile_hide_menu', 0);
			$mobile_hide_menubar = get_theme_mod('mobile_hide_menubar', 0);
			$mobile_menubar_height = get_theme_mod('mobile_menubar_height', 40);

			$breakpoint = get_option('lay_breakpoint', 600);
			$breakpoint = (int)$breakpoint;
			$css =
			'<!-- sticky footer css -->
			<style>
				body.woocommerce-page{
					display: flex;
					flex-direction: column;
					min-height: 100vh;
				}
				body.woocommerce-page #lay-woocommerce{
					flex: 1 0 auto;
				}
				body>.lay-content{
					display: -webkit-box;
					display: -webkit-flex;
					display: -ms-flexbox;
					display: flex;
					-webkit-box-orient: vertical;
					-webkit-box-direction: normal;
					-webkit-flex-direction: column;
					-ms-flex-direction: column;
					flex-direction: column;
				}
				/* needs to work for desktop grid and cpl grid container */
			    #grid, #custom-phone-grid {
					-webkit-box-flex: 1 0 auto;
					-webkit-flex: 1 0 auto;
					-ms-flex: 1 0 auto;
					flex: 1 0 auto;
	          	}
	          	/* firefox fix */
	          	#footer-region{
	          		overflow: hidden;
				}
				@media (min-width: '.($breakpoint+1).'px){
					body>.lay-content{
						min-height: 100vh;
					}
				}
				@media (max-width: '.($breakpoint).'px){
                    body:not(.woocommerce-page).no-touchdevice.sticky-footer-option-enabled>.lay-content{
                        min-height: 100vh;
                    }
					body.woocommerce-page>.lay-content{
						min-height: auto;
					}';

			if( $mobile_hide_menubar != '1' ) {
				// note to self: i cant do this on touchdevices, because if the page is only 100vh, this messes up the height and there can be too much space on an iphone
				$css .=
					'/* account for possible mobile menu menubar height,
					not if this is a woocommerce page */
					.no-touchdevice body:not(.woocommerce-page)>.lay-content{
						min-height: calc(100vh - '.$mobile_menubar_height.'px);
					}';
			}

			$css .= '
				}
			</style>';
			echo $css;
		}
	}

	public function footer_options_enqueue_scripts($hook){
		if($hook == "lay-options_page_manage-footer"){
			wp_enqueue_script( 'footer_options_settings_showhide', Setup::$uri.'/options/assets/js/footer_options_showhide.js', array(), Setup::$ver, true );
		}
	}

	public function set_pages_array(){
		$query = new WP_Query(array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'fields' => 'ids'
		));

		if ( $query->have_posts() ) {
			foreach ($query->posts as $id){
				FooterOptions::$pagesArray []= array(get_the_title($id), $id);
			}
		}else{
			FooterOptions::$pagesArray = array();
		}

	}

	public function footeroptions_setup_menu(){
		// http://wordpress.stackexchange.com/questions/66498/add-menu-page-with-different-name-for-first-submenu-item
		add_submenu_page( 'manage-layoptions', 'Footers', 'Footers', 'manage_options', 'manage-footer', array($this, 'footer_options_markup') );
	}

	public function footer_options_markup(){
    	require_once( Setup::$dir.'/options/footer_options_markup.php' );
	}

	public function footer_options_settings_api_init() {
	 	add_settings_section(
			'footer_options_section',
			'',
			'',
			'manage-footer'
		);

	 	add_settings_field(
			'lay_footer_active_in_projects',
			'Footer for Projects',
			array($this, 'lay_footer_active_in_projects_setting'),
			'manage-footer',
			'footer_options_section'
		);
	 	register_setting( 'manage-footer', 'lay_footer_active_in_projects' );

 	 	add_settings_field(
 			'lay_projects_footer',
 			'Choose a Page as Footer for Projects',
 			array($this, 'lay_projects_footer_setting'),
 			'manage-footer',
 			'footer_options_section'
 		);
 	 	register_setting( 'manage-footer', 'lay_projects_footer' );

 	 	add_settings_field(
 			'lay_footer_active_in_pages',
 			'Footer for Pages',
 			array($this, 'lay_footer_active_in_pages_setting'),
 			'manage-footer',
 			'footer_options_section'
 		);
 	 	register_setting( 'manage-footer', 'lay_footer_active_in_pages' );

 	 	add_settings_field(
 			'lay_pages_footer',
 			'Choose a Page as Footer for Pages',
 			array($this, 'lay_pages_footer_setting'),
 			'manage-footer',
 			'footer_options_section'
 		);
 	 	register_setting( 'manage-footer', 'lay_pages_footer' );

		$val = get_option('misc_options_activate_news_feature', '');
		if( $val == "on" && !MiscOptions::$locked ){

			add_settings_field(
				'lay_footer_active_in_news',
				'Footer for News',
				array($this, 'lay_footer_active_in_news_setting'),
				'manage-footer',
				'footer_options_section'
			);
			register_setting( 'manage-footer', 'lay_footer_active_in_news' );

			add_settings_field(
				'lay_news_footer',
				'Choose a Page as Footer for News',
				array($this, 'lay_news_footer_setting'),
				'manage-footer',
				'footer_options_section'
			);
			register_setting( 'manage-footer', 'lay_news_footer' );
			
		}

 	 	add_settings_field(
 			'lay_footer_active_in_categories',
 			'Footer for Categories',
 			array($this, 'lay_footer_active_in_categories_setting'),
 			'manage-footer',
 			'footer_options_section'
 		);
 	 	register_setting( 'manage-footer', 'lay_footer_active_in_categories' );

 	 	add_settings_field(
 			'lay_categories_footer',
 			'Choose a Page as Footer for Categories',
 			array($this, 'lay_categories_footer_setting'),
 			'manage-footer',
 			'footer_options_section'
 		);
 	 	register_setting( 'manage-footer', 'lay_categories_footer' );

 	 	add_settings_field(
 			'lay_sticky_footer',
 			'Sticky Footer',
 			array($this, 'lay_sticky_footer_setting'),
 			'manage-footer',
 			'footer_options_section'
 		);
 	 	register_setting( 'manage-footer', 'lay_sticky_footer' );
	}

	public function lay_sticky_footer_setting(){
		$val = get_option('lay_sticky_footer', 'on');
		$checked = "";
		if( $val == "on" ){
			$checked = "checked";
		}
		echo '<input type="checkbox" name="lay_sticky_footer" id="lay_sticky_footer" '.$checked.'> <br><label>Will position footer at bottom when content is smaller than browser-height</label>';
	}

	public function lay_pages_footer_setting(){
		$val = get_option('lay_pages_footer', '');
		if(count(FooterOptions::$pagesArray) == 0){
			echo '<p id="lay_pages_footer">Please create a page to select it as a footer.</p>';
		}else{
			echo '<select id="lay_pages_footer" name="lay_pages_footer">';

			$select = $val == '' ? 'selected' : '';
			echo '<option value="" '.$select.'>--SELECT--</value>';
			foreach (FooterOptions::$pagesArray as $key => $value) {
				$select = $val == $value[1] ? 'selected' : '';
				echo '<option value="'.$value[1].'" '.$select.'>'.$value[0].'</option>';
			}
			echo '</select>';
		}
	}

	public function lay_news_footer_setting(){
		$val = get_option('lay_news_footer', '');
		if(count(FooterOptions::$pagesArray) == 0){
			echo '<p id="lay_news_footer">Please create a page to select it as a footer.</p>';
		}else{
			echo '<select id="lay_news_footer" name="lay_news_footer">';

			$select = $val == '' ? 'selected' : '';
			echo '<option value="" '.$select.'>--SELECT--</value>';
			foreach (FooterOptions::$pagesArray as $key => $value) {
				$select = $val == $value[1] ? 'selected' : '';
				echo '<option value="'.$value[1].'" '.$select.'>'.$value[0].'</option>';
			}
			echo '</select>';
		}
	}

	public function lay_projects_footer_setting(){
		$val = get_option('lay_projects_footer', '');
		if(count(FooterOptions::$pagesArray) == 0){
			echo '<p id="lay_projects_footer">Please create a page to select it as a footer.</p>';
		}else{
			echo '<select id="lay_projects_footer" name="lay_projects_footer">';

			$select = $val == '' ? 'selected' : '';
			echo '<option value="" '.$select.'>--SELECT--</value>';
			foreach (FooterOptions::$pagesArray as $key => $value) {
				$select = $val == $value[1] ? 'selected' : '';
				echo '<option value="'.$value[1].'" '.$select.'>'.$value[0].'</option>';
			}
			echo '</select>';
		}
	}

	public function lay_categories_footer_setting(){
		$val = get_option('lay_categories_footer', '');
		if(count(FooterOptions::$pagesArray) == 0){
			echo '<p id="lay_categories_footer">Please create a page to select it as a footer.</p>';
		}else{
			echo '<select id="lay_categories_footer" name="lay_categories_footer">';

			$select = $val == '' ? 'selected' : '';
			echo '<option value="" '.$select.'>--SELECT--</value>';
			foreach (FooterOptions::$pagesArray as $key => $value) {
				$select = $val == $value[1] ? 'selected' : '';
				echo '<option value="'.$value[1].'" '.$select.'>'.$value[0].'</option>';
			}
			echo '</select>';
		}
	}

	public function lay_footer_active_in_projects_setting(){
		$val = get_option( 'lay_footer_active_in_projects', "off" );
		$checkedAll = "";
		$checkedIndividual = "";
		$checkedOff = "";

		if($val == "all"){
			$checkedAll = "checked";
		}
		else if($val == "individual"){
			$checkedIndividual = "checked";
		}
		else if($val == "off"){
			$checkedOff = "checked";
		}

		echo
		'<input type="radio" name="lay_footer_active_in_projects" value="all" '.$checkedAll.' id="all-projects"><label for="all-projects">Active for all Projects</label><br>
		<input type="radio" name="lay_footer_active_in_projects" value="individual" '.$checkedIndividual.' id="individual-projects"><label for="individual-projects">Show a select input in the Project Edit Screen to choose a Footer for individual Projects</label><br>
		<input type="radio" name="lay_footer_active_in_projects" value="off" '.$checkedOff.' id="off-projects"><label for="off-projects">Off for all Projects</label>';
	}

	public function lay_footer_active_in_pages_setting(){
		$val = get_option( 'lay_footer_active_in_pages', "off" );
		$checkedAll = "";
		$checkedIndividual = "";
		$checkedOff = "";

		if($val == "all"){
			$checkedAll = "checked";
		}
		else if($val == "individual"){
			$checkedIndividual = "checked";
		}
		else if($val == "off"){
			$checkedOff = "checked";
		}

		echo
		'<input type="radio" name="lay_footer_active_in_pages" value="all" '.$checkedAll.' id="all-pages"><label for="all-pages">Active for all Pages</label><br>
		<input type="radio" name="lay_footer_active_in_pages" value="individual" '.$checkedIndividual.' id="individual-pages"><label for="individual-pages">Show a select input in the Page Edit Screen to choose a Footer for individual Pages</label><br>
		<input type="radio" name="lay_footer_active_in_pages" value="off" '.$checkedOff.' id="off-pages"><label for="off-pages">Off for all Pages</label>';
	}

	public function lay_footer_active_in_news_setting(){
		$val = get_option( 'lay_footer_active_in_news', "off" );
		$checkedAll = "";
		$checkedIndividual = "";
		$checkedOff = "";

		if($val == "all"){
			$checkedAll = "checked";
		}
		else if($val == "individual"){
			$checkedIndividual = "checked";
		}
		else if($val == "off"){
			$checkedOff = "checked";
		}

		echo
		'<input type="radio" name="lay_footer_active_in_news" value="all" '.$checkedAll.' id="all-news"><label for="all-news">Active for all News</label><br>
		<input type="radio" name="lay_footer_active_in_news" value="individual" '.$checkedIndividual.' id="individual-news"><label for="individual-news">Show a select input in the Page Edit Screen to choose a Footer for individual News</label><br>
		<input type="radio" name="lay_footer_active_in_news" value="off" '.$checkedOff.' id="off-news"><label for="off-news">Off for all News</label>';
	}

	public function lay_footer_active_in_categories_setting(){
		$val = get_option( 'lay_footer_active_in_categories', "off" );
		$checkedAll = "";
		$checkedIndividual = "";
		$checkedOff = "";

		if($val == "all"){
			$checkedAll = "checked";
		}
		else if($val == "individual"){
			$checkedIndividual = "checked";
		}
		else if($val == "off"){
			$checkedOff = "checked";
		}

		echo
		'<input type="radio" name="lay_footer_active_in_categories" value="all" '.$checkedAll.' id="all-categories"><label for="all-categories">Active for all Categories</label><br>
		<input type="radio" name="lay_footer_active_in_categories" value="individual" '.$checkedIndividual.' id="individual-categories"><label for="individual-categories">Show a select input in the Category Edit Screen to choose a Footer for individual Categories</label><br>
		<input type="radio" name="lay_footer_active_in_categories" value="off" '.$checkedOff.' id="off-categories"><label for="off-categories">Off for all Categories</label>';
	}

}
new FooterOptions();
