<?php
class VideoThumbnails{

	public static $active;

	public function __construct(){
		$val = get_option('misc_options_thumbnail_video', '');
		if( $val == "on" ){
			VideoThumbnails::$active = true;
			add_action( 'add_meta_boxes_post', array( $this, 'add_meta_box' ) );
			add_action( 'save_post', array($this, 'save_video_thumb'), 1, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'video_thumb_script' ) );
			add_action( 'wp_ajax_get_video_post_thumb_html', array( $this, 'video_thumbnail_html_ajax_callback' ) );
		}
		else{
			VideoThumbnails::$active = false;
		}
	}

	public function video_thumb_script() {
		$screen = get_current_screen();
		if ( $screen->id == 'post' ) {
			wp_enqueue_script( 'lay-video_thumb', Setup::$uri.'/thumbnails/js/video_thumbnails.js', array(), Setup::$ver);
		}
	}

	public function save_video_thumb($postid, $post){
		if ( isset( $_POST['_lay_thumbnail_video'] ) ) {
			update_post_meta($postid, '_lay_thumbnail_video', $_POST['_lay_thumbnail_video']);
		}
	}

	public function add_meta_box(){
		add_meta_box( 'lay-video-thumbnail', 'Project Thumbnail Video', array( $this, 'video_thumbnail_meta_box'), 'post', 'side', 'low' );
	}

	// mostly just copied over from the standard featured image metabox
	// https://github.com/WordPress/WordPress/blob/a7a85856402272b465cde097b725653082db1884/wp-admin/includes/post.php#L1376
	function video_thumbnail_meta_box($post) {
		$thumbnail_id = get_post_meta( $post->ID, '_lay_thumbnail_video', true );
		echo VideoThumbnails::video_thumbnail_html( $thumbnail_id, $post->ID );
	}

	public static function video_thumbnail_html_ajax_callback(){
		$post_id = intval( $_POST['post_id'] );
		$thumbnail_id = intval( $_POST['thumbnail_id'] );
		echo VideoThumbnails::video_thumbnail_html( $thumbnail_id, $post_id );
		wp_die();
	}

	public static function video_thumbnail_html( $thumbnail_id = null, $post = null ){
		$post               = get_post( $post );
		$post_type_object   = get_post_type_object( $post->post_type );
		$set_thumbnail_link = '<p class="hide-if-no-js"><a href="%s" id="set-video-post-thumbnail"%s class="thickbox">%s</a></p>';
		$upload_iframe_src  = get_upload_iframe_src( 'video', $post->ID );
		$content = sprintf( $set_thumbnail_link,
			esc_url( $upload_iframe_src ),
			'', // Empty when there's no featured image set, `aria-describedby` attribute otherwise.
			'Set a .mp4 video'
		);
		if ( $thumbnail_id && get_post( $thumbnail_id ) ) {
			$video = wp_get_attachment_url($thumbnail_id);
			$thumbnail_html = '<video loop autoplay muted><source src="'.$video.'" type="video/mp4"></video>';
			if ( ! empty( $thumbnail_html ) ) {
				$content = sprintf( $set_thumbnail_link,
					esc_url( $upload_iframe_src ),
					' aria-describedby="set-video-post-thumbnail-desc"',
					$thumbnail_html
				);
				$content .= '<p class="hide-if-no-js howto" id="set-video-post-thumbnail-desc">' . __( 'Click the video to edit or update' ) . '</p>';
				$content .= '<p class="hide-if-no-js"><a href="#" id="remove-video-post-thumbnail">' . 'Remove video' . '</a></p>';
			}
		}
		$content .= '<input type="hidden" id="_lay_thumbnail_video" name="_lay_thumbnail_video" value="' . esc_attr( $thumbnail_id ? $thumbnail_id : '-1' ) . '" />';
		echo $content;
	}

}
new VideoThumbnails();