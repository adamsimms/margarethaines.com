<?php
class Projectdescription{

	public static $active;
	public static $tinymceSettings;

	public function __construct(){
		Projectdescription::$tinymceSettings = array(
			'media_buttons' => false,
			'quicktags' => false,
			'tinymce' => array(
				'toolbar1' => 'undo, redo, fontselect, fontsizeselect, lineheightselect, letterspacingselect, table, styleselect, laynightmode',
				'toolbar2' => 'forecolor, bold, italic, underline, alignleft, aligncenter, alignright, removeformat, charmap, nonbreaking, softhyphen, visualblocks, code',
				'toolbar3' => '',
				'toolbar4' => '',
			)
		);

		$val = get_option('misc_options_activate_project_description', '');
		if( $val == "on" && !MiscOptions::$locked ){
			Projectdescription::$active = true;
			add_action( 'add_meta_boxes_post', array( $this, 'add_project_description_meta_box' ) );
			add_action( 'save_post', array($this, 'save_project_description'), 1, 2 );
		}
		else{
			Projectdescription::$active = false;
		}
	}

	public function save_project_description($postid, $post){
		if ( isset( $_POST['lay_project_description'] ) ) {
			$value = wpautop($_POST['lay_project_description']);		
			update_post_meta($postid, 'lay_project_description', $value);
		}
	}

	public function add_project_description_meta_box(){
		add_meta_box( 'lay-project-description', 'Project Description for Thumbnail', array( $this, 'lay_project_description_metabox_callback'), 'post', 'normal', 'high' );
	}

	public function lay_project_description_metabox_callback($post){
		$content = get_post_meta( $post->ID, 'lay_project_description', true );
		wp_editor( $content, "lay_project_description", Projectdescription::$tinymceSettings );
	}

}
new Projectdescription();