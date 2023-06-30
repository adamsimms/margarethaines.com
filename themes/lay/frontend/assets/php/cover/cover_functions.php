<?php

class LayCoverFunctions {

    public function __construct(){

    }

    public static function hasCover($type, $id) {
        if( LayFrontend_Options::$misc_options_cover == false ) {
            return false;
        }
        // todo: use isPhoneSize instead of isPhone
        // todo: test this
        if(LayFrontend_Options::$cover_disable_for_phone == "on" && LTUtility::$isPhone){
            return false;
        }
        return LayCoverFunctions::hasCoverForReal($type, $id);
    }

    public static function hasCoverForReal($type, $id) {
        $id = (int)$id;

        switch($type){
            case 'project':
                if(LayFrontend_Options::$cover_active_in_projects == "all"){
                    return true;
                }else if(LayFrontend_Options::$cover_active_in_projects == "individual" && LayFrontend_Options::$cover_individual_project_ids != ""){
                    $array = json_decode(LayFrontend_Options::$cover_individual_project_ids, true);
                    if( in_array( $id, $array ) ) {
                        return true;
                    }
                }
            break;
            case 'page':
                if(LayFrontend_Options::$cover_active_in_pages == "all"){
                    return true;
                }else if(LayFrontend_Options::$cover_active_in_pages == "individual" && LayFrontend_Options::$cover_individual_page_ids != ""){
                    $array = json_decode(LayFrontend_Options::$cover_individual_page_ids, true);
                    if( in_array( $id, $array ) ) {
                        return true;
                    }
                }
            break;
            case 'category':
                if(LayFrontend_Options::$cover_active_in_categories == "all"){
                    return true;
                }else if(LayFrontend_Options::$cover_active_in_categories == "individual" && LayFrontend_Options::$cover_individual_category_ids != ""){
                    $array = json_decode(LayFrontend_Options::$cover_individual_category_ids, true);
                    if( in_array( $id, $array ) ) {
                        return true;
                    }
                }
            break;
        }
        return false;
    }

}
new LayCoverFunctions();