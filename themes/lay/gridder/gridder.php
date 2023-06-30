<?php

class Gridder{

	public static $tinymceSettings;
	public static $maxFontsize;
	public static $rowgutter_mu;
	public static $topframe_mu;
	public static $frame_mu;
	public static $bottomframe_mu;
	public static $phone_rowgutter_mu;
	public static $active_for_news;

	public function __construct(){
		Gridder::$rowgutter_mu = get_option( 'gridder_defaults_rowgutter_mu', LayConstants::gridder_defaults_rowgutter_mu );
		Gridder::$topframe_mu = get_option( 'gridder_defaults_topframe_mu', LayConstants::gridder_defaults_topframe_mu );
		Gridder::$frame_mu = get_option( 'gridder_defaults_frame_mu', LayConstants::gridder_defaults_frame_mu );
		Gridder::$bottomframe_mu = get_option( 'gridder_defaults_bottomframe_mu', LayConstants::gridder_defaults_bottomframe_mu );
		Gridder::$phone_rowgutter_mu = get_option( 'phone_gridder_defaults_rowgutter_mu', LayConstants::phone_gridder_defaults_rowgutter_mu );
		Gridder::$active_for_news = get_option('misc_options_activate_news_feature', '') == 'on' && !MiscOptions::$locked ? true : false;

        // todo:
        // https://jonathannicol.com/blog/2015/02/19/clean-pasted-text-in-wordpress/
        
        // https://wordpress.stackexchange.com/questions/334832/how-to-disable-tinymces-paste-plugin-from-turning-image-urls-into-embedded-img
		Gridder::$tinymceSettings = array(
		    'media_buttons' => false,
		    'quicktags' => false,
            // 'smart_paste' => false,
            // 'paste_as_text' => true,
            // pass tinymce options here:
		    'tinymce' => array(
		        'toolbar1' => 'undo, redo, laylink, layunlink, laybutton1, laybutton2, laybutton3, layprevproject, laynextproject, layexpandrow, fontselect, fontsizeselect, lineheightselect, letterspacingselect, table, laynightmode',
		        'toolbar2' => 'styleselect, forecolor, bold, italic, underline, strikethrough, alignleft, aligncenter, alignright, charmap, nonbreaking, softhyphen, visualblocks, code, bullist, numlist',
		        'toolbar3' => 'removeformat, style-p style-h1 style-h2 style-h3 style-h4 style-h5',
		        'toolbar4' => '',
                // https://www.tiny.cloud/docs-4x/configure/content-formatting/#removingaformat
                // https://www.tiny.cloud/docs-3x/reference/Configuration3x/Configuration3x@formats/
                
                // 'formats' => array(
                //     'removeformat' => json_encode(array('selector' => '*', 'remove' => 'all', 'attributes' => array('style', 'class'), 'split' => true, 'expand' => true, 'block_expand' => true, 'deep' => true, 'block' => 'p'))
                // )
                // removeformat is the clear format button. using this code i make sure all headlines are transformed into <p> tags and all style attributes are removed
                // i got this code by logging $in of tiny_mce_before_init filter
                'formats' => '{removeformat: [{selector: "*", attributes : ["style", "class"], split : true, expand : true, deep : true, remove: "none", block_expand: true, block: "p"}],alignleft: [{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"left"}},{selector: "img,table,dl.wp-caption", classes: "alignleft"}],aligncenter: [{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"center"}},{selector: "img,table,dl.wp-caption", classes: "aligncenter"}],alignright: [{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"right"}},{selector: "img,table,dl.wp-caption", classes: "alignright"}],strikethrough: {inline: "del"}}'
		    )
		);

		Gridder::$maxFontsize = 300;

		add_action( 'add_meta_boxes', array( $this, 'add_gridder_meta_boxes' ) );

		add_action( 'save_post', array( $this, 'save_desktop_json' ) );
		add_action( 'save_post', array( $this, 'save_phone_json' ) );

		add_action( 'admin_init', array( $this, 'register_lay_iris' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'gridder_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'gridder_scripts' ) );

		// tiny mce
		add_filter('tiny_mce_before_init', array( $this, 'tinymce_fontsizes') );
		add_filter('tiny_mce_before_init', array( $this, 'unhide_kitchensink') );
		add_filter('tiny_mce_before_init', array( $this, 'tinymce_config') );

		add_filter( 'mce_external_plugins', array( $this, 'tinymce_external_plugins') );
		add_action( 'admin_init', array( $this, 'my_deregister_editor_expand') );
		add_action( 'admin_enqueue_scripts', array( $this, 'deregister_wplink' ) );

		add_filter( 'tiny_mce_plugins', array( $this, 'tinymce_remove_default_plugins' ) );
		// #tiny mce

		// ajax
		add_action( 'wp_ajax_set_notice_hidden_via_ajax', array( $this, 'set_notice_hidden_via_ajax'));

		add_action('wp_ajax_get_embed', array($this, 'get_embed'));
		add_action('wp_ajax_nopriv_get_embed', array($this, 'get_embed'));

		add_action('wp_ajax_get_posts_for_laylinkmodal', array($this, 'get_posts_for_laylinkmodal'));
		add_action('wp_ajax_get_posts_for_laylinkmodal_json', array($this, 'get_posts_for_laylinkmodal_json'));
		
		add_action('wp_ajax_get_gridder_revision', array($this, 'get_gridder_revision' ));

		add_action('wp_ajax_set_guides_visibility', array($this, 'set_guides_visibility'));
		add_action('wp_ajax_set_connect_left_right_frame', array($this, 'set_connect_left_right_frame'));
        add_action('wp_ajax_set_connect_top_bottom_frame', array($this, 'set_connect_top_bottom_frame'));

		add_action('wp_ajax_get_markup_for_yoast', array($this, 'get_markup_for_yoast'));

        add_action('wp_ajax_set_element_layers_window_position', array($this, 'set_element_layers_window_position'));
        add_action('wp_ajax_set_element_layers_window_expanded', array($this, 'set_element_layers_window_expanded'));
	}

    public static function set_element_layers_window_expanded(){
        $expanded = $_GET['expanded'];
        update_option('lay_element_layers_window_expanded', $expanded);
    }

    public static function set_element_layers_window_position(){
        $json = $_GET['coordinates'];
        update_option('lay_element_layers_window_position', json_encode($json));
    }

	public static function get_markup_for_yoast() {
		$json = $_POST['lay_yoast_json'];
		$markup = '';
        for( $i2=0; $i2<count($json); $i2++ ){
            $col = $json[$i2];
            $layEl = new LayEl($col, false, -1, 'desktop');
            $markup .= $layEl->getMarkup();
        }
		echo stripcslashes(html_entity_decode($markup));
		die();
    }

    public static function set_connect_top_bottom_frame() {
		$visible = $_POST['connect_top_bottom_frame'];
		update_option('lay_connect_top_bottom_frame', $visible);
    }

	public static function set_connect_left_right_frame() {
		$visible = $_POST['connect_left_right_frame'];
		update_option('lay_connect_left_right_frame', $visible);
	}

	// set visibility in database
	public static function set_guides_visibility() {
		$visible = $_POST['visibility'];
		update_option('lay_guides_visibility', $visible);
	}

	public static function get_gridder_revision() {
		$id = intval($_POST['id']);
		$screen_base = $_POST['screen_base'];

		$gridderval = "";
		$phonegridderval = "";

		if ($screen_base == 'term') {
			$gridderval = get_option( $id.'_category_gridder_json_last', true );
			update_option( $id.'_category_gridder_json', $gridderval );

			$phonegridderval = get_option( $id.'_phone_category_gridder_json_last', true );
			update_option( $id.'_phone_category_gridder_json', $phonegridderval );
		}else{
			// post, page
			$gridderval = get_post_meta( $id, '_gridder_json_last', true );
			$gridderval = wp_slash($gridderval);
			update_post_meta( $id, '_gridder_json', $gridderval );

			$phonegridderval = get_post_meta( $id, '_phone_gridder_json_last', true );
			$phonegridderval = wp_slash($phonegridderval);
			update_post_meta( $id, '_phone_gridder_json', $phonegridderval );
		}

		$data = array(
			'gridder' => $gridderval,
			'gridder_phone' => $phonegridderval
		);

		wp_send_json($data);
		wp_die();
	}

	public static function get_embed(){
		$s = $_POST['layembedval'];
		echo wp_oembed_get($s);
		die();
	}

	public static function get_posts_for_laylinkmodal(){

		$post_types_to_query = array('post', 'page');

		$args = array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => $post_types_to_query
		);
		$all_posts_query = new WP_Query( $args );

		$markup = '<div id="wp-link"><ul>';
		$ix = 0;

		if ( $all_posts_query->have_posts() ) {
			foreach ($all_posts_query->posts as $post){
				$id = $post->ID;
				$title = $post->post_title;
				$permalink = get_permalink($post);

				$alternate = $ix % 2 == 0 ? ' class="alternate"' : '';

				$post_type = $post->post_type;
				if($post_type == "post"){
					$post_type = "project";
				}
				$info = $post_type.' ';
				$info .= date('Y/m/d', strtotime($post->post_date));

				$cat_id = "";
				if($post->post_type == "post"){
					$cat = get_the_category($post->ID);
					$cat_id = $cat[0]->term_id;
				}

				$markup .=
				'<li'.$alternate.' data-type="'.$post_type.'" data-id="'.$id.'">
					<input type="hidden" class="item-permalink" value="'.$permalink.'">
					<input type="hidden" class="item-id" value="'.$id.'">
					<input type="hidden" class="item-type" value="'.$post_type.'">
					<input type="hidden" class="item-catid" value="'.$cat_id.'">
					<span class="item-title">'.$post->post_title.'</span>
					<span class="item-info">'.$info.'</span>
				</li>';
				$ix++;
			}
		}

		// categories
		$terms = get_terms( 'category', array(
		    'hide_empty' => false,
		) );
		foreach ($terms as $term) {

			$id = $term->term_id;
			$title = $term->name;
			$permalink = get_term_link($term);

			$alternate = $ix % 2 == 0 ? ' class="alternate"' : '';

			$markup .=
			'<li'.$alternate.' data-type="category" data-id="'.$id.'">
				<input type="hidden" class="item-permalink" value="'.$permalink.'">
				<input type="hidden" class="item-id" value="'.$id.'">
				<input type="hidden" class="item-type" value="category">
				<span class="item-title">'.$title.'</span>
				<span class="item-info">category</span>
			</li>';
			$ix++;
		}

		$markup .= '</ul></div>';

		echo '<input type="search" name="lay-imagelink-search-input" id="lay-imagelink-search-input" placeholder="Search"><div class="lay-imagelink-postlist-wrap">'.$markup.'</div>';
		die();
	}

	public static function get_posts_for_laylinkmodal_json(){
		$post_types_to_query = array('post', 'page');
		if( class_exists('WooCommerce') ) {
			$post_types_to_query = array('post', 'page', 'product');
		}
		$val = get_option('misc_options_activate_news_feature', '');
		if( $val == "on" && !MiscOptions::$locked ){
			$post_types_to_query []= 'lay_news';
		}

		$args = array(
			'posts_per_page' => -1,
			'orderby' => array('type' => 'DESC', 'date' => 'DESC'),
			'order' => 'ASC',
			'post_type' => $post_types_to_query
		);
		$all_posts_query = new WP_Query( $args );

		$posts = array();

		if ( $all_posts_query->have_posts() ) {
			foreach ($all_posts_query->posts as $post){
				$permalink = get_permalink($post);
				$date = date('Y/m/d', strtotime($post->post_date));
				
				$post_type = $post->post_type;
				if ($post_type == "post") {
					$post_type = "project";
				}
				if ($post_type == "lay_news") {
					$post_type = "news";
				}

				$catid = array(0);
				if ($post->post_type == "post") {
					$categories = get_the_category($post->ID);
					$catid = array();
					foreach($categories as $cat){
						$catid []= $cat->term_id;
					}
				}

				$posts[] = array(
					'url' => $permalink,
					'id' => $post->ID,
					'type' => $post_type,
					'title' => $post->post_title,
					'date' => $date,
					'catid' => json_encode($catid)
				);
			}
		}

		// categories
		$terms = get_terms( 'category', array(
				'hide_empty' => false,
		) );

		foreach ($terms as $term) {
			$id = $term->term_id;
			$title = $term->name;
			$permalink = get_term_link($term);

			$posts[] = array(
				'url' => $permalink,
				'id' => $id,
				'type' => 'category',
				'title' => $title,
				'catid' => $catid
			);
		}

		wp_send_json($posts);
		die();
	}

	public function set_notice_hidden_via_ajax(){
		$optionname = $_POST['optionname'];
		update_option( $optionname, 'hide' );
		echo get_option( $optionname, '' );
		die();
	}

	public function unhide_kitchensink($args){
		$args['wordpress_adv_hidden'] = false;
		return $args;
	}

	// no auto resize and no expand for tinymce
	// https://core.trac.wordpress.org/ticket/29360#comment:10
	public function my_deregister_editor_expand() {
		wp_deregister_script('editor-expand');
	}
	public function tinymce_config( $init ) {
		unset( $init['wp_autoresize_on'] );

        // $init['paste_remove_styles'] = true;
		// $init['paste_remove_spans'] = true;
        // $init['paste_strip_class_attributes'] = 'all';
        // $init['paste_as_text'] = true;
        // $init['paste_text_sticky'] = true;

		return $init;
	}

	// http://www.wpexplorer.com/wordpress-tinymce-tweaks/
	public function tinymce_fontsizes( $initArray ){

		$sizes = '';
		$space = '';

		for($i=1; $i<Gridder::$maxFontsize; $i++){
			if($i>1){
				$space = ' ';
			}
			$sizes .= $space.$i.'px';
		}

	    $initArray['fontsize_formats'] = $sizes;
	    return $initArray;
	}

    public function tinymce_styles( ) {

    }

	public function tinymce_remove_default_plugins($plugins){
		// array(
		// 	'charmap',
		// 	'colorpicker',
		// 	// 'hr',
		// 	'lists',
		// 	// 'media',
		// 	'paste',
		// 	// 'tabfocus',
		// 	'textcolor',
		// 	// 'fullscreen',
		// 	'wordpress',
		// 	// 'wpautoresize',
		// 	// 'wpeditimage',
		// 	// 'wpemoji',
		// 	// 'wpgallery',
		// 	// 'wplink',
		// 	// 'wpdialogs',
		// 	// 'wptextpattern',
		// 	// 'wpview',
		// 	// 'wpembed',
		// 	// 'image'
		// );
		$not_needed = array('hr', 'media', 'tabfocus', 'fullscreen', 'wpeditimage', 'wpemoji', 'wpgallery', 'wpdialogs', 'wptextpattern', 'wpview', 'wpembed', 'image');
            // $plugins []= "advcode";
		$plugins = array_diff($plugins, $not_needed);

		return $plugins;
	}

	public function deregister_wplink(){
		wp_deregister_script( 'wplink' );
	}

	public function tinymce_external_plugins($plugins) {
        $plugins['h1_h2_p_buttons'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/h1_h2_p_buttons/plugin.js?ver='.Setup::$ver;
        $plugins['laybuttons'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/laybuttons/plugin.js?ver='.Setup::$ver;
		$plugins['laynightmode'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/nightmode/plugin.js?ver='.Setup::$ver;
		$plugins['height'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/height/plugin.js?ver='.Setup::$ver;
		$plugins['letterspacingselect'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/letterspacing/plugin.js?ver='.Setup::$ver;
		$plugins['lineheightselect'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/lineheight/plugin.js?ver='.Setup::$ver;
		$plugins['code'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/code/plugin.min.js?ver='.Setup::$ver;
	    $plugins['nonbreaking'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/nonbreaking/plugin.min.js?ver='.Setup::$ver;
	    $plugins['softhyphen'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/softhyphen/plugin.js?ver='.Setup::$ver;
	    $plugins['table'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/table/plugin.min.js?ver='.Setup::$ver;
	    $plugins['laylink'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/link/plugin.js?ver='.Setup::$ver;
	    $plugins['visualblocks'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/visualblocks/plugin.min.js?ver='.Setup::$ver;
	    $plugins['laynextproject'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/laynextproject/plugin.js?ver='.Setup::$ver;
	    $plugins['layprevproject'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/layprevproject/plugin.js?ver='.Setup::$ver;
        $plugins['layexpandrow'] = Setup::$uri.'/gridder/assets/js/tinymce-plugins/expandrows/plugin.js?ver='.Setup::$ver;
	    return $plugins;
	}

	public function add_gridder_meta_boxes(){
		// desktop gridder json
		add_meta_box( 'gridder-json-metabox', 'Gridder JSON', array( $this, 'gridder_json_metabox_callback'), 'post', 'normal', 'high' );
		add_meta_box( 'gridder-json-metabox', 'Gridder JSON', array( $this, 'gridder_json_metabox_callback'), 'page', 'normal', 'high' );

		// phone gridder json
		add_meta_box( 'gridder-phone-json-metabox', 'Gridder Phone JSON', array( $this, 'gridder_phone_json_metabox_callback'), 'post', 'normal', 'high' );
		add_meta_box( 'gridder-phone-json-metabox', 'Gridder Phone JSON', array( $this, 'gridder_phone_json_metabox_callback'), 'page', 'normal', 'high' );


		add_meta_box( 'gridder-metabox', 'Gridder', array( $this, 'gridder_metabox_callback'), 'post', 'normal', 'high' );
		add_meta_box( 'gridder-metabox', 'Gridder', array( $this, 'gridder_metabox_callback'), 'page', 'normal', 'high' );
	}

	public function save_desktop_json($post_id){

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['gridder_json_metabox_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['gridder_json_metabox_nonce'], 'gridder_json_metabox' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Make sure that it is set.
		if ( ! isset( $_POST['gridder_json_field'] ) ) {
			return;
		}

		// Sanitize user input.
		$gridder_json = $_POST['gridder_json_field'];

		// make sure its not a revision because a revision in wordpress removes escape backslashes and makes json invalid
		if(!wp_is_post_revision($post_id)){
			// save last meta field value
			$value = get_post_meta( $post_id, '_gridder_json', true );
			$value = wp_slash($value);
			update_post_meta( $post_id, '_gridder_json_last', $value );

			// update "real" meta
			// Update the meta field in the database.
			update_post_meta( $post_id, '_gridder_json', $gridder_json );
		}

	}

	public function gridder_json_metabox_callback( $post ){
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'gridder_json_metabox', 'gridder_json_metabox_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		// htmlspecialchars needed because textarea converts some chars
		$value = get_post_meta( $post->ID, '_gridder_json', true );

		echo '<textarea id="gridder_json_field" name="gridder_json_field" style="width:100%;height:200px;">';
		echo htmlspecialchars($value);
		echo '</textarea>';
	}

	public function save_phone_json($post_id){

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['gridder_phone_json_metabox_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['gridder_phone_json_metabox_nonce'], 'gridder_phone_json_metabox' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Make sure that it is set.
		if ( ! isset( $_POST['phone_gridder_json_field'] ) ) {
			return;
		}

		// Sanitize user input.
		$phone_gridder_json = $_POST['phone_gridder_json_field'];

		// make sure its not a revision because a revision in wordpress removes escape backslashes and makes json invalid
		if(!wp_is_post_revision($post_id)){
			// save last meta field value
			$value = get_post_meta( $post_id, '_phone_gridder_json', true );
			$value = wp_slash($value);
			update_post_meta( $post_id, '_phone_gridder_json_last', $value );

			// update "real" meta
			// Update the meta field in the database.
			update_post_meta( $post_id, '_phone_gridder_json', $phone_gridder_json );
		}

	}

	public function gridder_phone_json_metabox_callback( $post ){
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'gridder_phone_json_metabox', 'gridder_phone_json_metabox_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		// htmlspecialchars needed because textarea converts some chars
		$value = get_post_meta( $post->ID, '_phone_gridder_json', true );

		echo '<textarea id="phone_gridder_json_field" name="phone_gridder_json_field" style="width:100%;height:200px;">';
		echo htmlspecialchars($value);
		echo '</textarea>';
	}

	public function gridder_metabox_callback(){
		require_once( Setup::$dir.'/gridder/markup.php' );
	}

	public function gridder_styles() {
		$screen = get_current_screen();
		if ( LTUtility::is_admin_page_with_a_gridder($screen) ) {
			wp_enqueue_style( 'gridder-bootstrap', Setup::$uri.'/assets/bootstrap/css/bootstrap.css', array(), Setup::$ver );
			wp_enqueue_style( 'gridder-application', Setup::$uri.'/gridder/assets/css/gridder.style.css', array(), Setup::$ver );
		}
	}

	public function register_lay_iris(){
		// using modified version of iris to prevent scrolling when user drags inside colorpicker
		wp_register_script( 'lay-iris', Setup::$uri.'/assets/js/vendor/iris.js', array( 'jquery-ui-widget', 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch', 'jquery-color' ), '1.0.7' );
	}

	public function gridder_scripts() {
		$screen = get_current_screen();

		if ( LTUtility::is_admin_page_with_a_gridder($screen) ) {

			// ace for html modal
			wp_enqueue_script( 'vendor-ace', Setup::$uri.'/assets/js/vendor/ace/ace.js', array(), Setup::$ver );
			wp_enqueue_script( 'vendor-highlight', Setup::$uri.'/gridder/assets/js/vendor/highlight.pack.js', array(), Setup::$ver);
			wp_enqueue_script( 'vendor-webfontloader', Setup::$uri.'/gridder/assets/js/vendor/webfontloader.js', array(), Setup::$ver);
			wp_enqueue_script( 'vendor-masonry', Setup::$uri.'/gridder/assets/js/vendor/masonry.min.js', array(), Setup::$ver );
			wp_enqueue_script( 'vendor-sortable', Setup::$uri.'/gridder/assets/js/vendor/sortable.min.js', array(), Setup::$ver );
            // todo: i only use bootstrap.min.js for tooltips. i can just use some other lib for tooltips and then i wont need to enqueue this
			wp_enqueue_script( 'vendor-bootstrap', Setup::$uri.'/assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), Setup::$ver );

			wp_enqueue_media();

            wp_enqueue_script( 'gridder-app', Setup::$uri."/gridder/assets/js/gridder.app.min.js", array(
				'jquery', 'vendor-highlight', 'vendor-masonry', 'lay-iris', 'vendor-sortable', 'vendor-bootstrap'
			), Setup::$ver, true );

			// use defaults from 'gridder defaults' options
			$rowgutter = get_option( 'gridder_defaults_row_gutter', LayConstants::gridder_defaults_row_gutter );
			$frame = get_option( 'gridder_defaults_frame', LayConstants::gridder_defaults_frame );
			$topframe = get_option( 'gridder_defaults_topframe', LayConstants::gridder_defaults_topframe );
			$bottomframe = get_option( 'gridder_defaults_bottomframe', LayConstants::gridder_defaults_bottomframe );
			$colgutter = get_option( 'gridder_defaults_column_gutter', LayConstants::gridder_defaults_column_gutter );
			$columncount = get_option( 'gridder_defaults_columncount', LayConstants::gridder_defaults_columncount );

			$phone_rowgutter = get_option( 'phone_gridder_defaults_row_gutter', LayConstants::phone_gridder_defaults_row_gutter );
			$phone_frame = get_option( 'phone_gridder_defaults_frame', LayConstants::phone_gridder_defaults_frame );
			$phone_topframe = get_option( 'phone_gridder_defaults_topframe', LayConstants::phone_gridder_defaults_topframe );
			$phone_bottomframe = get_option( 'phone_gridder_defaults_bottomframe', LayConstants::phone_gridder_defaults_bottomframe );
			$phone_colgutter = get_option( 'phone_gridder_defaults_column_gutter', LayConstants::phone_gridder_defaults_column_gutter );
			$phone_columncount = get_option( 'phone_gridder_defaults_columncount', LayConstants::phone_gridder_defaults_columncount );

			$phoneBreakpoint = MiscOptions::$phone_breakpoint;

			$gridder_json = "";
			$phone_gridder_json = "";
			$id = "";

            $post_type = $screen->post_type;
            if( $post_type == 'post' ) {
                $post_type = 'project';
            }
            if( $screen->base == 'term' ) {
                $post_type = 'category';
            }
            
			if( $screen->id == 'post' || $screen->id == "page" ){
				global $post;
				$id = $post->ID;
				$gridder_json = get_post_meta( $id, '_gridder_json' );
				$phone_gridder_json = get_post_meta( $id, '_phone_gridder_json' );
			}
			else if( $screen->id == 'edit-category' ){
				global $tag;
				if( is_object($tag) ){
					$id = $tag->term_id;
					$gridder_json = get_option( $tag->term_id.'_category_gridder_json', '' );
					$phone_gridder_json = get_option( $tag->term_id.'_phone_category_gridder_json', '' );
				}
			}

			$pt_position = get_theme_mod("pt_position", "below-image");
			$pd_position = get_theme_mod("pd_position", "below-image");

			$cover_active_in_projects = get_option( 'cover_active_in_projects', "off" );
			$cover_active_in_pages = get_option( 'cover_active_in_pages', "off" );
			$cover_active_in_categories = get_option( 'cover_active_in_categories', "off" );

			// for an unknown reason in rare cases the arrays are saved as associative arrays, so flatten them here
			$cover_individual_project_ids = CoverOptions::get_individual_project_ids();
			$cover_individual_page_ids = CoverOptions::get_individual_page_ids();
			$cover_individual_category_ids = CoverOptions::get_individual_category_ids();

			$misc_options_cover = get_option('misc_options_cover', '');

			$pt_textformat = get_theme_mod("pt_textformat", "_Default");
			if($pt_textformat != "_Default"){
				$pt_textformat = '_'.$pt_textformat;
			}

			$ptags_textformat = get_theme_mod("ptags_textformat", "_Default");
			if($ptags_textformat != "_Default"){
				$ptags_textformat = '_'.$ptags_textformat;
			}
			
			$cover_disable_for_phone = get_option('cover_disable_for_phone', '');
			$activate_project_description = get_option('misc_options_activate_project_description', '');

			$categories = get_categories(array('hide_empty' => false));
			$categories_for_Select = array();
			foreach ($categories as $term) {
				$categories_for_Select[] = array(
					'label' => $term->name,
					'value' => $term->slug
				);
			}
			$categories_for_Select = json_encode($categories_for_Select);


			$news_categories = get_terms(array(
                'taxonomy'   => 'lay_news_category',
                'hide_empty' => false
            ));

			$bg_color_palette = array('#000', '#fff', '#f00', '#0f0', '#00f', '#ff0', '#0ff', '#f0f');

			$simple_parallax = get_option('misc_options_simple_parallax', '') == 'on' && !MiscOptions::$locked;

			$imageHoverExists = is_plugin_active( 'laytheme-imagehover/laytheme-imagehover.php' ) || class_exists('LayThemeImagehover');
			$fullscreenSlider = is_plugin_active( 'laytheme-magneticslides/laytheme-magneticslides.php' ) || class_exists('LayThemeMagneticSlides');

			$plugins = array(
				'carousel' => is_plugin_active( 'laytheme-carousel/laytheme-carousel.php' ),
				'imageHover' => $imageHoverExists,
                'fullscreenSlider' => $fullscreenSlider,
				'qTranslateX' => is_plugin_active( 'qtranslate-x/qtranslate.php' ) || is_plugin_active('qtranslate-xt-master/qtranslate.php') || class_exists('QTX_Translator'),
			);

			// TODO: move to plugins
			$lightboxActiveHere = false;
			$lightboxActiveForPhone = false;
			if( class_exists('LayThemeLightbox') ){
				$lightboxActiveHere = LayThemeLightbox::is_active_in_current_admin_page();
				$lightboxActiveForPhone = get_option( 'lightbox_activate_on_phone', '' ) == 'on' ? true : false;
			}

			$woocommerce_active = class_exists( 'WooCommerce' );
			$product_tags = $woocommerce_active ? json_encode(Lay_WooCommerce::$product_tags) : '';
			$product_categories = $woocommerce_active ? json_encode(Lay_WooCommerce::$product_categories) : '';

			// $categories_for_sort = array();
			// foreach( $categories as $cat ) {
			// 	$obj = new stdClass();
			// 	$obj->label = $cat->name;
			// 	$obj->value = $cat->slug;
			// 	$categories_for_sort []= $obj;
			// }

			$image_loading = get_option('misc_options_image_loading', 'on');
			if( $image_loading == 'on' ) {
				$image_loading = 'lazy_load';
			} else if ($image_loading == '') {
				$image_loading = 'instant_load';
			}

			$laycarousel_showCaptions = get_option( 'laycarousel_showCaptions', "on" ) == "on" ? true : false;

			$spaces_mu = get_option( 'gridder_spaces_mu', LayConstants::gridder_spaces_mu );
			$offsets_mu = get_option( 'gridder_offsets_mu', LayConstants::gridder_offsets_mu );

            if( MiscOptions::$locked ) {
                $simple_parallax = '';
                $misc_options_cover = '';
                $activate_project_description = '';
            }

            // https://wp-mix.com/wordpress-difference-between-home_url-site_url/
			// need to use get_site_url here instead of get_home_url
			wp_localize_script( 'gridder-app', 'passedData', array(
                'lay_element_layers_window_expanded' => get_option('lay_element_layers_window_expanded', 'true'),
                'lay_element_layers_window_position' => get_option('lay_element_layers_window_position', json_encode(array('x' => 200, 'y' => 300))),
				'spaces_mu' => $spaces_mu,
				'offsets_mu' => $offsets_mu,
				'woocommerce_active' => $woocommerce_active,
				'product_tags' => $product_tags,
				'product_categories' => $product_categories,
				'parallax' => $simple_parallax,
				'pd_position' => $pd_position,
				'pt_position' => $pt_position,
				'gridder_json' => $gridder_json, // TODO: necessary?
				'phone_gridder_json' => $phone_gridder_json, // TODO: necessary?
				'templateURI' => Setup::$uri,
				'siteUrl' => get_site_url(),
				'screenID' => $screen->id,
				'ajaxUrl' => admin_url( 'admin-ajax.php' ) ,
				'id' => $id,
				'screenId' => $screen->id,
				'screenBase' => $screen->base, // TODO: necessary?
				'phoneBreakpoint' => $phoneBreakpoint,
				'cover_active_in_projects' => $cover_active_in_projects,
				'cover_active_in_pages' => $cover_active_in_pages,
				'cover_active_in_categories' => $cover_active_in_categories,
				'cover_individual_project_ids' => $cover_individual_project_ids,
				'cover_individual_page_ids' => $cover_individual_page_ids,
				'cover_individual_category_ids' => $cover_individual_category_ids,
				'cover_disable_for_phone' => $cover_disable_for_phone,
				'misc_options_cover' => $misc_options_cover,
				'pt_textformat' => $pt_textformat,
				'ptags_textformat' => $ptags_textformat,
				'sizes' => Setup::$sizes,
				'activateProjectDescription' => $activate_project_description,
				'categories' => $categories,
                'categories_for_Select' => $categories_for_Select,
                'news_categories' => $news_categories,
				'phoneLayoutActive' => MiscOptions::$phoneLayoutActive,
				'bgColorPalette' => $bg_color_palette,
				'plugins' => $plugins,
				'image_loading' => $image_loading,
				'textformats' => FormatsManager::$customFormats,
				'laycarousel_showCaptions' => $laycarousel_showCaptions,
				'news_active' => Gridder::$active_for_news,
				'gridderDefaults' => array(
					'colCount' => $columncount,
					'colGutter' => $colgutter,
					'colGutterMu' => get_option( 'gridder_defaults_column_gutter_mu', LayConstants::gridder_defaults_column_gutter_mu ),
					'frameMargin' => $frame,
					'leftFrame' => get_option( 'gridder_defaults_frame_left', LayConstants::gridder_defaults_frame_left ),
					'rightFrame' => get_option( 'gridder_defaults_frame_right', LayConstants::gridder_defaults_frame_right ),
					'topFrameMargin' => $topframe,
					'bottomFrameMargin' => $bottomframe,
					'rowGutter' => $rowgutter,
					'rowGutterMu' => Gridder::$rowgutter_mu,
					'topFrameMu' => Gridder::$topframe_mu,
					'frameMu' => Gridder::$frame_mu,
					'bottomFrameMu' => Gridder::$bottomframe_mu,
					'phoneRowGutter' => $phone_rowgutter,
					'phoneFrame' => $phone_frame,
					'phoneLeftFrame' => get_option( 'phone_gridder_defaults_frame_left', LayConstants::phone_gridder_defaults_frame_left ),
					'phoneRightFrame' => get_option( 'phone_gridder_defaults_frame_right', LayConstants::phone_gridder_defaults_frame_right ),
					'phoneTopFrame' => $phone_topframe,
					'phoneBottomFrame' => $phone_bottomframe,
					'phoneColGutter' => $phone_colgutter,
					'phoneColGutterMu' => get_option( 'phone_gridder_defaults_column_gutter_mu', LayConstants::phone_gridder_defaults_column_gutter_mu ),
					'phoneColCount' => $phone_columncount,
					'phoneTopFrameMu' => get_option( 'phone_gridder_defaults_topframe_mu', LayConstants::phone_gridder_defaults_topframe_mu ),
					'phoneBottomFrameMu' => get_option( 'phone_gridder_defaults_bottomframe_mu', LayConstants::phone_gridder_defaults_bottomframe_mu ),
					'phoneRowGutterMu' => Gridder::$phone_rowgutter_mu,
					'phoneFrameMu' => get_option( 'phone_gridder_defaults_frame_mu', LayConstants::phone_gridder_defaults_frame_mu ),
                    'horizontalGridSpaceIn' => get_option('gridder_horizontalgrid_space_in_default', '%'),
                    'horizontalGridSpace' => get_option('gridder_horizontalgrid_space_default', '1'),
				),
				'lightboxActiveHere' => $lightboxActiveHere,
				'lightboxActiveForPhone' => $lightboxActiveForPhone,
				'guidesVisibility' => get_option('lay_guides_visibility', true),
                'connectTopBottomFrame' => get_option('lay_connect_top_bottom_frame', false),
				'connectLeftRightFrame' => get_option('lay_connect_left_right_frame', true),
                'locked' => MiscOptions::$locked,
                'stickytopDefault' => get_option( 'gridder_stickytop_default', 20 ),
                'fullscreenslider_active_here' => class_exists('LayThemeMagneticSlides') && method_exists('LayThemeMagneticSlides', 'isActiveHere') ? LayThemeMagneticSlides::isActiveHere($id, $post_type) : false,
                'fullscreenslider_fit_browser' => get_option( 'ms_fit_browser', '' ),
                'fullscreenslider_fit_browser_maxdim' => get_option( 'ms_fit_browser_maxdim', 90 ),
			) );
		}
	}

}

$gridder = new Gridder();
