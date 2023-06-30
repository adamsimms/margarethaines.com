<?php

class LayEmbed{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        $markup = "";
        $w = (int)$this->el['w'];
        $h = (int)$this->el['h'];
        $caption = LayElFunctions::getCaptionMarkup($this->el);
        if($w != 0 && $h != 0){
            $pb = $h/$w*100;
            $markup = '<div class="ph" style="padding-bottom:'.Lay_LayoutFunctions::replaceCommaWithDot($pb).'%;" data-embed="'.htmlspecialchars($this->el['cont']).'"></div>'.$caption;
        }else{
            $markup =  '<div data-embed="'.htmlspecialchars($this->el['cont']).'"></div>'.$caption;
        }
        return $markup;
    }

}