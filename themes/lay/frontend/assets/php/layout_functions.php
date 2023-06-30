<?php 

class Lay_LayoutFunctions{

    public static $downArrowDesktop;
    public static $downArrowPhone;

    public function __construct(){
        Lay_LayoutFunctions::$downArrowPhone = '<svg class="cover-down-arrow-phone" stroke="black" width="36" height="20">
		    <polyline fill="none" stroke-width="2" points="2,2 18,16 34,2" stroke-linecap="round"></polyline>
	    </svg>';
        Lay_LayoutFunctions::$downArrowDesktop = '<svg class="cover-down-arrow-desktop" stroke="black" width="48" height="24">
            <polyline fill="none" stroke-width="2" points="2,2 24,22 46,2" stroke-linecap="round"></polyline>
        </svg>';
    }

    public static function getBackgroundImageCSS( $json, $target ){
        $bgImage = array_key_exists('bgImage', $json) && is_array($json['bgImage']) && array_key_exists('url', $json['bgImage']) ? $json['bgImage']['url'] : '';
        if( $bgImage != '' ) {
            return '<!-- background image css --><style>'.$target.'{background-image:url('.$bgImage.');background-size:cover;background-attachment:fixed;background-repeat:no-repeat;background-position:center;}</style>';
        }
        return '';
    }

    public static function getBackgroundCSS( $json, $target ){
        $bgColor = $json['bgColor'];
        if( $bgColor == '' || $bgColor == null ) {
            $bgColor = 'transparent';
        }
        return '<!-- background color css --><style>'.$target.'{background-color:'.$bgColor.';}</style>';
    }

    public static function getRowsMarginBottomCSS($grid_array, $rows, $target, $isPhoneGrid) {
        if( !is_array($rows) ) {
            return '';
        }
        $markup = '';
        $style = '';
        if($isPhoneGrid){
            $style = '<style>@media (max-width: '.LayFrontend_Options::$breakpoint.'px){';
        }else{
            $style = '<style>@media (min-width: '.( LayFrontend_Options::$breakpoint+1 ).'px){';
        }

        for( $i = 0; $i < count($rows); $i++ ){
            $row = $rows[$i];
            if( array_key_exists( 'rowGutter', $row ) ) {
                // $measuring_unit = $isPhoneGrid == true ? Gridder::$phone_rowgutter_mu : Gridder::$rowgutter_mu;
                $mu = array_key_exists('mus' ,$grid_array) && array_key_exists('rowGutterMu', $grid_array['mus']) ? $grid_array['mus']['rowGutterMu'] : Gridder::$rowgutter_mu;
                if( $isPhoneGrid == true ) {
                    $mu = array_key_exists('mus' ,$grid_array) && array_key_exists('rowGutterMu', $grid_array['mus']) ? $grid_array['mus']['rowGutterMu'] : Gridder::$phone_rowgutter_mu;
                }
                $style .= $target.' .row-'.$i.'{margin-bottom:'.$row['rowGutter'].$mu.';}';
            }
        }
        return '<!-- rows margin bottom css -->'.$style.'}</style>';
    }

// LAYTHEME

// col 0: is col 2 for css grid :)
// col 1: is col 4 for css grid :)
// col 2: is col 6 for css grid :)
// col 3: is col 8 for css grid :)
private static function getColumnStartForCSSGrid($col, $inStack, $frameOverflow) {
    $col = (int)$col;
	if ($inStack) {
		if ($col == 0) {
			return 1;
		}
		if ($col == 1) {
			return 3;
		}
		return $col * 2 + 1;
	} else {
		if ($frameOverflow == 'left' || $frameOverflow == 'both') {
			return 1;
		}
		if ($col == 0) {
			return 2;
		}
		if ($col == 1) {
			return 4;
		}
		return $col * 2 + 2;
	}
}

private static function getColumnEndForCSSGrid($col, $inStack, $frameOverflow, $colcount) {
    $col = (int)$col;
	if ($inStack) {
		if ($col == 0) {
			return 1;
		}
		if ($col == 1) {
			return 3;
		}
		return $col * 2;
	} else {
		if ($frameOverflow == 'right' || $frameOverflow == 'both') {
			return $colcount * 2 + 2;
		}
		if ($col == 0) {
			return 2;
		}
		if ($col == 1) {
			return 4;
		}
		return $col * 2 + 1;
	}
}

// note to myself: while this works correctly, we do use $grid_id to target a container, but we add all element's css to the container, even if that container
// only contains 1 or 2 elements when we use the cover feature :)
public static function getHorizontalGridCSS($grid_arr, $grid_id, $isPhoneGrid = false) {
    $target = $grid_id;
    $grid_arr = (array)$grid_arr;
    if( !array_key_exists('horizontalGrid', $grid_arr) ) {
        return '';
    }
    $settings = $grid_arr['horizontalGrid'];
    $mu = $settings['mu'] == '%' ? 'vw' : $settings['mu'];

    $css = '';

    for($i = 0; $i<count($grid_arr['cont']); $i++) {
        $el = $grid_arr['cont'][$i];
        if( array_key_exists('horizontalIndex', $el) && $el['horizontalIndex'] != 0 ) {
            if( $mu == 'px' ) {
                $css .= $grid_id.' .id-'.$el['relid'].'{top:'.($el['horizontalIndex'] * $settings['space']) . $mu.';}';
            } else {
                // calc((100vw - var(--scrollbarWidth)) * '.($col['top'] / 100).')
                $css .= $grid_id.' .id-'.$el['relid'].'{top:calc( (100vw - var(--scrollbarWidth)) * '.($el['horizontalIndex'] * $settings['space'] / 100).');}';
            }
        }
    }

    $style = '';
    if($isPhoneGrid){
        $style = '
        <!-- horizontal grid css --><style>@media (max-width: '.LayFrontend_Options::$breakpoint.'px){'.$css.'}</style>';
    }else{
        $style = '
        <!-- horizontal grid css --><style>@media (min-width: '.( LayFrontend_Options::$breakpoint+1 ).'px){'.$css.'}</style>';
    }

    return $style;
}

public static function getGridCSS($grid_arr, $grid_id, $isPhoneGrid = false) {
        $target = $grid_id;
        $grid_arr = (array)$grid_arr;

        $col_sel = '.col';
        $span_sel = '.span';
        $push_sel = '.push';
        $row_sel = '.row';
        $_100vh_sel = '._100vh';
        $type_sel = '.type';
        $fovl_sel = '.frame-overflow-left';
        $fovr_sel = '.frame-overflow-right';
        $fovb_sel = '.frame-overflow-both';
        $no_fov_sel = '.no-frame-overflow';
        $abs_position_sel = '.absolute-position';
        $stack_sel = '.stack-element';
        // # LG ADJUSTMENTS

        $colcount = (int)$grid_arr['colCount'];
        $colgutter = (float)$grid_arr['colGutter'];
        $framemargin = (float)$grid_arr['frameMargin'];

        $leftframemargin = array_key_exists('leftFrameMargin', $grid_arr) ? (float)$grid_arr['leftFrameMargin'] : $framemargin;
        $rightframemargin = array_key_exists('rightFrameMargin', $grid_arr) ? (float)$grid_arr['rightFrameMargin'] : $framemargin;

        $topframemargin = (float)$grid_arr['topFrameMargin'];
        $bottomframemargin = (float)$grid_arr['bottomFrameMargin'];

        // if frame left right is px and not %, leave frame left right out of the equation, because I will just use padding-left and padding-right for that
        $frame_mu = array_key_exists('mus', $grid_arr) && array_key_exists('frameMu', $grid_arr['mus']) ? $grid_arr['mus']['frameMu'] : get_option( 'gridder_defaults_frame_mu', LayConstants::gridder_defaults_frame_mu );
        $frame_mu_is_px = $frame_mu == 'px' ? true : false;
        $colgutter_mu = array_key_exists('mus', $grid_arr) && array_key_exists('colGutterMu', $grid_arr['mus']) ? $grid_arr['mus']['colGutterMu'] : get_option( 'gridder_defaults_column_gutter_mu', LayConstants::gridder_defaults_column_gutter_mu );
        $colgutter_mu_is_px = $colgutter_mu == 'px' ? true : false;
        if ($isPhoneGrid) {
            $frame_mu = array_key_exists('mus', $grid_arr) && array_key_exists('frameMu', $grid_arr['mus']) ? $grid_arr['mus']['frameMu'] : get_option( 'phone_gridder_defaults_frame_mu', LayConstants::phone_gridder_defaults_frame_mu );
            $frame_mu_is_px = $frame_mu == 'px' ? true : false;

            $colgutter_mu = array_key_exists('mus', $grid_arr) && array_key_exists('colGutterMu', $grid_arr['mus']) ? $grid_arr['mus']['colGutterMu'] : get_option( 'phone_gridder_defaults_column_gutter_mu', LayConstants::phone_gridder_defaults_column_gutter_mu );
            $colgutter_mu_is_px = $colgutter_mu == 'px' ? true : false;
        }

        if(!is_numeric($topframemargin)) {
            $topframemargin = $framemargin;
        }
        if(!is_numeric($bottomframemargin)) {
            $bottomframemargin = $framemargin;
        }

        $onecolspace = 100 / $colcount;
        $frame_per_cc = ($leftframemargin + $rightframemargin) / $colcount;
        $frame = $leftframemargin + $rightframemargin;

        $style = '';

        if($isPhoneGrid){
            $style = '<!-- grid css --><style id="phone-grid-css">@media (max-width: '.LayFrontend_Options::$breakpoint.'px){';
        }else{
            $style = '<!-- grid css --><style id="grid-css">@media (min-width: '.( LayFrontend_Options::$breakpoint+1 ).'px){';
        }

        $my_columns_css = '';
        for ($i = 0; $i < $colcount; $i++) {
            $my_columns_css .= '1fr ';
            if ($i < $colcount - 1) {
                $my_columns_css .= $colgutter . $colgutter_mu . ' ';
            }
        }
    
        $style .= $target.' .column-wrap:not(._100vh):not(.rowcustomheight){display:grid;grid-template-columns:'.$leftframemargin.$frame_mu.' '.$my_columns_css.' '.$rightframemargin.$frame_mu.';}';
    

        // frame overflow left and right
        $style .= $target.' '.$fovb_sel.''.$span_sel.'-'.$colcount.$abs_position_sel.'{width: 100%;}';

        for ($i=0; $i < $colcount+1; $i++) {
            // if( $i>0 ) {

                // for absolute position elements:
                if( $i>0 ) {
                    // width
                    $space = $i * $onecolspace;
                    $gutter_diff = (1 - (1 / $colcount * $i)) * $colgutter;
                    // frame overflow left
                    $style .= $target.' '.$fovl_sel.''.$span_sel.'-'.$i.$abs_position_sel.'{width: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' - '.$gutter_diff.$colgutter_mu.' + '.$leftframemargin.$frame_mu.');}';
                    // frame overflow right
                    $style .= $target.' '.$fovr_sel.''.$span_sel.'-'.$i.$abs_position_sel.'{width: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' - '.$gutter_diff.$colgutter_mu.' + '.$rightframemargin.$frame_mu.');}';
                    // no frame overflow
                    $style .= $target.' '.$span_sel.'-'.$i.$abs_position_sel.'{width: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' - '.$gutter_diff.$colgutter_mu.');}';
                }

                // for not absolute position elements:

                // frame overflow left
                $style .= $target.' '.$fovl_sel.''.$span_sel.'-'.$i.':not(.absolute-position){grid-column-start:'.Lay_LayoutFunctions::getColumnStartForCSSGrid($i, false, 'left').';}';
                // frame overflow right
                $style .= $target.' '.$fovr_sel.''.$span_sel.'-'.$i.':not(.absolute-position){grid-column-end:'.Lay_LayoutFunctions::getColumnEndForCSSGrid($i, false, 'right', $colcount).';}';
                // frame overflow both
                $style .= $target.' '.$fovb_sel.''.$span_sel.'-'.$i.':not(.absolute-position){grid-column-start:'.Lay_LayoutFunctions::getColumnStartForCSSGrid($i, false, 'both').'; grid-column-end:'.Lay_LayoutFunctions::getColumnEndForCSSGrid($i, false, 'both', $colcount).';}';
                // no frame overflow
                $style .= $target.' :not(.absolute-position).colstart-'.$i.'{grid-column-start:'.Lay_LayoutFunctions::getColumnStartForCSSGrid($i, false, '').';}';
                $style .= $target.' :not(.absolute-position).colend-'.$i.'{grid-column-end:'.Lay_LayoutFunctions::getColumnEndForCSSGrid($i, false, '', $colcount).';}';


                // element inside stack css:
                $style .= $target.' .type-stack .colstart-'.$i.'{grid-column-start:'.Lay_LayoutFunctions::getColumnStartForCSSGrid($i, true, '').';}';
                $style .= $target.' .type-stack .colend-'.$i.'{grid-column-end:'.Lay_LayoutFunctions::getColumnEndForCSSGrid($i, true, '', $colcount).';}';

                // stack wrap css:
                $my_columns_css = '';
                for ($i2 = 0; $i2 < $i; $i2++) {
                    $my_columns_css .= '1fr ';
                    if ($i2 < $i - 1) {
                        if ($colgutter_mu == '%') {
                            // base gutter width calculation on 100 - frame
                            $w1 = 100 - ($leftframemargin + $rightframemargin);
                            // this is the size of the gutter if stack was 100% width (not frame overflow :))
                            $gutterInStack = (100 / $w1) * $colgutter;
                            // this is gutter width when stack is not 100% width
                            // $gutter = $gutterInStack * (this.props.colCount / this.props.cont.colspan)
                            $gutter = $gutterInStack * ($i / $k);
                            $my_columns_css .= $gutter . $colgutter_mu . ' ';
                        } else {
                            $my_columns_css .= (int)$colgutter . $colgutter_mu . ' ';
                        }   
                    }
                }
                // stack wrap css:
                $style .= $target.' '.$span_sel.'-'.$i.'.type-stack .stack-element{display:grid;grid-template-columns:'.$my_columns_css.';}';

                // inside of stack element
                // a stack element can be for example span-4. then that means inside of the stack element,
                // elements can also be span-4 or less
                for ($k=0; $k < $i+1; $k++) {



                    // $style .= $target.' '.$span_sel.'-'.$i.' '.$stack_sel.' '.$push_sel.'-'.$k.'{ margin-left: calc( '.$val.'% - '.$gutter_diff_2.$colgutter_mu.'); }';


					// width of elements inside of stack element
					// $relative_colgutter = $colcount / $i * $colgutter;
					// $gutter_diff = (1 - (1 / $i * $k)) * $relative_colgutter;
					// if( $colgutter_mu_is_px ){
					// 	$gutter_diff = (1 - (1 / $i * $k)) * $colgutter;
					// }
                    // $val = 100 / $i * $k;
                    // $style .= $target.' '.$span_sel.'-'.$i.' '.$stack_sel.' '.$span_sel.'-'.$k.'{ width: calc( '.$val.'% - '.$gutter_diff.$colgutter_mu.' ); }';
					// // push inside of a stack element
					// $gutter_diff_2 = (1 - (1 / $i * $k)) * $relative_colgutter - $relative_colgutter;
					// if( $colgutter_mu_is_px ){
					// 	$gutter_diff_2 = (1 - (1 / $i * $k)) * $colgutter - $colgutter;
					// }
                    // $style .= $target.' '.$span_sel.'-'.$i.' '.$stack_sel.' '.$push_sel.'-'.$k.'{ margin-left: calc( '.$val.'% - '.$gutter_diff_2.$colgutter_mu.'); }';
                }

            // }
            // push
            $push = 0;
            if( $i > 0 ) {
                $gutter_diff = (1 / $colcount * $i) * $colgutter;
                /* normal position */
                // $style .= $target.' '.$push_sel.'-'.$i.'.first-child{margin-left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' + '.$gutter_diff.$colgutter_mu.');}';
                // $style .= $target.' '.$push_sel.'-'.$i.'.not-first-child{margin-left: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' + '.$gutter_diff.$colgutter_mu.' + '.$colgutter.$colgutter_mu.');}';
                // absolute position
                $style .= $target.' '.$abs_position_sel.$push_sel.'-'.$i.'{left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' + '.$gutter_diff.$colgutter_mu.');}';
                /* #normal position */

                /* place-at-end-of-col */
                // absolute position
                $gutter_diff2 = (1 / $colcount * ($i + 1)) * $colgutter;
                $style .= $target.' '.$abs_position_sel.$push_sel.'-'.$i.'.place-at-end-of-col{left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.($i + 1).' + '.$gutter_diff.$colgutter_mu.' - '.$colgutter.$colgutter_mu.');}';
                /* #place-at-end-of-col */
            } else {
                // $style .= $target.' '.$no_fov_sel.$push_sel.'-'.$i.'.first-child{margin-left: '.$leftframemargin.$frame_mu.';}';
                // $style .= $target.' '.$fovr_sel.$push_sel.'-'.$i.'.first-child{margin-left: '.$leftframemargin.$frame_mu.';}';
                // $style .= $target.' '.$push_sel.'-'.$i.'.not-first-child{margin-left: '.$colgutter.$colgutter_mu.';}';
                // absolute position
                $style .= $target.' '.$abs_position_sel.$no_fov_sel.$push_sel.'-'.$i.'{left: '.$leftframemargin.$frame_mu.'}';
                /* place-at-end-of-col */
                // absolute position
                $style .= $target.' '.$abs_position_sel.$no_fov_sel.$push_sel.'-'.$i.'.place-at-end-of-col{left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' - '.$colgutter.$colgutter_mu.');}';
                /* #place-at-end-of-col */
            }
        }

        $style .= '</style>';
        // on some websites floats use commas instead of dots.
        // $style = Lay_LayoutFunctions::replaceCommaWithDot($style);
        return $style;
}

    // public static function getGridCSS($grid_arr, $grid_id, $isPhoneGrid = false) {
    //     /*
    //     ADJUSTMENTS FOR LG/LT:
    //     this, and also use LG_Constants:: instead of LayConstants:: !
    //     and use LayGridderFrontend:: instead of Lay_LayoutFunctions::
    //     also remove this for laygridder:
    //     //     if($isPhoneGrid){
    //     //         $style = '<!-- grid css --><style>@media (max-width: '.LayFrontend_Options::$breakpoint.'px){';
    //     //     }else{
    //     //         $style = '<!-- grid css --><style>@media (min-width: '.( LayFrontend_Options::$breakpoint+1 ).'px){';
    //     //     }
    //     and:
    //         $style .= '}</style>';
    //     $target = '#'.$grid_id;
    //     should be $target = $grid_id;
    //     */
    //     $target = $grid_id;
    //     $grid_arr = (array)$grid_arr;

    //     $col_sel = '.col';
    //     $span_sel = '.span';
    //     $push_sel = '.push';
    //     $row_sel = '.row';
    //     $_100vh_sel = '._100vh';
    //     $type_sel = '.type';
    //     $fovl_sel = '.frame-overflow-left';
    //     $fovr_sel = '.frame-overflow-right';
    //     $fovb_sel = '.frame-overflow-both';
    //     $no_fov_sel = '.no-frame-overflow';
    //     $abs_position_sel = '.absolute-position';
    //     $stack_sel = '.stack-element';
    //     // # LG ADJUSTMENTS

    //     $colcount = (int)$grid_arr['colCount'];
    //     $colgutter = (float)$grid_arr['colGutter'];
    //     $framemargin = (float)$grid_arr['frameMargin'];

    //     $leftframemargin = array_key_exists('leftFrameMargin', $grid_arr) ? (float)$grid_arr['leftFrameMargin'] : $framemargin;
    //     $rightframemargin = array_key_exists('rightFrameMargin', $grid_arr) ? (float)$grid_arr['rightFrameMargin'] : $framemargin;

    //     $topframemargin = (float)$grid_arr['topFrameMargin'];
    //     $bottomframemargin = (float)$grid_arr['bottomFrameMargin'];

    //     // if frame left right is px and not %, leave frame left right out of the equation, because I will just use padding-left and padding-right for that
    //     $frame_mu = array_key_exists('mus', $grid_arr) && array_key_exists('frameMu', $grid_arr['mus']) ? $grid_arr['mus']['frameMu'] : get_option( 'gridder_defaults_frame_mu', LayConstants::gridder_defaults_frame_mu );
    //     $frame_mu_is_px = $frame_mu == 'px' ? true : false;
    //     $colgutter_mu = array_key_exists('mus', $grid_arr) && array_key_exists('colGutterMu', $grid_arr['mus']) ? $grid_arr['mus']['colGutterMu'] : get_option( 'gridder_defaults_column_gutter_mu', LayConstants::gridder_defaults_column_gutter_mu );
    //     $colgutter_mu_is_px = $colgutter_mu == 'px' ? true : false;
    //     if ($isPhoneGrid) {
    //         $frame_mu = array_key_exists('mus', $grid_arr) && array_key_exists('frameMu', $grid_arr['mus']) ? $grid_arr['mus']['frameMu'] : get_option( 'phone_gridder_defaults_frame_mu', LayConstants::phone_gridder_defaults_frame_mu );
    //         $frame_mu_is_px = $frame_mu == 'px' ? true : false;

    //         $colgutter_mu = array_key_exists('mus', $grid_arr) && array_key_exists('colGutterMu', $grid_arr['mus']) ? $grid_arr['mus']['colGutterMu'] : get_option( 'phone_gridder_defaults_column_gutter_mu', LayConstants::phone_gridder_defaults_column_gutter_mu );
    //         $colgutter_mu_is_px = $colgutter_mu == 'px' ? true : false;
    //     }

    //     if(!is_numeric($topframemargin)) {
    //         $topframemargin = $framemargin;
    //     }
    //     if(!is_numeric($bottomframemargin)) {
    //         $bottomframemargin = $framemargin;
    //     }

    //     $onecolspace = 100 / $colcount;
    //     $frame_per_cc = ($leftframemargin + $rightframemargin) / $colcount;
    //     $frame = $leftframemargin + $rightframemargin;

    //     $style = '';

    //     if($isPhoneGrid){
    //         $style = '<!-- grid css --><style id="phone-grid-css">@media (max-width: '.LayFrontend_Options::$breakpoint.'px){';
    //     }else{
    //         $style = '<!-- grid css --><style id="grid-css">@media (min-width: '.( LayFrontend_Options::$breakpoint+1 ).'px){';
    //     }
    //     // frame overflow left and right
    //     $style .= $target.' '.$fovb_sel.''.$span_sel.'-'.$colcount.'{width: 100%;}';

    //     for ($i=0; $i < $colcount+1; $i++) {
    //         if( $i>0 ) {
    //             // width
    //             $space = $i * $onecolspace;
    //             $gutter_diff = (1 - (1 / $colcount * $i)) * $colgutter;
    //             // frame overflow left
    //             $style .= $target.' '.$fovl_sel.''.$span_sel.'-'.$i.'{width: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' - '.$gutter_diff.$colgutter_mu.' + '.$leftframemargin.$frame_mu.');}';
    //             // frame overflow right
    //             $style .= $target.' '.$fovr_sel.''.$span_sel.'-'.$i.'{width: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' - '.$gutter_diff.$colgutter_mu.' + '.$rightframemargin.$frame_mu.');}';
    //             // no frame overflow
    //             $style .= $target.' '.$span_sel.'-'.$i.'{width: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' - '.$gutter_diff.$colgutter_mu.');}';
                
    //             // inside of stack element
    //             // a stack element can be for example span-4. then that means inside of the stack element,
    //             // elements can also be span-4 or less
    //             for ($k=0; $k < $i+1; $k++) {
	// 				// width of elements inside of stack element
	// 				$relative_colgutter = $colcount / $i * $colgutter;
	// 				$gutter_diff = (1 - (1 / $i * $k)) * $relative_colgutter;
	// 				if( $colgutter_mu_is_px ){
	// 					$gutter_diff = (1 - (1 / $i * $k)) * $colgutter;
	// 				}
    //                 $val = 100 / $i * $k;
    //                 $style .= $target.' '.$span_sel.'-'.$i.' '.$stack_sel.' '.$span_sel.'-'.$k.'{ width: calc( '.$val.'% - '.$gutter_diff.$colgutter_mu.' ); }';
	// 				// push inside of a stack element
	// 				$gutter_diff_2 = (1 - (1 / $i * $k)) * $relative_colgutter - $relative_colgutter;
	// 				if( $colgutter_mu_is_px ){
	// 					$gutter_diff_2 = (1 - (1 / $i * $k)) * $colgutter - $colgutter;
	// 				}
    //                 $style .= $target.' '.$span_sel.'-'.$i.' '.$stack_sel.' '.$push_sel.'-'.$k.'{ margin-left: calc( '.$val.'% - '.$gutter_diff_2.$colgutter_mu.'); }';
    //             }

    //         }
    //         // push
    //         $push = 0;
    //         if( $i > 0 ) {
    //             $gutter_diff = (1 / $colcount * $i) * $colgutter;
    //             /* normal position */
    //             $style .= $target.' '.$push_sel.'-'.$i.'.first-child{margin-left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' + '.$gutter_diff.$colgutter_mu.');}';
    //             $style .= $target.' '.$push_sel.'-'.$i.'.not-first-child{margin-left: calc( (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' + '.$gutter_diff.$colgutter_mu.' + '.$colgutter.$colgutter_mu.');}';
    //             // absolute position
    //             $style .= $target.' '.$abs_position_sel.$push_sel.'-'.$i.'{left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.$i.' + '.$gutter_diff.$colgutter_mu.');}';
    //             /* #normal position */

    //             /* place-at-end-of-col */
    //             // absolute position
    //             $gutter_diff2 = (1 / $colcount * ($i + 1)) * $colgutter;
    //             $style .= $target.' '.$abs_position_sel.$push_sel.'-'.$i.'.place-at-end-of-col{left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' * '.($i + 1).' + '.$gutter_diff.$colgutter_mu.' - '.$colgutter.$colgutter_mu.');}';
    //             /* #place-at-end-of-col */
    //         } else {
    //             $style .= $target.' '.$no_fov_sel.$push_sel.'-'.$i.'.first-child{margin-left: '.$leftframemargin.$frame_mu.';}';
    //             $style .= $target.' '.$fovr_sel.$push_sel.'-'.$i.'.first-child{margin-left: '.$leftframemargin.$frame_mu.';}';
    //             $style .= $target.' '.$push_sel.'-'.$i.'.not-first-child{margin-left: '.$colgutter.$colgutter_mu.';}';
    //             // absolute position
    //             $style .= $target.' '.$abs_position_sel.$no_fov_sel.$push_sel.'-'.$i.'{left: '.$leftframemargin.$frame_mu.'}';
    //             /* place-at-end-of-col */
    //             // absolute position
    //             $style .= $target.' '.$abs_position_sel.$no_fov_sel.$push_sel.'-'.$i.'.place-at-end-of-col{left: calc( '.$leftframemargin.$frame_mu.' + (100% - '.$frame.$frame_mu.') / '.$colcount.' - '.$colgutter.$colgutter_mu.');}';
    //             /* #place-at-end-of-col */
    //         }
    //     }

    //     $style .= '</style>';
    //     // on some websites floats use commas instead of dots.
    //     $style = Lay_LayoutFunctions::replaceCommaWithDot($style);
    //     return $style;
    // }

    // attention, this returns a string! the issue was all floats used , instead of . so i just return a string here that uses .
    public static function replaceCommaWithDot($float){
        $str = (string)$float;
        if(strstr($str, ",")) {
            $str = str_replace(",", ".", $str); // replace ',' with '.'
        }
        return $str;
    }

    public static function getRowIs100vh($row){
        if( array_key_exists('row100vh', $row) && $row['row100vh'] == true ) {
            return true;
        }
        return false;
    }

    public static function getCoverDownArrowMarkup($array){
        // we need phoneOnly because if we have a cpl (custom phone layout), we only need the phone down arrow markup
        $phoneOnly = array_key_exists('phoneOnly', $array) ? $array['phoneOnly'] : false;
        $markup = '';
        if( LayFrontend_Options::$cover_down_arrow_type != 'none' ) {
            $animate_class = LayFrontend_Options::$cover_down_arrow_animate ? 'cover-down-arrow-animate' : '';
            $image = '';

            /*
                '<svg width="24" height="14">
                    <polyline fill="none" stroke="white" stroke-width="4" points="2,0 12,10 22,0" stroke-linecap="square"></polyline>
                </svg> '; 
            */
            switch( LayFrontend_Options::$cover_down_arrow_type ) {
                case 'white':
                case 'black':
                    $image =  Lay_LayoutFunctions::$downArrowPhone;
                    if( !$phoneOnly ) {
                        $image .=  Lay_LayoutFunctions::$downArrowDesktop;
                    }
                break;
                case 'custom':
                    $image = LayFrontend_Options::$cover_down_arrow_phone;
                    if( !$phoneOnly ) {
                        $image .= LayFrontend_Options::$cover_down_arrow;
                    }
                break;
            }

            $markup = 
            '<div class="cover-down-arrow cover-down-arrow-type-'.LayFrontend_Options::$cover_down_arrow_type.' '.$animate_class.'">
                '.$image.'
            </div>';
        }
        return $markup;
    }

    public static function getGridFrameCSS($grid_array, $topFrameTarget, $bottomFrameTarget, $isPhoneGrid = false) {
        $topframemargin = (float)$grid_array['topFrameMargin'];
        $topframemargin_str = Lay_LayoutFunctions::replaceCommaWithDot($topframemargin);
        $bottomframemargin = (float)$grid_array['bottomFrameMargin'];
        $bottomframemargin_str = Lay_LayoutFunctions::replaceCommaWithDot($bottomframemargin);
    
        $style = "";
        $topFrameMu = array_key_exists('mus' ,$grid_array) && array_key_exists('topFrameMu', $grid_array['mus']) ? $grid_array['mus']['topFrameMu'] : Gridder::$topframe_mu;
        $bottomFrameMu = array_key_exists('mus' ,$grid_array) && array_key_exists('bottomFrameMu', $grid_array['mus']) ? $grid_array['mus']['bottomFrameMu'] : Gridder::$bottomframe_mu;
    
        if($isPhoneGrid){
            $style = '@media (max-width: '.LayFrontend_Options::$breakpoint.'px){';
            $topFrameMu = array_key_exists('mus' ,$grid_array) && array_key_exists('topFrameMu', $grid_array['mus']) ? $grid_array['mus']['topFrameMu'] : get_option( 'phone_gridder_defaults_topframe_mu', LayConstants::phone_gridder_defaults_topframe_mu );
            $bottomFrameMu = array_key_exists('mus' ,$grid_array) && array_key_exists('bottomFrameMu', $grid_array['mus']) ? $grid_array['mus']['bottomFrameMu'] : get_option( 'phone_gridder_defaults_bottomframe_mu', LayConstants::phone_gridder_defaults_bottomframe_mu );
        }else{
            $style = '@media (min-width: '.(LayFrontend_Options::$breakpoint+1).'px){';
        }
        $style .= $topFrameTarget.'{padding-top:'.$topframemargin_str.$topFrameMu.';}'
            .$bottomFrameTarget.'{padding-bottom:'.$bottomframemargin_str.$bottomFrameMu.';}'
        .'}';
    
        $style = '<!-- grid frame css --><style>'.$style.'</style>';
        return $style;
    }

    // only needed when cover is active
    // set rows region padding-top to first rowgutter
    // todo: for phone 
    public static function getFirstRowGutterAsPaddingTopForCoverCSS($grid_array, $target, $forPhone = false) {
        if( is_array($grid_array) && count( $grid_array['rowGutters'] ) > 0 ) {
            $gutter = $grid_array['rowGutters'][0];
            $gutter_str = Lay_LayoutFunctions::replaceCommaWithDot($gutter);
            if( $forPhone ) {
                $mu = array_key_exists('mus' ,$grid_array) && array_key_exists('rowGutterMu', $grid_array['mus']) ? $grid_array['mus']['rowGutterMu'] : Gridder::$phone_rowgutter_mu;
                // phone
                return 
                '<!-- First Row-Gutter as padding top for pages with Cover --> <style>'
                .'@media (max-width: '.(LayFrontend_Options::$breakpoint).'px){'
                    .$target.'{padding-top:'.$gutter_str.$mu.';}'
                .'}'
                .'</style>';
            } else {
                $mu = array_key_exists('mus' ,$grid_array) && array_key_exists('rowGutterMu', $grid_array['mus']) ? $grid_array['mus']['rowGutterMu'] : Gridder::$rowgutter_mu;
                // desktop
                return 
                '<!-- First Row-Gutter as padding top for pages with Cover --> <style>'
                .'@media (min-width: '.(LayFrontend_Options::$breakpoint+1).'px){'
                    .$target.'{padding-top:'.$gutter_str.$mu.';}'
                .'}'
                .'</style>';
            }
        }
        return '';
    }

}
new Lay_LayoutFunctions();