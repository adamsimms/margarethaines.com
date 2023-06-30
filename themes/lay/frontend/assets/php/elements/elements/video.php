<?php
class LayVideo{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        $caption = LayElFunctions::getCaptionMarkup($this->el);
        // make src to data-src
        $iframe = $this->el['iframe'];
        $iframe = str_replace( 'src="', 'data-src="', $iframe );
        $pb =  $this->el['ar'] * 100;
        $pb_str = Lay_LayoutFunctions::replaceCommaWithDot($pb);
        return 
        '<div class="video">
            <div class="ph" style="padding-bottom:'.$pb_str.'%;">
                '.$iframe.'
            </div>
            '.$caption.'
        </div>';
    }

}