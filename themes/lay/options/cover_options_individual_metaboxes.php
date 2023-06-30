<?php
// this class provides the checkbox metaboxes if these options are on:
// Show a checkbox in the Project/Page Edit Screen to activate cover for individual Projects/Pages

class CoverIndividualMetaboxes{

	public function __construct(){

		$val = get_option('misc_options_cover', '');
		if($val == "on" && !MiscOptions::$locked){	
			$projectsVal = get_option( 'cover_active_in_projects', "" );
			if($projectsVal == "individual"){
				add_action( 'add_meta_boxes_post', array($this, 'add_activate_individually_for_projects') );
				add_action( 'save_post', array( $this, 'save_post' ) );
			}

			$pagesVal = get_option( 'cover_active_in_pages', "" );
			if($pagesVal == "individual"){
				add_action( 'add_meta_boxes_page', array($this, 'add_activate_individually_for_pages') );
				add_action( 'save_post', array( $this, 'save_page' ) );
			}

			$catsVal = get_option( 'cover_active_in_categories', "" );
			if($catsVal == "individual"){
				add_action( "category_edit_form" , array($this, "add_activate_individually_for_categories"), 7, 2 );
				add_action( "edited_category", array($this, "save_category"), 10, 2 );
			}
		}
		
	}

	public function add_activate_individually_for_projects(){
		add_meta_box( 'cover_active_for_project', 'Cover', array($this, 'render_meta_box'), 'post', 'side', 'high', array('metabox_location'=>'post') );
	}

	public function add_activate_individually_for_pages(){
		add_meta_box( 'cover_active_for_page', 'Cover', array($this, 'render_meta_box'), 'page', 'side', 'high', array('metabox_location'=>'page') );
	}

	public function add_activate_individually_for_categories($tag, $taxonomy){
		$term_id = $tag->term_id;

		wp_nonce_field( 'cover_individual', 'cover_individual_nonce' );
		$isActive = false;
		$value = get_option('cover_individual_category_ids', '');	
		if($value != ""){
			$jsonArr = json_decode($value, true);
			if( in_array($term_id, $jsonArr) ){
				$isActive = true;
			}
		}
		$checked = $isActive ? "checked" : "";
		// Display the form, using the current value.
		echo
		'<table class="form-table" style="margin-top:0;">
			<tbody>
				<tr class="form-field">
					<th scope="row">Cover</th>
					<td>
						<input type="checkbox" id="cover_individual_is_active" name="cover_individual_is_active" value="on" '.$checked.'><label for="cover_individual_is_active">Enable Cover for this Category</label>
					</td>
				</tr>
			</tbody>
		</table>';
	}

	public function save_category($term_id, $tt_id){
		$term_id = (int)$term_id;

		if ( ! isset( $_POST['cover_individual_nonce'] ) )
			return;

		$nonce = $_POST['cover_individual_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'cover_individual' ) )
			return;

		$isActive = isset($_POST['cover_individual_is_active']) ? $_POST['cover_individual_is_active'] : '';
		$value = "";
		$jsonArr = array();

		$value = get_option('cover_individual_category_ids', '');

		if($value != ""){
			$jsonArr = json_decode($value, true);
			$key = array_search($term_id, $jsonArr);

			if( $key !== false && $isActive != "on" ){
				// remove post id from json
				unset($jsonArr[$key]);
			}
			else if( $isActive == "on" && !in_array($term_id, $jsonArr) ){
				// insert post id to json
				$jsonArr []= $term_id;
			}
		}
		else{
			if($isActive == "on"){
				$jsonArr []= $term_id;
			}
		}

		// Update the option
		update_option('cover_individual_category_ids', json_encode($jsonArr));
	}

	public function render_meta_box( $post, $metabox ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'cover_individual', 'cover_individual_nonce' );

		$isActive = false;
		$value = "";
		$type = "Project";

		if( $metabox['args']['metabox_location'] == 'post' ){
			$value = get_option('cover_individual_project_ids', '');
		}
		else{
			$value = get_option('cover_individual_page_ids', '');
			$type = 'Page';
		}

		if($value != ""){
			$jsonArr = json_decode($value, true);
			if( in_array($post->ID, $jsonArr) ){
				$isActive = true;
			}
		}
		$checked = $isActive ? "checked" : "";
		// Display the form, using the current value.
		echo '<input type="checkbox" id="cover_individual_is_active" name="cover_individual_is_active" value="on" '.$checked.'><label for="cover_individual_is_active">Enable Cover here</label>';
	}

	public function save_post( $post_id ) {
		$post_id = (int)$post_id;
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['cover_individual_nonce'] ) )
			return $post_id;

		$nonce = $_POST['cover_individual_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'cover_individual' ) )
			return $post_id;

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

		// Sanitize the user input.
		$isActive = isset($_POST['cover_individual_is_active']) ? $_POST['cover_individual_is_active'] : '';
		$value = "";
		$jsonArr = array();

		$value = get_option('cover_individual_project_ids', '');				

		if($value != ""){
			$jsonArr = json_decode($value, true);
			$key = array_search($post_id, $jsonArr);

			if( $key !== false && $isActive != "on" ){
				// remove post id from json
				unset($jsonArr[$key]);
			}
			else if( $isActive == "on" && !in_array($post_id, $jsonArr) ){
				// insert post id to json
				$jsonArr []= $post_id;
			}
		}
		else{
			if($isActive == "on"){
				$jsonArr []= $post_id;
			}
		}

		// Update the option
		update_option('cover_individual_project_ids', json_encode($jsonArr));
	}

	public function save_page( $post_id ) {
		$post_id = (int)$post_id;
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['cover_individual_nonce'] ) )
			return $post_id;

		$nonce = $_POST['cover_individual_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'cover_individual' ) )
			return $post_id;

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

		// Sanitize the user input.
		$isActive = isset($_POST['cover_individual_is_active']) ? $_POST['cover_individual_is_active'] : '';
		$value = "";
		$jsonArr = array();

		$value = get_option('cover_individual_page_ids', '');

		if($value != ""){
			$jsonArr = json_decode($value, true);
			$key = array_search($post_id, $jsonArr);

			if( $key !== false && $isActive != "on" ){
				// remove post id from json
				unset($jsonArr[$key]);
			}
			else if( $isActive == "on" && !in_array($post_id, $jsonArr) ){
				// insert post id to json
				$jsonArr []= $post_id;
			}
		}
		else{
			if($isActive == "on"){
				$jsonArr []= $post_id;
			}
		}

		// Update the option
		update_option('cover_individual_page_ids', json_encode($jsonArr));

	}
}
new CoverIndividualMetaboxes();