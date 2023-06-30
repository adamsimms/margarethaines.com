<?php
class ProjectThumbnail{

	public static function init() {
		add_action('wp_ajax_get_post_thumbnail_json', 'ProjectThumbnail::get_post_thumbnail_json');
	}

	public static function get_post_thumbnail_json() {
		$projects = array();

		$queryParam = array( 'posts_per_page' => '-1' );
		$currentScreenId = $_GET['screenId'];
		if ($currentScreenId != null && $currentScreenId != 'edit-category') {
			$queryParam['post__not_in'] = array( $_GET['id'] );
		}
		$query = new WP_Query( $queryParam );

		if ( $query->have_posts() ) {
			foreach ($query->posts as $post){
				if ($post->post_status == "publish") {
					$descr = get_post_meta( $post->ID, 'lay_project_description', true );
					$title = get_the_title( $post->ID );
					$link = get_permalink( $post->ID );
					$cats = get_the_category($post->ID);

					$sizes = array();
					$attid = get_post_thumbnail_id( $post->ID );
					$attachment = wp_get_attachment_image_src( $attid, 'full' );
					if($attachment === false){
						continue;
					}
					$sizes['full'] = array(
						'url' => $attachment[0],
						'width' => $attachment[1],
						'height' => $attachment[2],
						'orientation' => $attachment[1] > $attachment[2] ? 'landscape' : 'portrait'
					);
					foreach ( Setup::$sizes as $size ) {
						$attachment = wp_get_attachment_image_src( $attid, $size );
						if ( $attachment[0] == $sizes['full']['url'] ) {
							break;
						}
						$sizes[$size] = array(
							'url' => $attachment[0],
							'width' => $attachment[1],
							'height' => $attachment[2],
							'orientation' => $attachment[1] > $attachment[2] ? 'landscape' : 'portrait'
						);
					}
					$ar = 1;
					if( array_key_exists('full', $sizes) && array_key_exists('width', $sizes['full']) && $sizes['full']['width'] != 0 ) {
						$ar = $sizes['full']['height'] / $sizes['full']['width'];
					}

					$moSizes = '';
					$moW = '';
					$moH = '';
					
					$mo_thumb_id = get_post_meta( $post->ID, '_lay_thumbnail_mouseover_image', true );
					if ( $mo_thumb_id && get_post( $mo_thumb_id ) ) {
						$attachment = wp_get_attachment_image_src( $mo_thumb_id, 'full' );
						$moSizes = array();
						$moSizes['full'] = array(
							'url' => $attachment[0],
							'width' => $attachment[1],
							'height' => $attachment[2],
							'orientation' => $attachment[1] > $attachment[2] ? 'landscape' : 'portrait'
						);
						$moW = $moSizes['full']['width'];
						$moH = $moSizes['full']['height'];
						foreach ( Setup::$sizes as $size ) {
							$attachment = wp_get_attachment_image_src( $mo_thumb_id, $size );
							if ( $attachment[0] == $moSizes['full']['url'] ) {
								break;
							}
							$moSizes[$size] = array(
								'url' => $attachment[0],
								'width' => $attachment[1],
								'height' => $attachment[2],
								'orientation' => $attachment[1] > $attachment[2] ? 'landscape' : 'portrait'
							);
						}
					}

					$videoUrl = '';
					$videoW = '';
					$videoH = '';
					$video_id = get_post_meta( $post->ID, '_lay_thumbnail_video', true );
					if ( $video_id && get_post( $video_id ) ) {
						$videoUrl = wp_get_attachment_url($video_id);
						$video_meta = wp_get_attachment_metadata($video_id);
						$videoW = $video_meta['width'];
						$videoH = $video_meta['height'];
					}

					$tags = get_the_tags($post->ID);
					$tagArray = array();
					if ($tags) {
						// https://stackoverflow.com/questions/2699086/how-to-sort-a-multi-dimensional-array-by-value
						usort($tags, function($a, $b) {
							return $a->term_order - $b->term_order;
						});
						foreach($tags as $tag) {
							// $tagArray []= array('name' => $tag->name, 'id' => $tag->term_id, 'order' => $tag->term_order);
							$tagArray []= $tag->name;
						}
					}

					$projects[] = array(
						'postid' => $post->ID,
						'title' => $title,
						'descr' => $descr,
						'link' => $link,
						'cats' => $cats,
						'attid' => $attid,
						'sizes' => $sizes,
						'ar' => $ar,
						'video_url' => $videoUrl,
						'video_w' => $videoW,
						'video_h' => $videoH,
						'mo_sizes' => $moSizes,
						'mo_w' => $moW,
						'mo_h' => $moH,
						'tags' => $tagArray
					);
				}
			}
		}

		wp_send_json($projects);
		die();
	}
}

ProjectThumbnail::init();