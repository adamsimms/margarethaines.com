<?php
class ImageMouseoverThumbnails{

	public static $active;

	public function __construct(){
		$val = get_option('misc_options_thumbnail_mouseover_image', '');
		if( $val == "on" ){
			ImageMouseoverThumbnails::$active = true;
			add_action( 'add_meta_boxes_post', array( $this, 'add_meta_box' ) );
			add_action( 'save_post', array($this, 'save_mouseover_thumb'), 1, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'mo_thumb_script' ) );
			add_action( 'wp_ajax_get_mo_post_thumb_html', array( $this, 'mouseover_post_thumbnail_html_ajax_callback' ) );
		}
		else{
			ImageMouseoverThumbnails::$active = false;
		}
	}

	public function mo_thumb_script() {
		$screen = get_current_screen();
		if ( $screen->id == 'post' ) {
			wp_enqueue_script( 'lay-mo_thumb', Setup::$uri.'/thumbnails/js/image_mouseover_thumbnails.js', array(), Setup::$ver);
		}
	}

	public function save_mouseover_thumb($postid, $post){
		if ( isset( $_POST['_lay_thumbnail_mouseover_image'] ) ) {
			update_post_meta($postid, '_lay_thumbnail_mouseover_image', $_POST['_lay_thumbnail_mouseover_image']);
		}
	}

	public function add_meta_box(){
		add_meta_box( 'lay-thumbnail-mouseover-image', 'Project Thumbnail Mouseover Image', array( $this, 'mo_post_thumbnail_meta_box'), 'post', 'side', 'low' );
	}

	// mostly just copied over from the standard featured image metabox
	// https://github.com/WordPress/WordPress/blob/a7a85856402272b465cde097b725653082db1884/wp-admin/includes/post.php#L1376
	function mo_post_thumbnail_meta_box($post) {
		$thumbnail_id = get_post_meta( $post->ID, '_lay_thumbnail_mouseover_image', true );
		echo ImageMouseoverThumbnails::mouseover_post_thumbnail_html( $thumbnail_id, $post->ID );
	}

	public static function mouseover_post_thumbnail_html_ajax_callback(){
		$post_id = intval( $_POST['post_id'] );
		$thumbnail_id = intval( $_POST['thumbnail_id'] );
		echo ImageMouseoverThumbnails::mouseover_post_thumbnail_html( $thumbnail_id, $post_id );
		wp_die();
	}

	public static function mouseover_post_thumbnail_html( $thumbnail_id = null, $post = null ){
		global $_wp_additional_image_sizes;
		$post               = get_post( $post );
		$post_type_object   = get_post_type_object( $post->post_type );
		$set_thumbnail_link = '<p class="hide-if-no-js"><a href="%s" id="set-mouseover-post-thumbnail"%s class="thickbox">%s</a></p>';
		$upload_iframe_src  = get_upload_iframe_src( 'image', $post->ID );
		$content = sprintf( $set_thumbnail_link,
			esc_url( $upload_iframe_src ),
			'', // Empty when there's no featured image set, `aria-describedby` attribute otherwise.
			'Set mouseover image'
		);
		if ( $thumbnail_id && get_post( $thumbnail_id ) ) {
			$size = isset( $_wp_additional_image_sizes['post-thumbnail'] ) ? 'post-thumbnail' : array( 266, 266 );
			/**
			 * Filters the size used to display the post thumbnail image in the 'Featured Image' meta box.
			 *
			 * Note: When a theme adds 'post-thumbnail' support, a special 'post-thumbnail'
			 * image size is registered, which differs from the 'thumbnail' image size
			 * managed via the Settings > Media screen. See the `$size` parameter description
			 * for more information on default values.
			 *
			 * @since 4.4.0
			 *
			 * @param string|array $size         Post thumbnail image size to display in the meta box. Accepts any valid
			 *                                   image size, or an array of width and height values in pixels (in that order).
			 *                                   If the 'post-thumbnail' size is set, default is 'post-thumbnail'. Otherwise,
			 *                                   default is an array with 266 as both the height and width values.
			 * @param int          $thumbnail_id Post thumbnail attachment ID.
			 * @param WP_Post      $post         The post object associated with the thumbnail.
			 */
			$size = apply_filters( 'admin_post_thumbnail_size', $size, $thumbnail_id, $post );
			$thumbnail_html = wp_get_attachment_image( $thumbnail_id, $size );
			if ( ! empty( $thumbnail_html ) ) {
				$content = sprintf( $set_thumbnail_link,
					esc_url( $upload_iframe_src ),
					' aria-describedby="set-mouseover-post-thumbnail-desc"',
					$thumbnail_html
				);
				$content .= '<p class="hide-if-no-js howto" id="set-mouseover-post-thumbnail-desc">' . __( 'Click the image to edit or update' ) . '</p>';
				$content .= '<p class="hide-if-no-js"><a href="#" id="remove-mouseover-post-thumbnail">' . 'Remove mouseover image' . '</a></p>';
			}
		}
		$content .= '<input type="hidden" id="_lay_thumbnail_mouseover_image" name="_lay_thumbnail_mouseover_image" value="' . esc_attr( $thumbnail_id ? $thumbnail_id : '-1' ) . '" />';
		echo $content;
	}

}
new ImageMouseoverThumbnails();