<?php

class LayProjectIndex{

    public $el;
    public $config;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        $this->config = $this->el['config'];
        return ProjectIndex::get_projectindex( $this->config, 'desktop', $this->el['relid'] );
        return '';
    }

}