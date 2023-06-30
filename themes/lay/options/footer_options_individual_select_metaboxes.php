<?php
// this class provides the select metaboxes if these options are on:
// Show a select in the Project/Page/Category Edit Screen to activate Footers for individual Projects/Pages/Categories

class FooterIndividualSelectMetaboxes{

	public function __construct(){
		$projectsVal = get_option( 'lay_footer_active_in_projects', "off" );
		if($projectsVal == "individual"){
			add_action( 'add_meta_boxes_post', array($this, 'add_activate_individually_for_projects') );
			add_action( 'save_post', array( $this, 'save_post' ) );
		}

		$pagesVal = get_option( 'lay_footer_active_in_pages', "off" );
		if($pagesVal == "individual"){
			add_action( 'add_meta_boxes_page', array($this, 'add_activate_individually_for_pages') );
			add_action( 'save_post', array( $this, 'save_page' ) );
		}

		$newsVal = get_option( 'lay_footer_active_in_news', "off" );
		if($newsVal == "individual"){
			add_action( 'add_meta_boxes_lay_news', array($this, 'add_activate_individually_for_news') );
			add_action( 'save_post', array( $this, 'save_news' ) );
		}
		
		$catsVal = get_option( 'lay_footer_active_in_categories', "off" );
		if($catsVal == "individual"){
			add_action( "category_edit_form" , array($this, "add_activate_individually_for_categories"), 10, 2 );
			add_action( "edited_category", array($this, "save_category"), 10, 2 );
		}
	}

	public function add_activate_individually_for_categories($tag, $taxonomy){
		$term_id = $tag->term_id;

		wp_nonce_field( 'lay_footer_individual', 'lay_footer_individual_nonce' );
		
		$footers = get_option('lay_individual_category_footers', '');
		$footer_id = "";

		if($footers != ""){
			$array = json_decode($footers, true);
			if(array_key_exists($term_id, $array)){
				$footer_id = $array[$term_id];
			}
		}

		echo
		'<table class="form-table" style="margin-top:0;">
			<tbody>
				<tr class="form-field">
					<th scope="row">Footer</th>
					<td>';

		// Display the form
		echo '<label for="lay_footer_id">Choose a Page as a Footer:</label><br>';
		echo '<select id="lay_footer_id" name="lay_footer_id">';

		$select = $footer_id == '' ? 'selected' : '';
		echo '<option value="" '.$select.'>--SELECT--</value>';
		foreach (FooterOptions::$pagesArray as $key => $value) {
			$select = $footer_id == $value[1] ? 'selected' : '';
			echo '<option value="'.$value[1].'" '.$select.'>'.$value[0].'</option>';
		}
		echo '</select>';

		echo	
					'</td>
				</tr>
			</tbody>
		</table>';
	}

	public function add_activate_individually_for_projects(){
		add_meta_box( 'lay_footer_for_project', 'Footer', array($this, 'render_meta_box'), 'post', 'side', 'default', array('metabox_location'=>'post') );
	}

	public function add_activate_individually_for_pages(){
		add_meta_box( 'lay_footer_for_page', 'Footer', array($this, 'render_meta_box'), 'page', 'side', 'default', array('metabox_location'=>'page') );
	}

	public function add_activate_individually_for_news(){
		add_meta_box( 'lay_footer_for_news', 'Footer', array($this, 'render_meta_box'), 'lay_news', 'side', 'default', array('metabox_location'=>'lay_news') );
	}

	public function render_meta_box( $post, $metabox ) {
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'lay_footer_individual', 'lay_footer_individual_nonce' );

		$footers = "";

		if( $metabox['args']['metabox_location'] == 'post' ){
			$footers = get_option('lay_individual_project_footers', '');
		} else if( $metabox['args']['metabox_location'] == 'lay_news' ){
			$footers = get_option('lay_individual_news_footers', '');
		}
		else{
			//page
			$footers = get_option('lay_individual_page_footers', '');
		}

		$footer_id = "";

		if($footers != ""){
			$array = json_decode($footers, true);
			if(array_key_exists($post->ID, $array)){
				$footer_id = $array[$post->ID];
			}
		}

		// Display the form
		echo '<label for="lay_footer_id">Choose a Page as a Footer:</label><br>';
		echo '<select id="lay_footer_id" name="lay_footer_id">';

		$select = $footer_id == '' ? 'selected' : '';
		echo '<option value="" '.$select.'>--SELECT--</value>';
		foreach (FooterOptions::$pagesArray as $key => $value) {
			$select = $footer_id == $value[1] ? 'selected' : '';
			echo '<option value="'.$value[1].'" '.$select.'>'.$value[0].'</option>';
		}
		echo '</select>';
	}

	public function save_page( $post_id ) {
		$post_id = (int)$post_id;

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['lay_footer_individual_nonce'] ) )
			return $post_id;

		$nonce = $_POST['lay_footer_individual_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'lay_footer_individual' ) )
			return $post_id;

		if ( ! isset( $_POST['lay_footer_id'] ) )
			return;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		}

		/* OK, its safe for us to save the data now. */
		$array = array();
		$footer_id = $_POST['lay_footer_id'];

		$value = get_option('lay_individual_page_footers', '');
		if($value != ""){
			$array = json_decode($value, true);
			$array[$post_id] = $footer_id;
		}
		else{
			$array[$post_id] = $footer_id;
		}

		$array = json_encode($array);

		update_option('lay_individual_page_footers', $array);
	}

	public function save_news( $post_id ) {
		$post_id = (int)$post_id;

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['lay_footer_individual_nonce'] ) )
			return $post_id;

		$nonce = $_POST['lay_footer_individual_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'lay_footer_individual' ) )
			return $post_id;

		if ( ! isset( $_POST['lay_footer_id'] ) )
			return;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'lay_news' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		}

		/* OK, its safe for us to save the data now. */
		$array = array();
		$footer_id = $_POST['lay_footer_id'];

		$value = get_option('lay_individual_page_footers', '');
		if($value != ""){
			$array = json_decode($value, true);
			$array[$post_id] = $footer_id;
		}
		else{
			$array[$post_id] = $footer_id;
		}

		$array = json_encode($array);

		update_option('lay_individual_news_footers', $array);
	}

	public function save_post( $post_id ) {
		$post_id = (int)$post_id;

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['lay_footer_individual_nonce'] ) )
			return $post_id;

		$nonce = $_POST['lay_footer_individual_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'lay_footer_individual' ) )
			return $post_id;

		if ( ! isset( $_POST['lay_footer_id'] ) )
			return;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'post' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
	
		}

		/* OK, its safe for us to save the data now. */
		$array = array();
		$footer_id = $_POST['lay_footer_id'];

		$value = get_option('lay_individual_project_footers', '');
		if($value != ""){
			$array = json_decode($value, true);
			$array[$post_id] = $footer_id;
		}
		else{
			$array[$post_id] = $footer_id;
		}

		$array = json_encode($array);

		update_option('lay_individual_project_footers', $array);
	}	

	public function save_category($term_id, $tt_id){
		$term_id = (int)$term_id;

		if ( ! isset( $_POST['lay_footer_individual_nonce'] ) )
			return;

		$nonce = $_POST['lay_footer_individual_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'lay_footer_individual' ) )
			return;

		if ( ! isset( $_POST['lay_footer_id'] ) )
			return;

		/* OK, its safe for us to save the data now. */
		$array = array();
		$footer_id = $_POST['lay_footer_id'];

		$value = get_option('lay_individual_category_footers', '');
		if($value != ""){
			$array = json_decode($value, true);
			$array[$term_id] = $footer_id;
		}
		else{
			$array[$term_id] = $footer_id;
		}

		$array = json_encode($array);

		update_option('lay_individual_category_footers', $array);
	}
}
new FooterIndividualSelectMetaboxes();