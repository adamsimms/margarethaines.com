<?php

class LaySocialMediaIcons{
    public $el;

    public function __construct($el){
        $this->el = $el;
    }

    public function getMarkup(){
        $content = $this->el['config']['content'];
        $config = $this->el['config'];
        $config_for_js = array();
        $config_for_js['desktop'] = $config['desktop'];
        $config_for_js['tablet'] = $config['tablet'];
        $config_for_js['phone'] = $config['phone'];
        $config_for_js['setwidthorheight'] = $config['setwidthorheight'];

        // error_log(print_r($config, true));

        $markup = '<div class="lay-socialmedia-icons alignment-'.$config['alignment'].'" data-config="'.htmlspecialchars(json_encode($config_for_js)).'">';
        for ($i=0; $i < count($content); $i++) {

            $img = '';
            if( array_key_exists('attid', $content[$i]) ) {
                $img = '<img src="'.wp_get_attachment_image_url($content[$i]['attid']).'" alt=""/>';
            } else {
                $img = '<img src="'.get_template_directory_uri().'/frontend/assets/img/'.$content[$i]['id'].'" alt=""/>';
            }

            $markup .= 
            '<a href="'.$content[$i]['link'].'" target="_blank" class="lay-icon-item lay-icon-use-'.$config['setwidthorheight'].'">
                <div class="lay-icon-inner">
                    '.$img.'
                </div>
            </a>';
        }
        $markup .= '</div>';
        // error_log(print_r($markup, true));
        return $markup;
    }
}