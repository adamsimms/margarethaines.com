<?php

class LayNewsElement{

    public $el;
    public $config;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        $this->config = $this->el['config'];
        return LayNews::get_news_feed( $this->config, 'frontend' );
    }

}