<?php

class LayHTML{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        return $this->el['cont'];
    }

}