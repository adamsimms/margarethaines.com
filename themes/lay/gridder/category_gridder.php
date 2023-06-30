<?php
// scripts and styles are enqueued in gridder.php
// https://www.dougv.com/2014/06/25/hooking-wordpress-taxonomy-changes-with-the-plugins-api/

class CategoryGridder{

    public function __construct(){
        add_action( "category_edit_form" , array($this, "add_category_gridder"), 10, 2 );
        add_action( "edited_category", array($this, "save_category_gridder_json"), 10, 2 );
        // prevent wp from redirecting to category overview when category layout is saved
        add_action( "category_pre_edit_form" , array($this, "show_updated_message"), 10, 2 );
    }

    public function show_updated_message($tag, $taxonomy){
        if(isset( $_GET['message'])){
            echo
            '<div class="updated">
                <p>Category updated. <a href="'.get_term_link( $tag, $taxonomy ).'">View category</a></p>
            </div>';
        }
    }

    public function save_category_gridder_json($term_id, $tt_id){
        // Check if our nonce is set.
        if ( ! isset( $_POST['category_gridder_json_field_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['category_gridder_json_field_nonce'], 'category_gridder_json_field' ) ) {
            return;
        }

        // save last data
        $value = get_option( $term_id."_category_gridder_json", "" );
				update_option( $term_id."_category_gridder_json_last", $value );

        $value = get_option( $term_id."_phone_category_gridder_json", "" );
				update_option( $term_id."_phone_category_gridder_json_last", $value );

        // udpate "real"
        // $term_id is id of "instance" of taxonomy
        // $tt_id is id of taxonomy, in this case the taxonomy is category
        if ( isset($_POST['category_gridder_json']) ){
						$json = $_POST['category_gridder_json'];
						$json = wp_unslash($json);
						$option_name = $term_id."_category_gridder_json";
            update_option( $option_name, $json );
        }

        if ( isset($_POST['phone_category_gridder_json']) ){
						$json = $_POST['phone_category_gridder_json'];
						$json = wp_unslash($json);
            $option_name = $term_id."_phone_category_gridder_json";
            update_option( $option_name, $json );
        }

    }

    public function add_category_gridder($tag, $taxonomy){
        // $tag Current taxonomy term object.
        // $taxonomy Current taxonomy slug.

        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'category_gridder_json_field', 'category_gridder_json_field_nonce' );

        $term_id = $tag->term_id;
        $json = get_option($term_id."_category_gridder_json", '');
        echo '<textarea name="category_gridder_json" id="gridder_json_field">';
        echo htmlspecialchars($json);
        echo '</textarea>';

        $json = get_option($term_id."_phone_category_gridder_json", '');
        echo '<textarea name="phone_category_gridder_json" id="phone_gridder_json_field">';
        echo htmlspecialchars($json);
        echo '</textarea>';

				require_once( Setup::$dir.'/gridder/markup.php' );
    }

		// TODO: change to json
		// TODO: could be deleted
    public static function get_add_project_modal(){
        $screen = get_current_screen();
        $query;
        $postIDs = array();
        if($screen->id == 'edit-category'){
            $query = new WP_Query( array( 'posts_per_page' => '-1' ) );
        }
        else{
            global $post;
            $currentId = $post->ID;
            $query = new WP_Query( array( 'posts_per_page' => '-1', 'post__not_in' => array( $currentId ) ) );
        }

        if ( $query->have_posts() ) {
            foreach ($query->posts as $post){
                if($post->post_status == "publish"){
                    $postIDs []= $post->ID;
                }
            }
        }

        $postIDsRows = array_chunk($postIDs, 6);
        $result =
        '<div id="add-project-modal" class="lay-input-modal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title js-text-modal-title">Add Project</h3>
                    <button type="button" class="close close-modal-btn"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="panel-body">
                    <div class="container-fluid">';

                    foreach ($postIDsRows as $key => $row){
                        foreach ($row as $key => $postId){
                            $fiID = get_post_thumbnail_id( $postId );
                            $image = wp_get_attachment_image_src( $fiID, '512' );

                            if($image){
                                $fullsize = wp_get_attachment_image_src( $fiID, 'full' );

                                $_265 = wp_get_attachment_image_src( $fiID, '_265' );
                                $_512 = wp_get_attachment_image_src( $fiID, '_512' );
                                $_768 = wp_get_attachment_image_src( $fiID, '_768' );
                                $_1024 = wp_get_attachment_image_src( $fiID, '_1024' );
                                $_1280 = wp_get_attachment_image_src( $fiID, '_1280' );
                                $_1920 = wp_get_attachment_image_src( $fiID, '_1920' );
                                $_2560 = wp_get_attachment_image_src( $fiID, '_2560' );
                                $_3200 = wp_get_attachment_image_src( $fiID, '_3200' );
                                $_3840 = wp_get_attachment_image_src( $fiID, '_3840' );
                                $_4096 = wp_get_attachment_image_src( $fiID, '_4096' );

                                $ar = $fullsize[2] / $fullsize[1];
                                $format = $image[1] > $image[2] ? 'landscape' : 'portrait';
                                $link = get_permalink($postId);
                                $title = get_the_title($postId);

                                $projectDescr = get_post_meta( $postId, 'lay_project_description', true );
                                $projectDescr = htmlentities($projectDescr);

                                $cats = get_the_category($postId);

                                $result .=
                                '<div class="col-sm-2 col-md-2">
                                    <div class="thumbnail" data-descr="'.$projectDescr.'" data-title="'.__($title).'" data-postid="'.$postId.'" data-link="'.$link.'" data-attid="'.$fiID.'" data-ar="'.$ar.'"
                                    data-265='.$_265[0].'
                                    data-512='.$_512[0].'
                                    data-768='.$_768[0].'
                                    data-1024='.$_1024[0].'
                                    data-1280='.$_1280[0].'
                                    data-1920='.$_1920[0].'
                                    data-2560='.$_2560[0].'
                                    data-3200='.$_3200[0].'
                                    data-3840='.$_3840[0].'
                                    data-4096='.$_4096[0].'
                                    data-full="'.$fullsize[0].'">
                                        <div class="center '.$format.'"><img src="'.$_265[0].'"></div>
                                    </div>
                                    <div class="caption">
                                        Title: '.get_the_title($postId).'<br>
                                        Category: '.$cats[0]->name.'
                                    </div>
                                </div>';
                            }
                        }
                    }

        $result .=
                    '</div>
                </div>
                <div class="panel-footer clearfix">
                    <button type="button" disabled="disabled" class="btn btn-default btn-lg add-project-btn">Ok</button>
                </div>
            </div>
            <div class="background"></div>
        </div>';

        return $result;
    }
}

$categorygridder = new CategoryGridder();
