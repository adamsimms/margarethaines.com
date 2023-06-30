<?php
// todo: caption
class LayImg{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){

        $pb = $this->el['ar'] * 100;
        $markup = '';

        $attid = $this->el['attid'];

        $img = LayElFunctions::getLazyImg($this->el);
        $is_png_or_gif = strpos($this->el['cont'], '.png') !== false || strpos($this->el['cont'], '.gif') !== false;
        $markup .= $img;

        $lightboxoff = array_key_exists('lightboxoff', $this->el) && $this->el['lightboxoff'] == true ? 'lightboxoff' : '';
        $openingAnchor = '';
        $endingAnchor = '';

        $imageLink = array_key_exists('imagelink', $this->el) ? $this->el['imagelink'] : false;
        if( $imageLink != false ){
            $lightboxoff = 'lightboxoff';
            if( is_array($imageLink) ) {
                $linkUrl = LTUtility::getFullURL($imageLink['url']);
                // is this not a link to an internal page / category / post?
                if( $imageLink['type'] == '' ) {
                    // need to use the real URL and not change it through "LTUtility::getFullURL"
                    $linkUrl = $imageLink['url'];
                }
                if( $imageLink['type'] != '' && $imageLink['id'] != 'null' && $imageLink['id'] != '' ) {
                    // need to do this so link will be updated with qtranslate!
                    $linkUrl = get_permalink($imageLink['id']);
                }
                $openingAnchor = '<a href="'.$linkUrl.'"';
                if($imageLink['newtab'] == true){
                    $openingAnchor .= ' target="_blank"';
                } else {
                    if( $imageLink['id'] != '' ) {
                        $openingAnchor .= ' data-id="'.$imageLink['id'].'"';
                    }
                    if( $imageLink['type'] != '' ) {
                        $openingAnchor .= ' data-type="'.$imageLink['type'].'"';
                    }
                    if( $imageLink['title'] != '' ) {
                        $openingAnchor .= ' data-title="'.__($imageLink['title']).'"';
                    }
                    if( array_key_exists('catid', $imageLink) && $imageLink['catid'] != '' ) {
                        $openingAnchor .= ' data-catid="'.LayElFunctions::stringifyCatIds($imageLink['catid']).'"';
                    }
                }
            } else {
                // for backwards compatibility
                $newtab = array_key_exists('newtab', $this->el) ? $this->el['newtbab'] : false;
                $openingAnchor = '<a href="'.LTUtility::getFullURL($imageLink).'"'; 
                if( $newtab == true ) {
                    $openingAnchor .= ' target="_blank"';
                }
            }
            $openingAnchor .= '>';
            $endingAnchor = '</a>';
        }

        $isscrolltotop = array_key_exists( 'isscrolltotop', $this->el ) ? $this->el['isscrolltotop'] : false;
        if( $isscrolltotop == true ) {
            $isscrolltotop = 'scrolltotop';
        } else {
            $isscrolltotop = '';
        }
        $lightbox_caption = array_key_exists('lightbox_caption', $this->el) ? $this->el['lightbox_caption'] : '';
        if( $lightbox_caption == '' ) {
            switch( LayFrontend_Options::$lightbox_default_caption ) {
                case 'caption':
                    $lightbox_caption = wp_get_attachment_caption($attid);
                    if( $lightbox_caption != '' ) {
                        $lightbox_caption = '<p class="_'.LayFrontend_Options::$lightbox_captionTextformat.'_no_spaces">'.$lightbox_caption.'</p>';
                    }
                break;
                case 'title':
                    $lightbox_caption = get_the_title($attid);
                    if( $lightbox_caption != '' ) {
                        $lightbox_caption = '<p class="_'.LayFrontend_Options::$lightbox_captionTextformat.'_no_spaces">'.$lightbox_caption.'</p>';
                    }
                break;
            }
        }
        $lightbox_caption_attr = $lightbox_caption != '' ? 'data-lightbox-caption="'.htmlspecialchars( $lightbox_caption ).'"' : '';

        $extra_class = $is_png_or_gif ? 'image-transparent-bg' : '';

        $caption = LayElFunctions::getCaptionMarkup($this->el);
        $return = '<div class="img '.$extra_class.' '.$lightboxoff.' '.$isscrolltotop.'" data-id='.$attid.' '.$lightbox_caption_attr.'>'.$openingAnchor.$markup.$endingAnchor.'<div class="ph" style="padding-bottom:'.Lay_LayoutFunctions::replaceCommaWithDot($pb).'%;"></div>'.$caption.'</div>';
        return $return;
    }

}