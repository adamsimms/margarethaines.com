<?php
// todo: everywhere I use showOriginalImages, also use is no Touchdevice
// todo: test gif

class LayRow {

    public $row_classes;
    public $row_inner_classes;
    public $row;
    public $index;
    // bg image
    public $backgroundImageMarkup;
    // bg video
    public $videoMarkup;
    public $html_classes;
    public $html_id;
    public $row_css;
    public $rowcustomheight_css;
    public $column_wrap_classes;
    public $linkForEmptyBackground;

    public function __construct($row, $index) {
        $this->index = $index;
        $this->row = $row;
        $this->row_classes = '';
        $this->row_inner_classes = '';
        $this->backgroundImageMarkup = '';
        $this->row_css = '';
        $this->rowcustomheight_css = '';

        // error_log(print_r($row, true));

        $relid = array_key_exists('relid', $row) ? $row['relid'] : '';

        $bgcolor = array_key_exists('bgcolor', $row) ? $row['bgcolor'] : '';
		$rowGutter = array_key_exists('rowGutter', $row) ? $row['rowGutter'] : '';
		$row100vh = array_key_exists('row100vh', $row) ? $row['row100vh'] : '';
		$rowcustomheight = array_key_exists('rowcustomheight', $row) ? $row['rowcustomheight'] : '';

		$bgimage = array_key_exists('bgimage', $row) ? $row['bgimage'] : '';
        $bgimage2 = array_key_exists('bgimage2', $row) ? $row['bgimage2'] : '';
        // left
        $bgimage3 = array_key_exists('bgimage3', $row) ? $row['bgimage3'] : '';
        $doBgImage = false;
        if ( $bgimage != '' || $bgimage2 != '' || $bgimage3 != '' ) {
            $doBgImage = true;
        }
        $background_image_left_array = false;
        $background_image_right_array = false;
        // if( $bgimage != '' ) {
            
        // }
        // if( $bgimage2 != '' ) {
        //     $background_image_left_array []= $bgimage2;
        // }
        // if( $bgimage3 != '' ) {
        //     $background_image_left_array []= $bgimage3;
        // }

        // if( count($background_images_array) == 3 ) {
        //     array_shift($background_images_array);
        // }

        $styleChoice = '';
        $bgStyle = '';
        if ( $bgimage != '' &&  $bgimage2 != '' ) {
            // normal bg image and second bg image, making this left and right so it is compatible with old version
			$styleChoice = 'legacy_left1_right2';
            $bgStyle = 'left_right';
            $background_image_left_array = $bgimage;
            $background_image_right_array = $bgimage2;
		} else if ( $bgimage != '' &&  $bgimage3 != '' ) {
            // normal bg image and right bg image
			$styleChoice = 'onlyleft3';
            $bgStyle = 'left';
            $background_image_left_array = $bgimage3;
		} else if ( $bgimage2 != '' && $bgimage3 != '' ) {
			// left(3) and right(2)
			$styleChoice = 'left3_right2';
            $bgStyle = 'left_right';
            $background_image_left_array = $bgimage3;
            $background_image_right_array = $bgimage2;
		} else if ( $bgimage2 != '' && $bgimage3 == '' ) {
			$styleChoice = 'onlyright2';
            $bgStyle = 'right';
            $background_image_right_array = $bgimage2;
		} else if ( $bgimage2 == '' && $bgimage3 != '' ) {
			// only left (3)
			$styleChoice = 'onlyleft3';
            $bgStyle = 'left';
            $background_image_left_array = $bgimage3;
		}  else if ( $bgimage != '' ) {
			// normal bg image
			$styleChoice = 'bgimage';
            $bgStyle = 'normal';
            $background_image_left_array = $bgimage;
		}

		$bgvideo = array_key_exists('bgvideo', $row) ? $row['bgvideo'] : '';
		$link = array_key_exists('link', $row) ? $row['link'] : '';
		$this->html_classes = array_key_exists('classes', $row) ? $row['classes'] : '';
		$this->html_id = array_key_exists('html_id', $row) ? $row['html_id'] : '';

		$row_has_bg = false;
		$linkMarkup = false;

        if( count($row['columns']) == 0 ){
            $this->row_classes .= ' empty';
        }
        if( count($row['columns']) == 1 ){
            $this->row_classes .= ' one-col-row';
        }
        $this->row_classes .= ' row-col-amt-'.count($row['columns']);

        if( count($row['columns']) > 0 ){
            $no_y_offsets = true;
            $no_sticky = true;
            $only_vls = true;
            $alignmentArr = [];
            $alignsAreUnique = true;
            $no_horizontal_grid = true;
            $absolutePositionVerticallyForAPLApplicable = true;

            $bigElementsAmount = 0;

            foreach( $row['columns'] as $col ) {
                if( $col['type'] != 'text' && $col['type'] != 'html' ) {
                    $bigElementsAmount++;
                }
                if( in_array($col['align'], $alignmentArr) === true ) {
                    $alignsAreUnique = false;
                }
                $alignmentArr []=  $col['align'];
                if( array_key_exists('offsety', $col) && $col['offsety'] != 0 ) {
                    $no_y_offsets = false;
                }
                if( array_key_exists('stickytop', $col) && $col['stickytop'] != 0 ) {
                    $no_sticky = false;
                }
                if( array_key_exists('horizontalIndex', $col) && $col['horizontalIndex'] != 0 ) {
                    $no_horizontal_grid = false;
                }
            }
            $hasSameVerticalAlignment = true;
            foreach( $row['columns'] as $col ) {
                if( $col['type'] != 'vl' ) {
                    $only_vls = false;
                    break;
                }
            }

            if( $bigElementsAmount > 1 ) {
                $absolutePositionVerticallyForAPLApplicable = false;
            }

            if( $alignsAreUnique && $absolutePositionVerticallyForAPLApplicable ) {
                $this->row_classes .= ' absolute-positioning-vertically-in-apl';
            }
            if( $no_sticky ) {
                $this->row_classes .= ' no-stickies';
            }
            if( $no_y_offsets ) {
                $this->row_classes .= ' no-y-offsets';
            }
            if( $no_horizontal_grid ) {
                $this->row_classes .= ' no-horizontal-grid';
            }
            if( $only_vls ) {
                $this->row_classes .= ' only-vertical-lines';
            }
        }
        if( array_key_exists( 'row100vh', $row ) && $row['row100vh'] == true ) {
            $this->row_classes .= ' _100vh';
            $this->row_inner_classes .= ' _100vh';
            $this->column_wrap_classes .= ' _100vh';
        }
        
        if( $rowcustomheight != '' ) {
            $this->row_classes .= ' rowcustomheight';
            $this->row_inner_classes .= ' rowcustomheight';
            $this->column_wrap_classes .= ' rowcustomheight';
            $this->rowcustomheight_css = 'min-height:calc('.$row['rowcustomheight'].');';
        }
        if( array_key_exists('link', $row ) ) {
            $this->row_classes .= ' row-has-link';
            if( is_plugin_active( 'laytheme-imagehover/laytheme-imagehover.php' ) && array_key_exists('hoverimageid', $row['link']) && $row['link']['hoverimageid'] != null ) {
                $this->row_classes .= ' row-has-hoverimage';
            } else {
                $this->row_classes .= ' no-row-hoverimage';
            }
        } else {
            $this->row_classes .= ' no-row-hoverimage';
        }
        
        if( array_key_exists('columns', $row) && is_array($row['columns']) ) {
            for( $i3=0; $i3<count($row['columns']); $i3++ ) {
                $col = $row['columns'][$i3];
                if( array_key_exists('carousel_options', $col) ){
                    if( array_key_exists('fixedHeight', $col['carousel_options']) ){
                        if( $col['carousel_options']['fixedHeight'] == '100vh' ) {
                            $this->row_classes .= ' contains_100vh-carousel';
                        }
                    }
                }
                if( count($row['columns']) == 1 && array_key_exists('type', $col) && $col['type'] == 'marquee' ) {
                    $this->row_classes .= ' only-marquee-row';
                }
            }
        }

        $setBgColor = true;
        $rowBgClass = '';

		// link markup
		if ( is_array($link) && array_key_exists('url', $link) ) {
			$target = '';
			if ( $link['newtab'] == true) {
				$target = ' target="_blank"';
            }
            $catidAttrs = array_key_exists('catid', $link) ? ' data-catid="'.LayElFunctions::stringifyCatIds($link['catid']).'"' : '';
			$dataAttrs = $link['type'] == '' ? '' : 'data-id="'.$link['id'].'" data-type="'.$link['type'].'" data-title="'.__($link['title']).'"'.$catidAttrs;
            // imagehover link
            if( is_plugin_active( 'laytheme-imagehover/laytheme-imagehover.php' ) && array_key_exists('hoverimageid', $link) && $link['hoverimageid'] != null ) {
                $dataAttrs .= ' data-hoverimageid="'.$link['hoverimageid'].'"';
            }
            $linkUrl = LTUtility::getFullURL($link['url']);
            if( $link['type'] != '' && $link['id'] != 'null' && $link['id'] != '' ) {
                // need to do this so link will be updated with qtranslate!
                $linkUrl = get_permalink($link['id']);
            }
            $linkMarkup = '<a '.$dataAttrs.' href="' . $linkUrl . '"' . $target;
		}

        // bg image
        if( $doBgImage ) {

            $background_images_array = array();
            if( is_array($background_image_left_array) ) {
                $background_images_array []= $background_image_left_array;
            }
            if( is_array($background_image_right_array) ) {
                $background_images_array []= $background_image_right_array;
            }

            $this->backgroundImageMarkup = '';
			if ($linkMarkup != false) {
				$this->backgroundImageMarkup = $linkMarkup;
				$rowBgClass .= 'row-bg-link';
			} else {
				$this->backgroundImageMarkup = '<div';
			}
            $rowBgClass .= ' background-image background-image-style-'.$bgStyle.' background-image-count-'.count($background_images_array);
            if( $bgStyle == 'normal' ) {
                $setBgColor = false;
            }
            $row_has_bg = true;

            $bg_brightness_style = array_key_exists('bgimageopacity', $row) ? 'style="-webkit-filter:brightness('.$row['bgimageopacity'].'%);filter:brightness('.$row['bgimageopacity'].'%);"' : '';
            $this->backgroundImageMarkup .= ' class="'.$rowBgClass.'" '.$bg_brightness_style.'>';

            // cannot use el_functions's getLazyImg function here, but I'll try to mimick it as best a possible
            // earlier lay theme versions do not save attid of an image, so here I care about this case for backwards compatibility
            for ($i=0; $i < count($background_images_array); $i++) { 

                $bgi = $background_images_array[$i];
                $full_src = LTUtility::getFullURL($bgi['url']);
                $smallest_src = $full_src;
                if( array_key_exists('_265', $bgi['sizes']) ) {
                    if( array_key_exists('url', $bgi['sizes']['_265']) ){
                        $smallest_src = LTUtility::getFullURL( $bgi['sizes']['_265']['url'] );
                    } else {
                        // backwards compatibility for when this did not contain url and w and h but the url was saved in ['sizes']['_265'] directly
                        $smallest_src = LTUtility::getFullURL( $bgi['sizes']['_265'] );
                    }
                } 
    
                $srcset = LayRowFunctions::getBgSet($bgi);
                $ar = LayRowFunctions::getBgAr($bgi);
                $isGif = substr($full_src, -4) == '.gif' ? true : false;
                
                $alt = get_bloginfo('name');
                $_alt = '';
                if( array_key_exists('attid', $bgi) ) {
                    $attid = $bgi['attid'];
                    $_alt = get_post_meta( $attid, '_wp_attachment_image_alt', true );
                }
                if( $_alt != '' ) {
                    $alt = $_alt;
                }
                
                // data w and data h are not the actual heights and widths of the original image. However, i need this data to calculate the correct sizes attribute, it is about the aspect ratio, not the real width and height of the original image
                $dataHdataW = LayRowFunctions::getBgDataWDataH($bgi);
    
                switch( LayFrontend_Options::$image_loading ) {
                    case 'instant_load':
                        if( $isGif ) {
                            $this->backgroundImageMarkup .= '<img class="lay-gif" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                        }
                        else if( LayFrontend_Options::$misc_options_showoriginalimages && !LTUtility::$isPhone ){
                            $this->backgroundImageMarkup .= '<img class="lay-image-original" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                        }
                        else{
                            $this->backgroundImageMarkup .= '<img class="lay-image-responsive setsizes setsizes-objectfit-cover" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$smallest_src.'" data-srcset="'.$srcset.'" sizes="" alt="'.$alt.'" '.$dataHdataW.'/>';
                        }
                    break;
                    case 'lazy_load':
                        // https://github.com/aFarkas/lazysizes/tree/gh-pages/plugins/parent-fit
                        // needs data-aspectratio: <!-- Usage of the data-aspectratio attribute: Divide width by height: 400/800 = data-aspectratio="0.5" -->
                        // todo: have imageW and imageH in json instead of this, also put imageAttid into json and get the image using that attid. To be compatible with cdn plugins
                        $aspect_ratio_for_lazysizes = array_key_exists('_265', $bgi['sizes']) ? $bgi['sizes']['_265']['w'] / $bgi['sizes']['_265']['h'] : '';
                        if( $isGif ) {
                            $this->backgroundImageMarkup .= '<img class="lay-gif lazyload" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                        }
                        if( LayFrontend_Options::$misc_options_showoriginalimages && !LTUtility::$isPhone ){
                            $this->backgroundImageMarkup .= '<img class="lay-image-original lazyload" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                        }
                        else{
                            $this->backgroundImageMarkup .= '<img class="lazyload" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$smallest_src.'" data-srcset="'.$srcset.'" data-aspectratio="'.$aspect_ratio_for_lazysizes.'" data-sizes="auto" data-parent-fit="cover" alt="'.$alt.'"/>';
                        }
                    break;
                }
            }

			if ($linkMarkup != false) {
				$this->backgroundImageMarkup .= '</a>';
			} else {
				$this->backgroundImageMarkup .= '</div>';
			}
        }

        // todo: test bg video and bg video with image set

        // bg video.
		// if on touch device and we have "playsinline" support, then show video with playsinline attribute
		// otherwise show image if available
		// playsinline is supported from iOS 10 WebKit and Chrome > 53
		// bg video, on touch devices just show image as background in the same way I use a normal row background image
		if( is_array($bgvideo) && array_key_exists('mp4', $bgvideo) ) {

			$setBgColor = false;
			$row_has_bg = true;
			$this->videoMarkup = '';
			$mp4 = LTUtility::getFullURL($bgvideo['mp4']);
			$poster = array_key_exists('image', $bgvideo) ? '' : 'poster="'.LTUtility::getFullURL($bgvideo['image']['full']).'"';

			if ($linkMarkup != false) {
				$this->videoMarkup = $linkMarkup;
				$rowBgClass .= 'row-bg-link';
			} else {
				$this->videoMarkup = '<div';
            }
            
            // show normal video if on desktop or if on touchdevice and playsinline is supported
            // don't need poster when I'm not on touch device
            if ( LTUtility::$supportsPlaysInlineOnTouchDevice && LTUtility::$isTouchDevice || !LTUtility::$isTouchDevice ) {
                $rowBgClass .= ' background-video';
                if( Setup::$is_firefox && LayFrontend_Options::$enable_video_lazyloading_for_firefox == false ) {
                    $this->videoMarkup .= ' class="'.$rowBgClass.'"><video data-ar="'.$bgvideo['mp4Ar'].'" playsinline muted data-autoplay loop class="autoplay"><source src="'.$mp4.'" type="video/mp4"></video>';
                } else {
                    $this->videoMarkup .= ' class="'.$rowBgClass.'"><video data-ar="'.$bgvideo['mp4Ar'].'" preload="none" playsinline muted data-autoplay loop class="autoplay video-lazyload"><source data-src="'.$mp4.'" type="video/mp4"></video>';
                }
            }
            // no playsinline support. just add background image if available
            else if( !LTUtility::$supportsPlaysInlineOnTouchDevice && LTUtility::$isTouchDevice ) {
                if( array_key_exists('image', $bgvideo) && $bgvideo['image'] != "" ) {
                    $full_src = LTUtility::getFullURL($bgvideo['image']['full']);
                    $smallest_src = LTUtility::getFullURL($bgvideo['image']['_265']);
                    $isGif = substr($full_src, -4) == '.gif' ? true : false;
                    $alt = '';
                    $srcset = '';
                    if( array_key_exists('imageAttid', $bgvideo) ){
                        $alt = get_post_meta( $bgvideo['imageAttid'], '_wp_attachment_image_alt', true );
                        $srcset = wp_get_attachment_image_srcset( $bgvideo['imageAttid'] );
                    }else{
                        $alt = get_bloginfo('name');
                        $srcset = LayRowFunctions::getBackgroundVideoBgSet( $bgvideo['image'] );
                    }
        
                    $ar = array_key_exists('imageAr', $bgvideo) ? $bgvideo['imageAr'] : '';
                    // i need data-ar so i can size the backgrounds in case browser has no object-fit
                    $rowBgClass .= ' background-image';
                    $this->videoMarkup .= ' class="'.$rowBgClass.'">';
                    // data w and data h are not the actual heights and widths of the original image. However, i need this data to calculate the correct sizes attribute, it is about the aspect ratio, not the real width and height of the original image
                    $dataHdataW = LayRowFunctions::getBgDataWDataH($bgimage);
                    $aspect_ratio_for_lazysizes = array_key_exists('imageW', $bgvideo) ? $bgvideo['imageW'] / $bgvideo['imageH'] : '';
                    // same as in getLazyImg
                    switch( LayFrontend_Options::$image_loading ) {
                        case 'instant_load':
                            if( $isGif ) {
                                $this->videoMarkup .= '<img class="lay-gif" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                            }
                            // im just changing 'isDesktopOrTabletSize' to !LTUtility::$isPhone, i think that makes sense
                            else if( LayFrontend_Options::$misc_options_showoriginalimages && !LTUtility::$isPhone ){
                                $this->videoMarkup .= '<img class="lay-image-original" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                            }
                            else{
                                $this->videoMarkup .= '<img class="lay-image-responsive setsizes setsizes-objectfit-cover" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$smallest_src.'" data-srcset="'.$srcset.'" sizes="" alt="'.$alt.'" '.$dataHdataW.'/>';
                            }
                        break;
                        case 'lazy_load':
                            // https://github.com/aFarkas/lazysizes/tree/gh-pages/plugins/parent-fit
                            // needs data-aspectratio: <!-- Usage of the data-aspectratio attribute: Divide width by height: 400/800 = data-aspectratio="0.5" -->
                            if( $isGif ) {
                                $this->videoMarkup .= '<img class="lay-gif lazyload" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                            }
                            if( LayFrontend_Options::$misc_options_showoriginalimages && !LTUtility::$isPhone ){
                                $this->videoMarkup .= '<img class="lay-image-original lazyload" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$full_src.'" alt="'.$alt.'"/>';
                            }
                            else{
                                $this->videoMarkup .= '<img class="lazyload" src="data:image/png;base64,R0lGODlhFAAUAIAAAP///wAAACH5BAEAAAAALAAAAAAUABQAAAIRhI+py+0Po5y02ouz3rz7rxUAOw==" data-ar="'.$ar.'" data-src="'.$smallest_src.'" data-srcset="'.$srcset.'" data-aspectratio="'.$aspect_ratio_for_lazysizes.'" data-sizes="auto" data-parent-fit="cover" alt="'.$alt.'"/>';
                            }
                        break;
                    }
                }
            }

            if ($linkMarkup != false) {
                $this->videoMarkup .= '</a>';
            } else {
                $this->videoMarkup .= '</div>';
            }
        }

        $linkForEmptyBackground = '';
		if (!$row_has_bg && $linkMarkup != false) {
            $linkMarkup .= ' class="row-bg-link no-row-bg-link-children"></a>';
            $this->linkForEmptyBackground = $linkMarkup;
		}

		// set bg color only if there is no bgvideo or bgimage. because otherwise setting the bgcolor would overlay the bgvideo/-image, because it is applied to the wrapping container
		if( $bgcolor != '' && $setBgColor ) {
            $row_has_bg = true;
            $this->row_css .= 'background-color:'.$bgcolor.';';
		}

		if( $row_has_bg ) {
			$this->row_classes .= ' has-background';
		}

        if( $relid != '' ) {
            $this->row_classes .= ' row-id-'.$relid;
        }
    }

    public function getOpeningMarkup( ){
        // todo: test row background color
        $id_attr = $this->html_id != '' ? 'id="'.$this->html_id.'"' : '';

		$collapse = array_key_exists('collapse', $this->row) ? $this->row['collapse'] : false;
        $data_collapsed = 'data-collapsed="';
        if( $collapse == true ) {
            $data_collapsed  .= 'true';
        } else {
            $data_collapsed  .= 'false';
        }
        $data_collapsed .= '"';

        // when row is collapsed, we dont add rowcustomheight_css as actual css
        // rowcustomheight_css is added through "data-original-rowcustomheight" and we use that

        // error_log(print_r($this->rowcustomheight_css, true));
        $rowcustomheight_data_attr = '';
        if( trim($this->rowcustomheight_css) !== '' ) {
            $rowcustomheight_for_data_attribute = str_replace( 'min-height:calc(', '', $this->rowcustomheight_css );
            $rowcustomheight_for_data_attribute = str_replace( ');', '', $rowcustomheight_for_data_attribute );
            $rowcustomheight_data_attr = 'data-original-rowcustomheight="'.$rowcustomheight_for_data_attribute.'"';
        }

        $inner_css_for_rowcustomheight = '';
        $temp_css = $this->row_css;
        if( $collapse == true ) {
            $temp_css .= 'height:0px;';
            $this->row_classes .= ' hide-overflow';
        } else {
            // if row is not collapsed we add the row custom height css
            $temp_css .= $this->rowcustomheight_css;
        }

        if( trim($this->rowcustomheight_css) !== '' ) {
            $inner_css_for_rowcustomheight = 'style="'.$this->rowcustomheight_css.'"';
        }

        $style = $temp_css != '' ? 'style="'.$temp_css.'"' : '';
        return
        '<div class="row '.$this->row_classes.' '.$this->html_classes.' row-'.$this->index.'" '.$rowcustomheight_data_attr.' '.$data_collapsed.' '.$id_attr.' '.$style.'>
            '.$this->backgroundImageMarkup.'
            '.$this->videoMarkup.'
            '.$this->linkForEmptyBackground.'        
            <div class="row-inner '.$this->row_inner_classes.'" '.$inner_css_for_rowcustomheight.'>
                    <div class="column-wrap '.$this->column_wrap_classes.'" '.$inner_css_for_rowcustomheight.'>';
    }

    public function getClosingMarkup( ){
        return
        '</div>
            </div>
                </div>';
    }

}