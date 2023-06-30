<?php

class LayElementGrid{

    public $el;
    public $config;
    public $elements;
    public $device;

    public function __construct($el, $device = 'desktop'){
        // error_log(print_r($el, true));
        $this->el = $el;
        $this->device = $device;
    }

    public function getMarkup(){
        $this->config = $this->el['config'];
        $this->elements = $this->config['elements'];
        $markup = '';
        $device = $this->device;

        foreach( $this->elements as $el ) {
            $caption = '';
            switch( $el['type'] ) {
                case 'img':
                case 'html5video':
                    $el['captionMarkup'] = LayElFunctions::getCaptionMarkup($this->el);
            }
            $element = false;
            switch( $el['type'] ) {
                case "postThumbnail":
                    $element = new LayThumbnail($el);
                break;
                case "text":
                    $element = new LayText($el, $device);
                break;
                case "img":
                    $el['lightboxoff'] = array_key_exists('lightboxoff', $this->el) ? $this->el['lightboxoff'] : false;
                    $element = new LayImg($el);
                break;
                case "html5video":
                    $element = new LayHTML5Video($el);
                break;
            }
            if( $element ) {
                $markup .= 
                '<div class="element-wrap">'
                    .$element->getMarkup().
                '</div>';
            }
        }

        unset( $this->config['elements'] );

        $caption = LayElFunctions::getCaptionMarkup($this->el);
        return 
        '<div>
            <div class="elements-collection-region" data-config="'.htmlspecialchars(json_encode($this->config)).'">
                <div class="element-collection">'
                    .$markup.
                '</div>
            </div>
            '.$caption.'
        </div>';
    }

}