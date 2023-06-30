<?php
// todo: video thumbnail new
// todo: test mouseover image

class LayThumbnail{

    public $el;
    // todo: remove title only
    public function __construct($el, $title_only = false){
        $this->el = $el;
        $this->title_only = $title_only;
    }

    public function getMarkup(){
        $pb = $this->el['ar'] * 100;
        $markup = '';

        $attid = $this->el['attid'];
        $alt = get_post_meta( $attid, '_wp_attachment_image_alt', true );
        
        $img = LayElFunctions::getLazyImg($this->el);

        $mo_thumb = array_key_exists('mo_sizes', $this->el) ? $this->el['mo_sizes'] : false;
        $mo_thumb_img = "";
        $has_mo_thumb_class = "";

        if( LayFrontend_Options::$misc_options_thumbnail_mouseover_image && is_array($mo_thumb) && !empty($mo_thumb) ){
            // error_log(print_r('bro', true));
            $mo_thumb_img = LayElFunctions::getMouseOverThumbImg($this->el);
            $has_mo_thumb_class = "has-mouseover-img";
        }

        $innerMarkup = $img.$mo_thumb_img;

        // if on touch device and we have "playsinline" support, then show video with playsinline attribute and autoplay
		// otherwise show image
        // playsinline is supported from iOS 10 WebKit and Chrome > 53
        $video_url = array_key_exists('video_url', $this->el) ? $this->el['video_url'] : false;
        if( LayFrontend_Options::$misc_options_thumbnail_video && $video_url != false && $video_url != "") {
            // is touch device and has playsinline support
            if ( LTUtility::$isTouchDevice && LTUtility::$supportsPlaysInlineOnTouchDevice ) {
                $model = array(
                    'autoplay' => true,
                    'loop' => true,
                    'mute' => true,
                    'mp4' => $video_url
                );
                // $innerMarkup = '<video autoplay playsinline loop muted><source src="'.$video_url.'" type="video/mp4"></video>';

                // todo: test this
                $innerMarkup = LayElFunctions::getHTML5VideoMarkupSimple($model);
                $has_mo_thumb_class = "";
                $w = (int)$this->el['video_w'];
                if( $w != 0 ) {
                    $pb = (int)$this->el['video_h'] / $w * 100;
                }
            }
            // is not touch device
            if( !LTUtility::$isTouchDevice ) {
                // when not touchdevice, use mouseover image
                // when the video thumbnail mouseover behaviour is set to only "play_on_mouseover", then don't use a autoplay attribute!
                $autoplay = true;
                if( LayFrontend_Options::$video_thumbnail_mouseover_behaviour == 'play_on_mouseover' ){
                    $autoplay = false;
                }
                $model = array(
                    'autoplay' => $autoplay,
                    'loop' => true,
                    'mute' => true,
                    'mp4' => $video_url
                );
                // todo: test this
                $innerMarkup = LayElFunctions::getHTML5VideoMarkupSimple($model).$mo_thumb_img;
                $w = (int)$this->el['video_w'];
                if( $w != 0 ) {
                    $pb = (int)$this->el['video_h'] / $w * 100;
                }
            }
        }
        // #video thumbnail new

        //project thumbnail
        
        $link = $this->el['link'];
        $link = get_permalink($this->el['postid']);
        
        $title = $this->el['title'];
        $postid = $this->el['postid'];
        $descr = array_key_exists('descr', $this->el) ? $this->el['descr'] : false;
        // sometimes there is an empty p at the start of descr, remove it
        // http://laythemeforum.com:4567/topic/5390/p-p-adds-in-project-description-for-thumbail-when-updating/2
        // <p></p>
        $substr = substr($descr, 0,7);
        if( $substr == '<p></p>' ) {
            $descr = substr($descr,7);
        }

        $tags = get_the_tags($this->el['postid']);
        $tagArray = array();
        if ($tags) {
            usort($tags, function($a, $b) {
                return $a->term_order - $b->term_order;
            });
            foreach($tags as $tag) {
                $tagArray []= $tag->name;
            }
        }
        $tagText = implode(', ', $tagArray);
        $tagMarkup = '';
        if( $tagText != '' ) {
            $tagMarkup = '<span class="thumbnail-tags '.LayFrontend_Options::$ptags_textformat.'">'.$tagText.'</span>';
        }
        // error_log(print_r($tagMarkup, true));

        $cats_wp_terms_array = get_the_category($postid);
        $catids = array();

        for( $i = 0; $i<count($cats_wp_terms_array); $i++ ) {
            $cat = $cats_wp_terms_array[$i];
            $catids []= $cat->term_id;
        }

        $dataAttrs = 'data-id="'.$postid.'" data-catid="'.LayElFunctions::stringifyCatIds($catids).'" data-title="'.__($title).'" data-type="project"';

        $mo_always = "";
        if( LayFrontend_Options::$fi_mo_touchdevice_behaviour == "mo_always" && LTUtility::$isTouchDevice == true ){
            $mo_always = "hover";
        }

        $showDescr = false;
        if( $descr != false && LayFrontend_Options::$activate_project_description && trim($descr) != ""){
            $showDescr = true;
        }

        $pt_position = LayFrontend_Options::$pt_position;
        $pd_position = LayFrontend_Options::$pd_position;

        $title_only_display = ""; // Hide image
        $title_only_inlineblock = ""; // Set thumb container to inline, so the imagehover trigger area ends with the text

        if ( $this->title_only == true ) {
                // Since we don't display an image there is no point to position the text
                $aboveImageTextExists = false;
                $pt_on_image = false;
                $onImageTextExists = false;
                $belowImageTextExists = true;

                $title_only_display = "display: none;";
                $title_only_inlineblock = "display: inline-block";
        } else {
                $aboveImageTextExists = $pt_position == "above-image" || ($pd_position == "above-image" && $showDescr) ? true : false;
        $pt_on_image = strpos($pt_position, 'on-image') === false ? false : true;
        $onImageTextExists = $pt_on_image || ($pd_position == "on-image" && $showDescr) ? true : false;
        $belowImageTextExists = $pt_position == "below-image" || ($pd_position == "below-image" && $showDescr) ? true : false;
        }

        $markup =
        '<a class="thumb '.$mo_always.' '.$has_mo_thumb_class.'" href="'.$link.'" style="'.$title_only_inlineblock.'" '.$dataAttrs.'>';
            if($aboveImageTextExists){
                $markup .= '<div class="lay-textformat-parent above-image">';
                if($pt_position == "above-image"){
                    $markup .= '<span class="title '.LayFrontend_Options::$pt_textformat.'">'.$title.'</span>'.$tagMarkup;
                }
                if($pd_position == "above-image" && $showDescr){
                    $markup .= '<span class="descr">'.$descr.'</span>';
                }
                $markup .= '</div>';
            }
        // open thumb-rel
        $markup .= '<div class="thumb-rel">';
        if( $onImageTextExists ){
            $markup .= '<div class="lay-textformat-parent titlewrap-on-image">';
            if( $pt_on_image ){
                $markup .= '<span class="title '.LayFrontend_Options::$pt_textformat.'">'.$title.'</span>'.$tagMarkup;
            }
            if( $pd_position == "on-image" && $showDescr){
                $markup .= '<span class="descr">'.$descr.'</span>';
            }
            $markup .= '</div>';
        }

        //empty span for bgcolor
        $markup .=
				'<div class="ph" style="padding-bottom:'.Lay_LayoutFunctions::replaceCommaWithDot($pb).'%; '.$title_only_display.'">'
            .$innerMarkup
            .'<span></span>'
        .'</div>'
        .'</div>'; //close thumb rel
        if( $belowImageTextExists ) {
            $markup .=
            '<div class="lay-textformat-parent below-image">';
            if( $pt_position == "below-image" || $this->title_only ) {
                $markup .= '<span class="title '.LayFrontend_Options::$pt_textformat.'">'.$title.'</span>'.$tagMarkup;
            }
            if( ($pd_position == "below-image" || $this->title_only) && $showDescr ){
                $markup .= '<span class="descr">'.$descr.'</span>';
            }
            $markup .= '</div>';
        }
        $markup .= '</a>';
        $display_style = array_key_exists('display', $this->el) && $this->el['display'] == false ? 'style="display:none;"' : '';
        $filter_id_attr = array_key_exists('filter_id', $this->el) ? 'data-filterid="'.$this->el['filter_id'].'"' : '';

        $tagArray_ids = array();
        if ($tags) {
            usort($tags, function($a, $b) {
                return $a->term_order - $b->term_order;
            });
            foreach($tags as $tag) {
                $tagArray_ids []= $tag->term_id;
            }
        }

        $classes = array_key_exists('classes', $this->el) ? $this->el['classes'] : '';

        return '<div class="thumbnail-wrap '.$classes.'" data-tags="['.implode(',',$tagArray_ids).']" '.$display_style.' '.$filter_id_attr.'>'.$markup.'</div>';
    }
}