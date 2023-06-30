<?php
require get_template_directory().'/frontend/assets/php/layout_functions.php';
require get_template_directory().'/frontend/assets/php/footer/footer.php';
require get_template_directory().'/frontend/assets/php/row/row_functions.php';
require get_template_directory().'/frontend/assets/php/row/row.php';
require get_template_directory().'/frontend/assets/php/col/col.php';
require get_template_directory().'/frontend/assets/php/elements/el_functions.php';
require get_template_directory().'/frontend/assets/php/elements/thumbnailgrid_functions.php';
require get_template_directory().'/frontend/assets/php/elements/el.php';
require get_template_directory().'/frontend/assets/php/cover/cover.php';
require get_template_directory().'/frontend/assets/php/cover/cover_functions.php';
require get_template_directory().'/frontend/assets/php/password_screen.php';

// todo: add lay-col-needs-leftframe-margin
class Lay_Layout{

    public function __construct(){
        add_action( 'wp_ajax_get_laytheme_layout', array( $this, 'getLayoutAjax' ) );
        add_action( 'wp_ajax_nopriv_get_laytheme_layout', array( $this, 'getLayoutAjax' ) );
    }

    public static function getLayoutAjax(){
        $id = $_POST['id'];
        $type = $_POST['type'];
        $password = $_POST['password'];
        $layout = Lay_Layout::getLayout($id, $type, $password);
        echo json_encode($layout);
        wp_die();
    }

    public static function getLayoutInit(){
        $data = Frontend::$current_type_id_slug_catid;
        // error_log(print_r('getLayoutInit', true));
        // error_log(print_r($data, true));
        $id = $data["id"];
        $type = $data["type"];
        $slug = $data["slug"];
        $layout = Lay_Layout::getLayout($id, $type);
        return $layout['markup'];
    }

    // todo: password protection
    // todo: custom phone layout: only load content and play videos when it is visible?

    // I need layoutObj, type and obj for the newpageshown event
    // getLayout returns an array of "markup", "layoutObj", "type", "obj". These are needed for the newpageshown javascript event
    // It also returns a "notification" array member, used for password protection status, so my javascript can shake the password input on wrongpassword

    // todo: split this function? getLayout

    // when $getFullLayout == false, then cover and footer are not returned
    // this is for the news full content layout
    public static function getLayout($id, $type, $password = '', $getFullLayout = true, $getImageHover = true) {

        $password_status = Lay_Password_Screen::getPasswordStatus($id, $type, $password);

        switch( $password_status ) {
            case 'protected':
                return array(
                    'markup' => Lay_Password_Screen::getPasswordScreen(),
                    'type' => $type,
                    'layoutObj' => '',
                    'obj' => '',
                    'notification' => 'protected'
                );
            break;
            case 'wrongpassword':
                return array(
                    'markup' => '',
                    'type' => $type,
                    'layoutObj' => '',
                    'obj' => '',
                    'notification' => 'wrongpassword'
                );
            break;
        }

        // no password protection, just continue

        $desktop_json = '';
        $cpl_json = '';
        $desktop_footer_json = '';
        $cpl_footer_json = '';

        // for newpageshown event:
        $layoutObj;
        $obj = array( 
            'id' => '',
            'type' => '',
            'slug' => '',
            'catid' => ''
        );

        // cover
        $cover_on_desktop = LayCoverFunctions::hasCover( $type, $id );
        $desktop_cover_is_100vh_set_by_user = false;
        $cover_on_phone = $cover_on_desktop && LayFrontend_Options::$cover_disable_for_phone == false ? true : false;

        // disable cover for desktop and phone when magnetic slides is active, because cover feature is incompatible with magnetic slides feature
        $magnetic_slides_active = false;
        if( class_exists('LayThemeMagneticSlides') && method_exists('LayThemeMagneticSlides', 'isActiveHere') && $getFullLayout == true ){
            $magnetic_slides_active = LayThemeMagneticSlides::isActiveHere($id, $type);
            if( $magnetic_slides_active == true ) {
                $cover_on_desktop = false;
            }
        }
        $magnetic_slides_active_on_phone = false;
        if( class_exists('LayThemeMagneticSlides') && method_exists('LayThemeMagneticSlides', 'activeOnPhone') && $getFullLayout == true ){
            if( LayThemeMagneticSlides::activeOnPhone() == true && $magnetic_slides_active ) {
                $magnetic_slides_active_on_phone = true;
            }
            if( $magnetic_slides_active_on_phone == true ){
                $cover_on_phone = false;
            }
        }

        if( $getFullLayout == false ) {
            $cover_on_desktop = false;
            $cover_on_phone = false;
        }

        switch($type){
            case "archive":
                $queried_obj = get_queried_object();
                // "shop" page is an archive
                $desktop_json = get_post_meta( $id, '_gridder_json', true );
                $cpl_json = get_post_meta( $id, '_phone_gridder_json', true );
                $obj['id'] = $id;
                $obj['slug'] = $queried_obj->name;
                $obj['type'] = 'archive';
                $obj['catid'] = '';
            break;
            case "category":
                $desktop_json = get_option($id."_category_gridder_json", '');
                $cpl_json = get_option( $id.'_phone_category_gridder_json', '' );
                $term = get_term($id);
                $obj['id'] = $term->term_id;
                $obj['slug'] = $term->slug;
                $obj['type'] = 'category';
                $obj['catid'] = array($term->term_id);
            break;
            case "project":
                $desktop_json = get_post_meta( $id, '_gridder_json', true );
                $cpl_json = get_post_meta( $id, '_phone_gridder_json', true );
                $post = get_post($id);
                $obj['id'] = $post->ID;
                $obj['slug'] = $post->post_name;
                $obj['type'] = 'project';
                $obj['catid'] = wp_get_post_categories($post->ID, array('fields'=>'ids'));
            break;
            case "page":
                $desktop_json = get_post_meta( $id, '_gridder_json', true );
                $cpl_json = get_post_meta( $id, '_phone_gridder_json', true );
                $page = get_post($id);
                $obj['id'] = $page->ID;
                $obj['slug'] = $page->post_name;
                $obj['type'] = 'page';
                $obj['catid'] = '';
            break;
            case "news":
            case "lay_news":
                $desktop_json = get_post_meta( $id, '_gridder_json', true );
                $cpl_json = get_post_meta( $id, '_phone_gridder_json', true );
                $lay_news = get_post($id);
                $obj['id'] = $lay_news->ID;
                $obj['slug'] = $lay_news->post_name;
                $obj['type'] = 'lay_news';
                $obj['catid'] = '';
            break;
        }

        // no content, like when someone didnt create a page yet but that page is shown on frontend
        // if( $desktop_json == '' ) {
        //     return array(
        //         'markup' => '<div class="lay-content lay-empty"></div>',
        //         'type' => $type,
        //         'layoutObj' => '',
        //         'obj' => '',
        //         'notification' => 'success'
        //     );
        // }

        $footer_json_array = Lay_Footer::getFooterJSON($id, $type);

        if( is_array( $footer_json_array ) ) {
            $desktop_footer_json = array_key_exists('desktop', $footer_json_array) ? $footer_json_array['desktop'] : '';
            $cpl_footer_json = array_key_exists('phone', $footer_json_array) ? $footer_json_array['phone'] : '';
        }

        // decode JSON
        $desktop_arr = json_decode($desktop_json, true);
        $cpl_arr = json_decode($cpl_json, true);
        $footer_desktop_arr = json_decode($desktop_footer_json, true);
        $cpl_footer_arr = json_decode($cpl_footer_json, true);

        // for newpageshown event:
        $layoutObj = $desktop_arr;

        // prepare Rows
        $desktop_rows = false;
        $cpl_rows = false;
        $desktop_footer_rows = false;
        $cpl_footer_rows = false;
        $desktop_cover_row = false;
        $cpl_cover_rows = false;

        // markups
        $desktop_freely_placed_els = '';
        $desktop_cover_markup = false;
        $desktop_cover_freely_placed_els = false;
        $desktop_markup = false;
        $cpl_markup = false;
        $cpl_freely_placed_els = '';
        $cpl_cover_freely_placed_els = false;
        $cpl_cover_markup = false;
        $desktop_footer_markup = false;
        $footer_desktop_freely_placed_els = false;
        
        $cpl_footer_markup = false;
        $cpl_row_col_el_markup = false;
        $cpl_footer_freely_placed_els = false;

        // DESKTOP
        if( is_array($desktop_arr) ){
            $desktop_freely_placed_els = Lay_Layout::getFreelyPlacedCols($desktop_arr, $obj['id'], 'desktop', $cover_on_desktop ? 'outside-cover': 'all');
            $desktop_rows = Lay_Layout::prepareRows($desktop_arr, $cover_on_desktop);
        }
        // split up rows into cover row and desktop rows
        if( $cover_on_desktop && is_array( $desktop_rows ) ) {
            // https://www.php.net/manual/en/function.array-shift.php
            $desktop_cover_row = array_shift( $desktop_rows );
            $desktop_cover_is_100vh_set_by_user = Lay_LayoutFunctions::getRowIs100vh($desktop_cover_row);
            $desktop_cover_row['row100vh'] = true;
            $desktop_cover_row['rowcustomheight'] = '';
            $desktop_cover_row = array($desktop_cover_row);
            $desktop_cover_markup = Lay_Layout::getRowColElMarkup($desktop_cover_row, $obj['id'], 'desktop');
            $desktop_cover_freely_placed_els = Lay_Layout::getFreelyPlacedCols($desktop_arr, $obj['id'], 'desktop', 'in-cover');
        }
        if( is_array($desktop_arr) ){
            $desktop_markup = Lay_Layout::getRowColElMarkup($desktop_rows, $obj['id'], 'desktop');
        }

        // CPL
        if( is_array($cpl_arr) ){
            $cpl_freely_placed_els = Lay_Layout::getFreelyPlacedCols($cpl_arr, $obj['id'], 'phone', $cover_on_phone ? 'outside-cover': 'all');
            $cpl_rows = Lay_Layout::prepareRows($cpl_arr, $cover_on_phone);
        }
        // split up rows into cover row and phone rows
        if( $cover_on_phone && is_array($cpl_arr) ){
            // https://www.php.net/manual/en/function.array-shift.php
            $cpl_cover_rows = array_shift( $cpl_rows );
            $cpl_cover_rows['row100vh'] = true;
            $cpl_cover_rows['rowcustomheight'] = '';
            $cpl_cover_rows = array($cpl_cover_rows);
            $cpl_cover_markup = Lay_Layout::getRowColElMarkup($cpl_cover_rows, $obj['id'], 'phone');
            $cpl_cover_freely_placed_els = Lay_Layout::getFreelyPlacedCols($cpl_arr, $obj['id'], 'phone', 'in-cover');
        }
        if( is_array($cpl_arr) ){
            $cpl_row_col_el_markup = Lay_Layout::getRowColElMarkup($cpl_rows, $obj['id'], 'phone');
        }

        // FOOTER
        if( is_array($footer_desktop_arr) && $getFullLayout == true ){
            $desktop_footer_rows = Lay_Layout::prepareRows($footer_desktop_arr, false);
            $desktop_footer_markup = Lay_Layout::getRowColElMarkup($desktop_footer_rows, $obj['id'], 'desktop');
            $footer_desktop_freely_placed_els = Lay_Layout::getFreelyPlacedCols($footer_desktop_arr, $obj['id'], 'desktop');
        }
        if( is_array($cpl_footer_arr) && $getFullLayout == true ){
            $cpl_footer_rows = Lay_Layout::prepareRows($cpl_footer_arr, false);
            $cpl_footer_markup = Lay_Layout::getRowColElMarkup($cpl_footer_rows, $obj['id'], 'phone');
            $cpl_footer_freely_placed_els = Lay_Layout::getFreelyPlacedCols($cpl_footer_arr, $obj['id'], 'phone');
        }

        // Custom Phone Layout
        $cpl_exists_html_class = 'nocustomphonegrid';
        $cover_cpl_class = '';
        if( LayFrontend_Options::$phone_layout_active && is_array($cpl_arr) ) {
            // Cover CPL
            $cover_cpl_class = 'cpl-nocover';
            $cpl_cover_rowgutter_css = '';
            $cover_cpl_css = '';
            // todo: && !isFullscreenSliderActive()
            // if( cover_controller.hasCover(type, obj.id) && !isFullscreenSliderActive() ){
            if( $cover_on_phone ) {
                $cover_cpl_class = 'cpl-hascover';
                $cover_cpl_css = Lay_LayoutFunctions::getGridCSS($cpl_arr, '.cover-region-phone', true);
                $cover_cpl_css .= Lay_LayoutFunctions::getHorizontalGridCSS($cpl_arr, '.cover-region-phone', true);
                // set main grid padding-top to first rowgutter
                $cpl_cover_rowgutter_css = Lay_LayoutFunctions::getFirstRowGutterAsPaddingTopForCoverCSS($cpl_arr, '#custom-phone-grid', true);
                // need .cover-inner so the grid's background color can overwrite the global background color set in customizer
                $cpl_cover_markup = 
                '<div class="cover-region cover-region-phone _100vh">
                    <div class="cover-inner _100vh">
                        '.$cpl_cover_markup.'
                        '.$cpl_cover_freely_placed_els.'
                    </div>
                    '.Lay_LayoutFunctions::getCoverDownArrowMarkup(array('phoneOnly' => false)).'
                </div>
                <div class="cover-region-placeholder cover-region-placeholder-phone _100vh"></div>';
            }

            $cpl_exists_html_class = 'hascustomphonegrid';
            $cpl_css = Lay_LayoutFunctions::getGridCSS($cpl_arr, '#custom-phone-grid', true);
            $cpl_css .= Lay_LayoutFunctions::getHorizontalGridCSS($cpl_arr, '#custom-phone-grid', true);

            $cpl_frame_css = Lay_LayoutFunctions::getGridFrameCSS($cpl_arr, '#custom-phone-grid', '#custom-phone-grid', true);
            if( $cover_on_phone ) {
                $cpl_frame_css = Lay_LayoutFunctions::getGridFrameCSS($cpl_arr, '.cover-region-phone .cover-inner', '#custom-phone-grid', true);
            }
            $cpl_rows_css = Lay_LayoutFunctions::getRowsMarginBottomCSS($cpl_arr, $cpl_rows, '#custom-phone-grid', true);
            $cpl_background_color_css = Lay_LayoutFunctions::getBackgroundCSS($cpl_arr, '#custom-phone-grid, .cover-region-phone .cover-inner');
            $cpl_background_image_css = Lay_LayoutFunctions::getBackgroundImageCSS($cpl_arr, '#custom-phone-grid, .cover-region-phone .cover-inner');     

            $cpl_empty_class = Lay_Layout::isEmptyLayout($cpl_rows) && $cpl_freely_placed_els == '' ? 'lay-empty' : 'lay-not-empty';

            $cpl_markup = 
                '<!-- Start CPL Layout -->'
                .$cpl_cover_rowgutter_css
                .$cover_cpl_css
                .$cpl_cover_markup;
                if( $cover_on_phone ) {
                    // need cover content wrap, so i can set global bg color and bg image to it
                    // the inner div: .grid can now be set to the grid-specific background-color, overwriting .cover-content's background
                    // i cannot just set the global background color or background image to an outer div like .lay-content, because then ->
                    // when cover would be active and i would scroll down, the transparent div that is on top of the cover would not hide it beneath
                    $cpl_markup .= '<div class="cover-content cover-content-phone">';
                }
                // need .grid-inner wrapper so I can have a fullscreen slider that is horizontal
                $cpl_markup .= 
                '<div id="custom-phone-grid" class="grid '.$cpl_empty_class.'">
                    <div class="grid-inner">
                        '.$cpl_frame_css.'
                        '.$cpl_rows_css.'
                        '.$cpl_css.'
                        '.$cpl_background_color_css.'
                        '.$cpl_background_image_css.'
                        '.$cpl_freely_placed_els.'
                        '.$cpl_row_col_el_markup.'
                    </div>
                </div>';
                if( $cover_on_phone ) {
                    $cpl_markup .= '</div>';
                }
                $cpl_markup .= 
                '<!-- End CPL Layout -->';
        }

        // Footer Custom Phone Layout
        $footer_cpl_markup = '';
        $footer_cpl_exists_html_class = 'footer-nocustomphonegrid';
        if( LayFrontend_Options::$phone_layout_active && is_array($cpl_footer_arr) ) {
            $footer_cpl_exists_html_class = 'footer-hascustomphonegrid';
            $footer_cpl_css = Lay_LayoutFunctions::getGridCSS($cpl_footer_arr, '#footer-custom-phone-grid', true);
            $footer_cpl_css .= Lay_LayoutFunctions::getHorizontalGridCSS($cpl_footer_arr, '#footer-custom-phone-grid', true);

            $footer_cpl_frame_css = Lay_LayoutFunctions::getGridFrameCSS($cpl_footer_arr, '#footer-custom-phone-grid', '#footer-custom-phone-grid', true);
            $footer_cpl_rows_css = Lay_LayoutFunctions::getRowsMarginBottomCSS($cpl_footer_arr, $cpl_footer_rows, '#footer-custom-phone-grid', true);
            $footer_cpl_background_color_css = Lay_LayoutFunctions::getBackgroundCSS($cpl_footer_arr, '#footer-custom-phone-grid');
            $footer_cpl_background_image_css = Lay_LayoutFunctions::getBackgroundImageCSS($cpl_footer_arr, '#footer-custom-phone-grid');     

            $footer_cpl_markup = 
            '<div id="footer-custom-phone-grid" class="grid">
                '.$footer_cpl_frame_css.'
                '.$footer_cpl_rows_css.'
                '.$footer_cpl_css.'
                '.$footer_cpl_background_color_css.'
                '.$footer_cpl_background_image_css.'
                '.$cpl_footer_markup.'
                '.$cpl_footer_freely_placed_els.'
            </div>';
        }

        // Desktop CSS
        $desktop_css = '';
        $desktop_frame_css = '';
        $desktop_rows_css = '';
        $background_color_css = '';
        $background_image_css = '';
        
        if( is_array($desktop_arr) ) {
            $desktop_css = Lay_LayoutFunctions::getGridCSS($desktop_arr, '#grid.id-'.$id, false);
            $desktop_css .= Lay_LayoutFunctions::getHorizontalGridCSS($desktop_arr, '#grid.id-'.$id, false);
            $desktop_frame_css = Lay_LayoutFunctions::getGridFrameCSS($desktop_arr, '#grid.id-'.$id, '#grid.id-'.$id, false);
            if( $cover_on_desktop ){
                $desktop_frame_css = Lay_LayoutFunctions::getGridFrameCSS($desktop_arr, '.cover-region-desktop .cover-inner', '#grid.id-'.$id, false);
            }
            $desktop_rows_css = Lay_LayoutFunctions::getRowsMarginBottomCSS($desktop_arr, $desktop_rows, '#grid.id-'.$id, false);
            // need to set background color for .cover-inner too because it is not inside #grid div
            $background_color_css = Lay_LayoutFunctions::getBackgroundCSS($desktop_arr, '#grid.id-'.$id.', .cover-region-desktop .cover-inner');   
            $background_image_css = Lay_LayoutFunctions::getBackgroundImageCSS($desktop_arr, '#grid.id-'.$id.', .cover-region-desktop .cover-inner');     
        }
        
        // Is there a footer?

        // Footer Desktop CSS
        $desktop_footer_css = '';
        $desktop_frame_footer_css = '';
        $desktop_rows_footer_css = '';
        $background_color_footer_css = '';

        if( is_array($footer_desktop_arr) ){
            $desktop_footer_css = Lay_LayoutFunctions::getGridCSS($footer_desktop_arr, '#footer', false);
            $desktop_footer_css .= Lay_LayoutFunctions::getHorizontalGridCSS($footer_desktop_arr, '#footer', false);
            $desktop_frame_footer_css = Lay_LayoutFunctions::getGridFrameCSS($footer_desktop_arr, '#footer', '#footer', false);
            $desktop_rows_footer_css = Lay_LayoutFunctions::getRowsMarginBottomCSS($footer_desktop_arr, $desktop_footer_rows, '#footer', false);
            $background_color_footer_css = Lay_LayoutFunctions::getBackgroundCSS($footer_desktop_arr, '#footer');    
        }

        // Cover
        // todo: cover disabled for phone
        $cover_desktop_class = 'nocover';
        // todo: && !isFullscreenSliderActive()
        // if( cover_controller.hasCover(type, obj.id) && !isFullscreenSliderActive() ){
        $desktop_cover_rowgutter_css = '';
        $cover_desktop_css = '';
        if( $cover_on_desktop ){
            $cover_desktop_class = 'hascover';
            $cover_desktop_css = Lay_LayoutFunctions::getGridCSS($desktop_arr, '.cover-region', false);
            $cover_desktop_css .= Lay_LayoutFunctions::getHorizontalGridCSS($desktop_arr, '.cover-region', false);
            // set main grid padding-top to first rowgutter
            $desktop_cover_rowgutter_css = Lay_LayoutFunctions::getFirstRowGutterAsPaddingTopForCoverCSS($desktop_arr, '#grid.id-'.$id);
            
            // need .cover-inner so the grid's background color can overwrite the global background color set in customizer

            // ok so when we have a cover on desktop, but cover is disabled for phone, 
            // i dont want the cover row to be 100vh on APL if the user hasn't set it to be 100vh explicitly for phone
            // APL = automatically generated phone layout
            $_100vh_set_by_user_class = $desktop_cover_is_100vh_set_by_user ? '_100vh-set-by-user' : '_100vh-not-set-by-user';
            $desktop_cover_markup = 
            '<div class="cover-region cover-region-desktop _100vh '.$_100vh_set_by_user_class.'">
                <div class="cover-inner _100vh">
                    '.$desktop_cover_markup.'
                    '.$desktop_cover_freely_placed_els.'
                </div>
                '.Lay_LayoutFunctions::getCoverDownArrowMarkup(array('phoneOnly' => false)).'
            </div>
            <div class="cover-region-placeholder cover-region-placeholder-desktop _100vh"></div>';
        }

        // this is not for cpl but just so i can disable cover via css on phone version of the page
        $cover_disabled_on_phone_class = LayFrontend_Options::$cover_disable_for_phone == true ? 'cover-disabled-on-phone' : 'cover-enabled-on-phone';

        if( $getFullLayout == false ) {
            $cover_disabled_on_phone_class = 'cover-disabled-on-phone';
        }

        $hover_image_markup = '';
        if( is_plugin_active( 'laytheme-imagehover/laytheme-imagehover.php' ) && $getImageHover ) {
            $all_rows = array($desktop_rows, $cpl_rows, $desktop_footer_rows, $cpl_footer_rows, $desktop_cover_row, $cpl_cover_rows);
            $array_to_merge_to = array();
            LayRowFunctions::mergeAllRows($all_rows, $array_to_merge_to);
            $hover_image_markup = '<div class="lay-imagehover-region">'.LayThemeImagehover::getMarkup( $array_to_merge_to, $desktop_markup.$desktop_freely_placed_els.$desktop_footer_markup.$footer_desktop_freely_placed_els ).'</div>';
        }

        // todo: add lay-empty class to cover row too, and cpl cover row and to footer!
        // error_log(print_r($desktop_rows, true));
        $desktop_empty_class = Lay_Layout::isEmptyLayout($desktop_rows) && $desktop_freely_placed_els == '' ? 'lay-empty' : 'lay-not-empty';

        $markup =
        '<div class="lay-content '.$cpl_exists_html_class.' '.$footer_cpl_exists_html_class.' '.$cover_desktop_class.' '.$cover_cpl_class.' '.$cover_disabled_on_phone_class.'">
            <!-- Start Desktop Layout -->
            '.$desktop_cover_rowgutter_css.'
            '.$cover_desktop_css.'
            '.$desktop_cover_markup;
            if( $cover_on_desktop == true ) {
                // need cover content wrap, so i can set global bg color and bg image to it
                // the inner div: .grid can now be set to the grid-specific background-color, overwriting .cover-content's background
                // i cannot just set the global background color or background image to an outer div like .lay-content, because then ->
                // when cover would be active and i would scroll down, the transparent div that is on top of the cover would not hide it beneath
                $markup .= '<div class="cover-content cover-content-desktop">';
            }
            // need .grid-inner wrapper so I can have a fullscreen slider that is horizontal
            $markup .= 
            '<div id="grid" class="grid '.$desktop_empty_class.' id-'.$id.'">
                <div class="grid-inner">
                '.$desktop_frame_css.'
                '.$desktop_rows_css.'
                '.$desktop_css.'
                '.$background_color_css.'
                '.$background_image_css.'
                '.$desktop_freely_placed_els.'
                '.$desktop_markup.'
                </div>
            </div>';
            if( $cover_on_desktop == true ) {
                // closing .cover-content
                $markup .= '</div>';
            }
            $markup .= 
            '<!-- End Desktop Layout -->'
            .$cpl_markup;
            if( $getFullLayout == true ) {
                $markup .= 
                '<div id="footer-region">';
                if( is_array($footer_desktop_arr) ){
                    $markup .=
                    '<div id="footer" class="footer">
                        '.$desktop_frame_footer_css.'
                        '.$desktop_rows_footer_css.'
                        '.$desktop_footer_css.'
                        '.$background_color_footer_css.'
                        '.$footer_desktop_freely_placed_els.'
                        '.$desktop_footer_markup.'
                    </div>';
                }
                $markup .=
                    $footer_cpl_markup.
                '</div>';
            }
            $markup .= 
            $hover_image_markup.
        '</div>';

        return array(
            'markup' => $markup,
            'type' => $type,
            'layoutObj' => $layoutObj,
            'obj' => $obj,
            'notification' => 'success'
        );
    }

    // a layout is empty if there are no elements inside of it
    // todo: layout should not be empty if a row is empty but has a background image or background video
    public static function isEmptyLayout($layout_array){
        if( is_array($layout_array) && count($layout_array) > 0 ){
            $isempty = true;
            for ($i=0; $i < count($layout_array); $i++) { 
                if( array_key_exists('columns', $layout_array[$i]) ) {
                    if( !empty($layout_array[$i]['columns']) ) {
                        $isempty = false;
                        break;
                    }
                }
                if( array_key_exists('bgimage', $layout_array[$i]) ) {
                    if( !empty($layout_array[$i]['bgimage']) ) {
                        $isempty = false;
                        break;
                    }
                }
                if( array_key_exists('bgvideo', $layout_array[$i]) ) {
                    if( !empty($layout_array[$i]['bgvideo']) ) {
                        $isempty = false;
                        break;
                    }
                }
            }

            return $isempty;
        }
        return true;
    }

    public static function getFreelyPlacedCols($grid_arr, $postid, $device, $specifier = 'all') {
        // $specifier can be "all" or "in-cover" or "outside-cover"
        // this is for splitting up markup into cover and markup below
        $freelyPlacedEls = array();
        $cols = $grid_arr['cont'];
        $markup = '';
        for( $i=0; $i<count($cols); $i++ ){
            $col = $cols[$i];
            if ( array_key_exists('placeFreely', $col) ){
                if( $specifier == 'in-cover' ) {
                    if($col['row'] > 0) {
                        continue;
                    }
                } else if( $specifier == 'outside-cover' ) {
                    if($col['row'] == 0) {
                        continue;
                    }
                }
                $layCol = new LayCol($col, false);
                $layEl = new LayEl($col, false, $postid, $device);
                $elMarkup = $layEl->getMarkup();
                if( $elMarkup != '' ) {
                    $markup .= $layCol->getOpeningMarkup();
                    $markup .= $elMarkup;
                    $markup .= $layCol->getClosingMarkup();;
                }
            }
        }
        return $markup;
    }

    public static function prepareRows($grid_arr, $cover_active) {
        if( $grid_arr == null ) {
            return false;
        }

        $cols = $grid_arr['cont'];
        $rowAttrs = array_key_exists( 'rowAttrs', $grid_arr ) ? $grid_arr['rowAttrs'] : false;
        $rowAmt = count($grid_arr['rowGutters']) + 1;
        $rows = array();
        $cover = null;

        // create row objects in an array, possibly with row attributes
        for( $i = 0; $i < $rowAmt; $i++ ){
            $rows []= array();
            if( is_array($rowAttrs) ) {
                if( array_key_exists($i, $rowAttrs) ) {
                    $rows[$i] = $rowAttrs[$i];
                }
            }
            // add row gutter
            if( array_key_exists($i, $grid_arr['rowGutters']) ){
                $rows[$i]['rowGutter'] = $grid_arr['rowGutters'][$i];
            }
            $rows[$i]['columns'] = array();
        }

        if( $cover_active == true ) {
            $rows[0]['row100vh'] = 1;
            $rows[0]['rowcustomheight'] = '';
        }

        // loop through all columns and put them into their according row's .columns
        if( $cols ) {

            $reorder_cols = false;

            for( $i=0; $i<count($cols); $i++ ){
                if ( !array_key_exists('placeFreely', $cols[$i]) ){
                    $rowIx = $cols[$i]['row'];
                    $type = $cols[$i]['type'];
                    if( array_key_exists('row100vh', $rows[$rowIx]) && $rows[$rowIx]['row100vh'] == 1 ||
                    array_key_exists('rowcustomheight', $rows[$rowIx]) && $rows[$rowIx]['rowcustomheight'] != '' || 
                    $type == 'vl' ) {
    
                        $absolute_pos = array_key_exists('absolute_position', $cols[$i]) ? $cols[$i]['absolute_position'] : false;
                        // usually, only html and texts could be placed anywhere in a 100vh row.
                        // now every element is able to be placed anywhere in a 100vh row, i added the "absolute_position" property
                        // i still check for text and html types individually, instead of only checking for the "absolute_position" property
                        // for backwards compatibility
                        if ( $cols[$i]['type'] == 'text' || $cols[$i]['type'] == 'html' ) {
                            $absolute_pos = true;
                        }
                        if ( $absolute_pos ) {
                            if( array_key_exists('classes', $cols[$i]) ) {
                                $cols[$i]['classes'] .= ' absolute-position';
                                $reorder_cols = true;
                            } else {
                                $cols[$i]['classes'] = 'absolute-position';
                                $reorder_cols = true;
                            }
                        }
                    }
                    $rows[$rowIx]['columns'] []= $cols[$i];
                }
            }

            // reorder cols
            // the columns that are absolute positioned should always come after cols that are not
            // this way, the "first-child" class will be used correctly so the frame-left value is correct
            // this is for the rare case when an absolutely positioned element has col-0 for example and an image too

            if( $reorder_cols == true ) {
                for( $i=0; $i<count($rows); $i++ ) {
                    $cols = $rows[$i]['columns'];
                    // error_log(print_r('cols original', true));
                    // error_log(print_r($cols, true));
                    $cols_new = array();
                    $cols_start = array();
                    $cols_end = array();
                    for( $x=0; $x<count($cols); $x++ ) {
                        // error_log(print_r($cols[$x], true));
                        if( array_key_exists('classes', $cols[$x]) && strpos($cols[$x]['classes'], 'absolute-position') !== false ){
                            $cols_end []= $cols[$x];
                        } else {
                            $cols_start []= $cols[$x];
                        }
                    }
                    $cols_new = array_merge( $cols_start, $cols_end );
                    // error_log(print_r('new cols', true));
                    // error_log(print_r($cols_new, true));
                    $rows[$i]['columns'] = $cols_new;
                    // error_log(print_r($rows[$i]['columns'], true));
                }
            }
            // #reorder cols

            // set classes
            for( $i=0; $i<count($rows); $i++ ) {
                $cols = $rows[$i]['columns'];
                for( $x=0; $x<count($cols); $x++ ) {
                    if( $x == 0 ) {
                        if( array_key_exists('classes', $cols[$x]) ) {
                            $rows[$i]['columns'][$x]['classes'] .= ' first-child';
                        } else {
                            $rows[$i]['columns'][$x]['classes'] = 'first-child';
                        }
                    } else {
                        if( array_key_exists('classes', $cols[$x]) ) {
                            $rows[$i]['columns'][$x]['classes'] .= ' not-first-child';
                        } else {
                            $rows[$i]['columns'][$x]['classes'] = 'not-first-child';
                        }
                    }

                }
            }

            // add horizontal grid info
            if( array_key_exists('horizontalGrid', $grid_arr) && $grid_arr['horizontalGrid']['show'] == true ) {
                for( $i=0; $i<count($rows); $i++ ) {
                    $cols = $rows[$i]['columns'];
                    for( $x=0; $x<count($cols); $x++ ) {
                        $rows[$i]['columns'][$x]['horizontalGrid'] = $grid_arr['horizontalGrid'];
                    }
                }
            }


        }

        return $rows;
    }

    public static function getRowColElMarkup($rows, $postid, $device) {
        $markup = '';
        for( $i = 0; $i < count($rows); $i++ ){
            $row = $rows[$i];
            if( $i == 0 ){
                if( array_key_exists('classes', $row) ){
                    $row['classes'] .= ' first-row';
                }else{
                    $row['classes'] = 'first-row';
                }
                
            }
            $layRow = new LayRow($row, $i);
            $markup .= $layRow->getOpeningMarkup();

            // when row is 100vh, the first column inside that is not a text and not a html element needs class lay-col-needs-leftframe-margin
            $isRowWhereElsArePositionAbsolute = false;
            // error_log(print_r($row['row100vh'], true));
            if( array_key_exists('row100vh', $row) && $row['row100vh'] == true || array_key_exists('rowcustomheight', $row) && $row['rowcustomheight'] == true ){
                $isRowWhereElsArePositionAbsolute = true;
            }
            if( $isRowWhereElsArePositionAbsolute == true ) {
                for( $i3=0; $i3<count($row['columns']); $i3++ ) {
                    $col = $row['columns'][$i3];
                    if( $col['type'] != 'text' && $col['type'] != 'html' ) {
                        if( array_key_exists('classes', $col) ){
                            $row['columns'][$i3]['classes'] .= ' lay-col-needs-leftframe-margin';
                        } else {
                            $row['columns'][$i3]['classes'] = 'lay-col-needs-leftframe-margin';
                        }
                    break;
                    }
                }
            }

            // 
            for( $i2=0; $i2<count($row['columns']); $i2++ ){
                $col = $row['columns'][$i2];
                $layCol = new LayCol($col, $isRowWhereElsArePositionAbsolute);
                $layEl = new LayEl($col, false, $postid, $device);
                $elMarkup = $layEl->getMarkup();
                if( $elMarkup != '' ) {
                    $markup .= $layCol->getOpeningMarkup();
                    $markup .= $elMarkup;
                    $markup .= $layCol->getClosingMarkup();;
                }
            }

            $markup .= $layRow->getClosingMarkup();
        }
        return $markup;
    }

}

new Lay_Layout();