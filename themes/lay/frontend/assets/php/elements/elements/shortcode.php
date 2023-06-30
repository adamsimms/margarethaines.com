<?php
// todo: test if shortcode works
class LayShortcode{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        return '<div class="lay-shortcode lay-textformat-parent">'.do_shortcode($this->el['cont']).'</div>';
    }

}