<?php

class LayHr{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        return '<div class="lay-hr"></div>';
    }

}