<?php

class LayVl{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        return '<div class="lay-vl"></div>';
    }

}