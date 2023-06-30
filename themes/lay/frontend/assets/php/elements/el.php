<?php

require get_template_directory().'/frontend/assets/php/elements/elements/carousel.php';
require get_template_directory().'/frontend/assets/php/elements/elements/elementgrid.php';
require get_template_directory().'/frontend/assets/php/elements/elements/embed.php';
require get_template_directory().'/frontend/assets/php/elements/elements/hr.php';
require get_template_directory().'/frontend/assets/php/elements/elements/html.php';
require get_template_directory().'/frontend/assets/php/elements/elements/html5video.php';
require get_template_directory().'/frontend/assets/php/elements/elements/img.php';
require get_template_directory().'/frontend/assets/php/elements/elements/shortcode.php';
require get_template_directory().'/frontend/assets/php/elements/elements/stack.php';
require get_template_directory().'/frontend/assets/php/elements/elements/text.php';
require get_template_directory().'/frontend/assets/php/elements/elements/thumbnail.php';
require get_template_directory().'/frontend/assets/php/elements/elements/thumbnailgrid.php';
require get_template_directory().'/frontend/assets/php/elements/elements/video.php';
require get_template_directory().'/frontend/assets/php/elements/elements/productsgrid.php';
require get_template_directory().'/frontend/assets/php/elements/elements/textfooter.php';
require get_template_directory().'/frontend/assets/php/elements/elements/projectindex.php';
require get_template_directory().'/frontend/assets/php/elements/elements/socialmediaicons.php';
require get_template_directory().'/frontend/assets/php/elements/elements/newselement.php';
require get_template_directory().'/frontend/assets/php/elements/elements/marquee.php';
require get_template_directory().'/frontend/assets/php/elements/elements/vl.php';

class LayEl{

    public $type;
    public $markup = '';
    public $el_arr;
    public $device = '';

    public function __construct($el_arr, $is_inside_stack = false, $postid = -1, $device = 'desktop'){
        $this->el_arr = $el_arr;
        $this->device = $device;
        // TYPE
        $this->type = $el_arr['type'];
        // for backwards compatibility
        $isProjectLink = array_key_exists( 'postid', $el_arr ) ? true : false;
        if(($this->type == 'img' && $isProjectLink) || $this->type == 'postThumbnail'){
            $this->type = 'thumbnail';
        }

        // error_log(print_r($this, true));

        $element = false;
        $elements_in_stack = array();

        switch($this->type){
            case "thumbnail":
                $element = new LayThumbnail($el_arr);
			break;
            case "text":
                $element = new LayText($el_arr, $device);
			break;
            case "embed":
                $element = new LayEmbed($el_arr);
			break;
            case "html":
                $element = new LayHTML($el_arr);
			break;
            case "shortcode":
                $element = new LayShortcode($el_arr);
			break;
            case "hr":
                $element = new LayHr($el_arr);
			break;
            case "vl":
                $element = new LayVl($el_arr);
			break;
            case "thumbnailgrid":
                $element = new LayThumbnailGrid($el_arr, $postid);
			break;
            case "elementgrid":
                $element = new LayElementGrid($el_arr, $device);
			break;
            case "carousel":
                $element = new LayCarousel($el_arr);
			break;
            case "img":
                $element = new LayImg($el_arr);
			break;
            case "html5video":
                $element = new LayHTML5Video($el_arr);
			break;
            case "video":
                $element = new LayVideo($el_arr);
			break;
            case "stack":
                $stack_el_arr = $el_arr['cont'];
                foreach( $stack_el_arr as $el ) {
                    $elements_in_stack []= new LayEl($el, true, -1, $device);
                }
            break;
            case "productsgrid":
                $element = new LayProductsgrid($el_arr);
            break;
            case "textfooter":
                $element = new LayTextFooter($el_arr);
            break;
            case "projectindex":
                $element = new LayProjectIndex($el_arr);
            break;
            case "socialmediaicons":
                $element = new LaySocialMediaIcons($el_arr);
            break;
            case 'news':
                $element = new LayNewsElement($el_arr);
            break;
            case 'marquee':
                $element = new LayMarquee($el_arr);
            break;
        }
        
        if( count($elements_in_stack) > 0 ) {
            foreach( $elements_in_stack as $el ) {
                $col = new LayCol($el->el_arr);
                
                $this->markup .= 
                '<div class="stack-element" style="width: 100%;">'
                    .$col->getOpeningMarkup()
                        .$el->getMarkup()
                    .$col->getClosingMarkup()
                .'</div>';
            }
        }
        else if( $element ) {
            $this->markup = $element->getMarkup();
        }

    }

    public function getMarkup(){
        return $this->markup;
    }

}