<?php 

class Lay_Footer{

    public function __construct(){

    }

    // todo: maybe add throw an exception https://laravel-news.com/php-7-3-json-error-handling
    // todo: test if footer was set, but i delete the footer page
    public static function getFooterId($postid, $type){
        $footerId = "";
        switch($type){
            case 'project':
                switch(LayFrontend_Options::$footer_active_in_projects){
                    case 'all':
                        $footerId = LayFrontend_Options::$projectsFooterId;
                    break;
                    case 'individual':
                        $arr = json_decode(LayFrontend_Options::$individual_project_footers, true);
                        if( is_array($arr) ){
                            if( array_key_exists($postid, $arr) ){
                                $footerId = $arr[$postid];
                            }
                        }
                    break;
                }
            break;
            case 'page':
            case 'product':
                switch(LayFrontend_Options::$footer_active_in_pages){
                    case 'all':
                        $footerId = LayFrontend_Options::$pagesFooterId;
                    break;
                    case 'individual':
                        $arr = json_decode(LayFrontend_Options::$individual_page_footers, true);
                        if( is_array($arr) ){
                            if( array_key_exists($postid, $arr) ){
                                $footerId = $arr[$postid];
                            }
                        }
                    break;
                }
            break;
            case 'archive':
            case 'category':
                switch(LayFrontend_Options::$footer_active_in_categories){
                    case 'all':
                        $footerId = LayFrontend_Options::$categoriesFooterId;
                    break;
                    case 'individual':
                        $arr = json_decode(LayFrontend_Options::$individual_category_footers, true);
                        if( is_array($arr) ){
                            if( array_key_exists($postid, $arr) ){
                                $footerId = $arr[$postid];
                            }
                        }
                    break;
                }
            break;
            case 'news':
            case 'lay_news':
                switch(LayFrontend_Options::$footer_active_in_news){
                    case 'all':
                        $footerId = LayFrontend_Options::$newsFooterId;
                    break;
                    case 'individual':
                        $arr = json_decode(LayFrontend_Options::$individual_news_footers, true);
                        if( is_array($arr) ){
                            if( array_key_exists($postid, $arr) ){
                                $footerId = $arr[$postid];
                            }
                        }
                    break;
                }
            break;
        }

        if( class_exists( 'PLL_Switcher' ) ){
            $footerId = pll_get_post($footerId);
        }

        return $footerId;
    }

    public static function getFooterJSON($postid, $type){

        $footerId = Lay_Footer::getFooterId($postid, $type);
        if($footerId != ''){
            $desktop = get_post_meta( $footerId, '_gridder_json', true );
            $phone = get_post_meta( $footerId, '_phone_gridder_json', true );
            return array( 'desktop' => $desktop, 'phone' => $phone );
        }
        return false;
    }

    // missing: showFooter from footer_controller.js and destroyFooter

}
new Lay_Footer();