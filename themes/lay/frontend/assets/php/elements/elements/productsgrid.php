<?php

class LayProductsgrid{

    public $el;
    public $config;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        if( class_exists('WooCommerce') ) {
            $this->config = $this->el['config'];
            return Lay_WooCommerce::build_lay_products_markup( $this->config );
        }
        return '';
    }

}