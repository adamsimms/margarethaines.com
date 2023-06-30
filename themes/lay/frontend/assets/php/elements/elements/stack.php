<?php
// todo: code stack
class LayStack{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        return '<div class="column-wrap stack-wrap">stack</div>';
    }

}