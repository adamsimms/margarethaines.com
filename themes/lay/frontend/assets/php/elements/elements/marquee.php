<?php
class LayMarquee{
    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        $config = $this->el['config'];
        $marqueeId = $this->el['relid'];

        $elements = $this->el['config']['elements'];
        $hasImage = false;
        for ($i=0; $i < count($elements); $i++) { 
            if( $elements[$i]['type'] == 'img' ) {
                $hasImage = true;
                break;
            }
        }
        // error_log(print_r($this->el, true));

        $phone_breakpoint = get_option('lay_breakpoint', 600);
        $phone_breakpoint = (int)$phone_breakpoint;

		$tablet_breakpoint = get_option( 'lay_tablet_breakpoint', 1024 );
        $tablet_breakpoint = (int)$tablet_breakpoint;

        // $currentLayout = this.props.currentLayout
		$spacebetweenDesktop = $config['desktop']['spacebetween'];
        $spacetopDesktop = $config['desktop']['spacetop'];
        $spacebottomDesktop = $config['desktop']['spacebottom'];

        $spacebetweenTablet = $config['tablet']['spacebetween'];
        $spacetopTablet = $config['tablet']['spacetop'];
        $spacebottomTablet = $config['tablet']['spacebottom'];

        $spacebetweenPhone = $config['phone']['spacebetween'];
        $spacetopPhone = $config['phone']['spacetop'];
        $spacebottomPhone = $config['phone']['spacebottom'];

        $bordertop = $config['borderTopWidth'];
        $borderbottom = $config['borderBottomWidth'];

        $bordercolor = $config['borderColor'];
        $backgroundcolor = $config['backgroundColor'];
        if( $backgroundcolor == '' ) {
            $backgroundcolor = 'transparent';
        }

        $alignment = $config['alignment'];

        $imageheightDesktop = $config['desktop']['imageheight'];
        $imageheightTablet = $config['tablet']['imageheight'];
        $imageheightPhone = $config['phone']['imageheight'];


        $css_alignment = '';
        switch ( $alignment ) {
            case 'top':
                $css_alignment = 'start';
            break;
            case 'middle':
                $css_alignment = 'center';
            break;
            case 'bottom':
                $css_alignment = 'end';
            break;
        }


        $style = 
        '<style>
        @media (min-width: '.($tablet_breakpoint+1).'px){'
            .'.lay-marquee.marquee-id-'.$marqueeId.'>div>div>div{
                padding-top: '.$spacetopDesktop.'px!important;
                padding-bottom: '.$spacebottomDesktop.'px!important;
            }
            .lay-marquee.marquee-id-'.$marqueeId.' img{
                height: '.$imageheightDesktop.'px;
            }
            .lay-marquee.marquee-has-images.marquee-id-'.$marqueeId.'>div>div,
            .lay-marquee.marquee-has-images.marquee-id-'.$marqueeId.'>div{
                min-height: '.$imageheightDesktop.'px;
            }
            .lay-marquee.marquee-id-'.$marqueeId.' > div > div > div > * {
                padding-right: '.($spacebetweenDesktop / 2).'px;
                padding-left: '.($spacebetweenDesktop / 2).'px;
                box-sizing: content-box!important;
            }
        }
        @media (max-width: '.($tablet_breakpoint).'px) and (min-width: '.($phone_breakpoint+1).'px){'
            .'.lay-marquee.marquee-id-'.$marqueeId.'>div>div>div{
                padding-top: '.$spacetopTablet.'px!important;
                padding-bottom: '.$spacebottomTablet.'px!important;
            }
            .lay-marquee.marquee-id-'.$marqueeId.' img{
                height: '.$imageheightTablet.'px;
            }
            .lay-marquee.marquee-has-images.marquee-id-'.$marqueeId.'>div>div,
            .lay-marquee.marquee-has-images.marquee-id-'.$marqueeId.'>div{
                min-height: '.$imageheightTablet.'px;
            }
            .lay-marquee.marquee-id-'.$marqueeId.' > div > div > div > * {
                padding-right: '.($spacebetweenTablet / 2).'px;
                padding-left: '.($spacebetweenTablet / 2).'px;
                box-sizing: content-box!important;
            }
        }
        @media (max-width: '.($phone_breakpoint).'px){'
            .'.lay-marquee.marquee-id-'.$marqueeId.'>div>div>div{
                padding-top: '.$spacetopPhone.'px!important;
                padding-bottom: '.$spacebottomPhone.'px!important;
            }
            .lay-marquee.marquee-id-'.$marqueeId.' img{
                height: '.$imageheightPhone.'px;
            }
            .lay-marquee.marquee-has-images.marquee-id-'.$marqueeId.'>div>div,
            .lay-marquee.marquee-has-images.marquee-id-'.$marqueeId.'>div{
                min-height: '.$imageheightPhone.'px;
            }
            .lay-marquee.marquee-id-'.$marqueeId.' > div > div > div > * {
                padding-right: '.($spacebetweenPhone / 2).'px;
                padding-left: '.($spacebetweenPhone / 2).'px;
                box-sizing: content-box!important;
            }
        }
        .lay-marquee.marquee-id-'.$marqueeId.'{
            border-top: '.$bordertop.'px solid '.$bordercolor.';
            border-bottom: '.$borderbottom.'px solid '.$bordercolor.';
            background-color: '.$backgroundcolor.';
        }
        .lay-marquee.marquee-id-'.$marqueeId.' > div > div{
            align-items: '.$css_alignment.';
        }
        </style>';

        $pauseOnHover = $config['pauseonhover'];
        $pauseOnHoverClass = $pauseOnHover ? 'marquee-pause-on-hover' : '';

        $startOnHover = array_key_exists('startonhover', $config) ? $config['startonhover'] : false;
        $startOnHoverClass = $startOnHover ? 'marquee-start-on-hover' : '';
        $hasImageClass = $hasImage ? 'marquee-has-images' : '';

        return $style.'<div class="lay-marquee '.$hasImageClass.' '.$pauseOnHoverClass.' '.$startOnHoverClass.' marquee-id-'.$marqueeId.'" data-config="'.htmlspecialchars(json_encode($config)).'"></div>';
    }
}