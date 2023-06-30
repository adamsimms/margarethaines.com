<?php
class LayCol{

    public $col_classes = 'col';
    public $col_id = '';
    public $type = '';
    public $inline_css = '';
    public $yvel = '';
    public $offset_data_attrs = '';
    public $data_attrs = '';

    public function __construct($col, $inside100vhRow = false){
        // CSS
        $hasInlineCSS = false;
        $css = '';
        $spaceabove = array_key_exists( 'spaceabove', $col ) ? $col['spaceabove'] : 0;
        $spacebelow = array_key_exists( 'spacebelow', $col ) ? $col['spacebelow'] : 0;
        $offsetx = array_key_exists('offsetx', $col) ? $col['offsetx'] : 0;
        $offsety = array_key_exists('offsety', $col) ? $col['offsety'] : 0;
        $absolute_position = array_key_exists('absolute_position', $col) ? $col['absolute_position'] : false;
        $place_at_end_of_col = array_key_exists('placeAtEndOfCol', $col) ? $col['placeAtEndOfCol'] : false;

        $spaceaboveMu = array_key_exists('spaceaboveMu', $col ) ? $col['spaceaboveMu'] : LayFrontend_Options::$spaces_mu;
        $spacebelowMu = array_key_exists('spacebelowMu', $col ) ? $col['spacebelowMu'] : LayFrontend_Options::$spaces_mu;
        $offsetxMu = array_key_exists('offsetxMu', $col ) ? $col['offsetxMu'] : LayFrontend_Options::$offsets_mu;
        $offsetyMu = array_key_exists('offsetyMu', $col ) ? $col['offsetyMu'] : LayFrontend_Options::$offsets_mu;

        if( $offsetx == 0 && $offsety == 0 ){
            $this->col_classes .= ' no-offset';
        }else{
            $this->col_classes .= ' has-offset';
        }

        if( $spaceabove != 0 ) {
            $css .= 'padding-top: '.$spaceabove.$spaceaboveMu.';';
            $hasInlineCSS = true;
        }
        if( $spacebelow != 0 ) {
            $css .= 'padding-bottom: '.$spacebelow.$spacebelowMu.';';
            $hasInlineCSS = true;
        }
        if( $offsetx != 0 || $offsety != 0 ) {
            $this->offset_data_attrs .= ' data-offsetx="'.$offsetx.'" data-offsetxmu='.$offsetxMu.' data-offsety="'.$offsety.'" data-offsetymu='.$offsetyMu.'';
            $y_offset_markup = $offsety.$offsetyMu;
            // dont need this anymore :)

            // if this is a html or text element in a 100vh row and is align middle, we need to to calc( -50% - offsety )
            // if( $inside100vhRow == true && ( $col['type'] == 'text' || $col['type'] == 'html' || $absolute_position ) && $col['align'] == 'middle' ) {
            //     $operator = '+';
            //     if( substr($offsety, 0, 1) == '-' ) {
            //         $operator = '-';
            //         $y_offset_markup = substr($offsety, 1).LayFrontend_Options::$offsets_mu;
            //     }
            //     $y_offset_markup = 'calc( -50% '.$operator.' '.$y_offset_markup.' )';
            // }
            // error_log(print_r($col, true));
            $css .= 'transform:translate('.$offsetx.$offsetxMu.', '.$y_offset_markup.');';
            $hasInlineCSS = true;
        }

        // TYPE
        $this->type = $col['type'];
        // for backwards compatibility
        $isProjectLink = array_key_exists( 'postid', $col ) ? true : false;
        if(($this->type == 'img' && $isProjectLink) || $this->type == 'postThumbnail'){
            $this->type = 'project';
        }
        
        //  ID
        $this->col_id = array_key_exists('html_id', $col) ? 'id="'.$col['html_id'].'"' : '';

        // instead of only in placefree mode, we now use a zIndex always, for when horizontalGrid is active or normal mode 
        if( array_key_exists('zIndex', $col) ) {
            $hasInlineCSS = true;
            $css .= 'z-index:'.((int)$col['zIndex']+2).';';
        }

        // CLASSES
        if( array_key_exists('placeFreely', $col) ) {
            $hasInlineCSS = true;
            $this->col_classes .= ' place-freely';
            $css .= 'position:absolute;left:'.$col['left'].'%;top:calc((100vw - var(--scrollbarWidth)) * '.($col['top'] / 100).');width:'.$col['width'].'%;';
        } else {
            $this->col_classes .= ' place-normal';
            $this->col_classes .= ' push-'.$col['push'];
            $this->col_classes .= ' span-'.$col['colspan'];

            $this->col_classes .= ' colstart-'.$col['col'];
            $this->col_classes .= ' colend-'.($col['col'] + $col['colspan']);
            $this->col_classes .= $place_at_end_of_col ? ' place-at-end-of-col' : '';
    
            if( array_key_exists('frameOverflow', $col) ) {
                // error_log(print_r($col['frameOverflow'], true));
                switch( $col['frameOverflow'] ){
                    case 'left':
                        $this->col_classes .= ' frame-overflow-left';
                        break;
                    case 'both':
                        $this->col_classes .= ' frame-overflow-both';
                        break;
                    case 'right':
                        $this->col_classes .= ' frame-overflow-right';
                        break;
                    case '':
                        $this->col_classes .= ' no-frame-overflow';
                    break;
                    default:
                        $this->col_classes .= ' no-frame-overflow';
                    break;
                }
            } else {
                $this->col_classes .= ' no-frame-overflow';
            }

            if( array_key_exists('horizontalIndex', $col) && array_key_exists('horizontalGrid', $col) ) {
                $this->col_classes .= ' uses-horizontal-grid';
                if( array_key_exists('stickytop', $col) ) {
                    // horizontal grid items still need align top when using stickytop so sticky works
                    $this->col_classes .= ' align-'.$col['align'];
                }
            } else {
                $this->col_classes .= ' align-'.$col['align'];
            }

        }



        $this->col_classes .= array_key_exists('classes', $col) ? ' '.$col['classes'] : '';


        if( array_key_exists('yvel', $col) && $col['yvel'] != 1 && LayFrontend_Options::$simple_parallax ){
            $this->col_classes .= ' has-parallax';
        }else{
            $this->col_classes .= ' no-parallax';
        }

        $this->col_classes .= ' type-'.$this->type;
        $this->col_classes .= ' id-'.$col['relid'];


        $lightboxoff = array_key_exists('lightboxoff', $col) && $col['lightboxoff'] == true && $this->type == 'img' ? 'lightboxoff' : '';

        $this->col_classes .= ' '.$lightboxoff;

        // error_log(print_r($col, true));
        if( $this->type == 'carousel' ) {
            if( array_key_exists('carousel_options', $col) ){
                if( array_key_exists('fixedHeight', $col['carousel_options']) ){
                    if( $col['carousel_options']['fixedHeight'] == '100vh' ) {
                        $this->col_classes .= ' contains_100vh-carousel';
                    }else{
                        $this->col_classes .= ' no_100vh-carousel';
                    }
                }else{
                    $this->col_classes .= ' no_100vh-carousel';
                }
            }else{
                $this->col_classes .= ' no_100vh-carousel';
            }
        }


        // YVEL
        if( array_key_exists( 'yvel', $col ) && $col['yvel'] != 0 ){
            $this->yvel = 'data-yvel="'.$col['yvel'].'"';
        }

        $stickytop = array_key_exists( 'stickytop', $col ) ? $col['stickytop'] : false;
        // $this->data_attrs = $stickytop;
        // error_log(print_r($stickytop, true));
        if( $stickytop !== false && $stickytop !== null && $stickytop !== 'null' && $stickytop !== '' ){
            $this->col_classes .= ' lay-sticky';

            $hasInlineCSS = true;
            $css .= 'position:sticky;top:'.$stickytop.'px;';

            // $this->data_attrs .= ' data-sticky-top="'.$stickytop.'"';
            // $this->data_attrs .= ' data-sticky-for="'.( array_key_exists( 'stickyfor', $col ) ? $col['stickyfor'] : 1 ).'"';
        } else {
            $this->col_classes .= ' no-sticky';
        }

        if( array_key_exists( 'fs_maxdim', $col ) ) {
            $this->data_attrs .= ' data-fullscreenslider-maxdim="'.$col['fs_maxdim'].'"';
        }
        
        if( $hasInlineCSS ) {
            $this->inline_css = 'style="'.$css.'"';
        }

        if( $this->type == 'thumbnailgrid' || $this->type == 'elementgrid' || $this->type == 'productsgrid' ) {
            // error_log(print_r($col, true));
            if( array_key_exists('config', $col) ) {
                if( $col['config']['layoutType'] == 'masonry' ) {
                    $this->col_classes .= ' contains-masonry-layout';
                }
            }
        }

    }

    public function getOpeningMarkup(){
        return '<div class="'.$this->col_classes.'" '.$this->col_id.' '.$this->data_attrs.' data-type="'.$this->type.'" '.$this->inline_css.' '.$this->yvel.' '.$this->offset_data_attrs.'>';
    }

    public function getClosingMarkup(){
        return '</div>';
    }

}