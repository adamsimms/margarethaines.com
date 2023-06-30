<?php

class LayTextFooter{

    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        // error_log(print_r($this->el, true));
        $el = $this->el['cont'];
        $content = $el['content'];
        $align = $el['alignment'];
        
        $markup = '<div class="lay-textfooter-inner lay-textformat-parent lay-textfooter-align-'.$align.'">';
        for ($i=0; $i < count($content); $i++) { 
            $item = $content[$i];
            $marginright = $i < count($content) - 1 ? 'margin-right:'.$el['spacebetween'].'px;' : '';
            $marginbottom = 'margin-bottom:'.$el['spacebelow'].'px;';
            $markup .= '<div style="'.$marginright.$marginbottom.'" class="lay-textfooter-item _'.$el['textformat'].'_no_spaces">'.$item['cont'].'</div>';
        }
        $markup .= '</div>';

        return $markup;
    }

}