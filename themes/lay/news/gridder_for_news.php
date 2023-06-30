<?php
class GridderForNews{

    public function __construct(){
        $val = get_option('misc_options_activate_news_feature', '');
		if( $val == "on" && !MiscOptions::$locked ){
            add_action( 'add_meta_boxes', array( $this, 'add_gridder_meta_boxes' ) );
        }
    }

    public function add_gridder_meta_boxes() {
		// desktop gridder json
		add_meta_box( 'gridder-json-metabox', 'Gridder JSON', array( $this, 'gridder_json_metabox_callback'), 'lay_news', 'normal', 'high' );
		// phone gridder json
		add_meta_box( 'gridder-phone-json-metabox', 'Gridder Phone JSON', array( $this, 'gridder_phone_json_metabox_callback'), 'lay_news', 'normal', 'high' );
		add_meta_box( 'gridder-metabox', 'Gridder', array( $this, 'gridder_metabox_callback'), 'lay_news', 'normal', 'high' );
	}

    public function gridder_metabox_callback(){
		require_once( Setup::$dir.'/gridder/markup.php' );
	}

    public function gridder_json_metabox_callback( $post ) {
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

    public function gridder_phone_json_metabox_callback( $post ) {
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


}
new GridderForNews();