<?php

class LayCarousel{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        if( method_exists('LayCarouselPluginFrontend', 'getMarkup') ) {
            return LayCarouselPluginFrontend::getMarkup($this->el);
        }
    }

}