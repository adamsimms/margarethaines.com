<?php

// todo: css, html5video with placeholder image, image has transition transform and moves around on init of page

class LayHTML5Video{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        $caption = LayElFunctions::getCaptionMarkup($this->el);

        $show_placeholder_image = $this->el['cont'] == '' ? false : true;
        // no need to show placeholder image when autoplay is true
        if( $this->el['autoplay'] == true ) {
            $show_placeholder_image = false;
        }
        $nolazyload = false;
        if( Setup::$is_firefox == true && LayFrontend_Options::$enable_video_lazyloading_for_firefox == false ) {
            $nolazyload = true;
        }

        $videoConfig = array(
            'model' => $this->el,
            'captionMarkup' => $caption,
            'showPlaceholderImage' => $show_placeholder_image,
            'usePaddingPlaceholder' => true,
            'classPrefix' => '',
            'noLazyLoad' => $nolazyload
        );
        $markup = LayElFunctions::getHTML5VideoMarkup($videoConfig);
        return $markup;
    }

}