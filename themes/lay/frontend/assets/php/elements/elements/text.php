<?php

class LayText{

    public $el;
    public $device;

    public function __construct($el, $device = 'desktop'){
        $this->el = $el;
        $this->device = $device;
    }

    public function getMarkup(){
        $isscrolltotop = array_key_exists('isscrolltotop', $this->el) ? $this->el['isscrolltotop'] : false;
        if( $isscrolltotop == true ) {
            $isscrolltotop = 'scrolltotop';
        } else {
            $isscrolltotop = '';
        }

        $style = '';
        if( array_key_exists('pxwidth', $this->el) && $this->el['pxwidth'] != null ) {
            $style .= '<style>';
            $selector = '#grid';
            if( $this->device == 'phone' ) {
                $selector = '#custom-phone-grid';
            }
            if( array_key_exists('desktop', $this->el['pxwidth']) ){
                $style .= '@media (min-width: '.(LayFrontend_Options::$tablet_breakpoint + 1).'px) { '.$selector.' .text_'.$this->el['relid'].'{width:'.$this->el['pxwidth']['desktop']['val'].$this->el['pxwidth']['desktop']['mu'].';} }';
            }
            if( array_key_exists('tablet', $this->el['pxwidth']) ){
                $style .= '@media (min-width: '.(LayFrontend_Options::$breakpoint + 1).'px) and (max-width: '.LayFrontend_Options::$tablet_breakpoint.'px) { '.$selector.' .text_'.$this->el['relid'].'{width:'.$this->el['pxwidth']['tablet']['val'].$this->el['pxwidth']['tablet']['mu'].';} }';
            }
            if( array_key_exists('phone', $this->el['pxwidth']) ){
                $style .= '@media (max-width: '.(LayFrontend_Options::$breakpoint).'px) { '.$selector.' .text_'.$this->el['relid'].'{width:'.$this->el['pxwidth']['phone']['val'].$this->el['pxwidth']['phone']['mu'].';} }';
            }
            $style .= '</style>';
        }

        $markup = $style;
        $text_class = array_key_exists('relid', $this->el) ? 'text_'.$this->el['relid'] : ''; 
        $markup .= '<div class="text lay-textformat-parent '.$text_class.' '.$isscrolltotop.'">'.$this->el['cont'].'</div>';
        return $markup;
    }

}