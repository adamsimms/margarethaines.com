<?php

// news:

/*

- list of news, sorted by date
- "next news", "previous news" buttons
- some kind of thumbnailgrid of news

*/

class LayNews{

    public function __construct(){
        $val = get_option('misc_options_activate_news_feature', '');
		if( $val == "on" && !MiscOptions::$locked ){
			add_action('init', array($this, 'lay_register_news_post_type'));
		}
        add_action('wp_ajax_get_news_feed_via_ajax', array($this, 'get_news_feed_via_ajax'));
        add_action('wp_ajax_nopriv_get_news_feed_via_ajax', array($this, 'get_news_feed_via_ajax'));
    }

    public static function get_news_feed_via_ajax(){
        $config = $_POST['config'];
        $target = $_POST['target'];
        $markup = LayNews::get_news_feed($config, $target);
        echo $markup;
		die();
    }

    public static function get_news_feed($config, $target){
        // error_log(print_r($target, true));

        $layout = 'list';
        if( array_key_exists('layout', $config) ) {
            $layout = $config['layout'];
        }
        $markup = '';

        $amount = -1;
        if( array_key_exists('amount', $config) ) {
            if($config['amount'] > 0) {
                $amount = $config['amount'];
            }
        }

        $date_format = 'm.d.y';
        if( array_key_exists('date_format', $config) ) {
            $date_format = $config['date_format'];
        }
        $args = array(
            'posts_per_page' => $amount,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'lay_news',
            'fields' => 'ids',
            'post_status' => 'publish',
        );
        // show only of that category
        if(array_key_exists('cat_id', $config) && $config['cat_id'] != -1){
            $args ['tax_query'] = array(             
                array(
                   'taxonomy' => 'lay_news_category',
                   'field' => 'term_id',
                   'terms' => $config['cat_id']
               ),
            );
        }
        // error_log(print_r($args, true));
        remove_all_filters('posts_orderby');
        $query = new WP_Query( $args );

        switch( $layout ) {
            case 'list':
                $markup = LayNews::get_news_feed_list_layout($config, $target, $query, $date_format);
            break;
            case 'columns':
                $markup = LayNews::get_news_feed_columns_layout($config, $target, $query, $date_format);
            break;
            case 'full':
                $markup = LayNews::get_news_feed_fullcontent_layout($config, $target, $query, $date_format);
            break;
        }

        return $markup;
	}

    public static function get_news_feed_fullcontent_layout($config, $target, $query, $date_format){
        // $amount = -1;
        // if( array_key_exists('amount', $config) ) {
        //     if($config['amount'] > 0) {
        //         $amount = $config['amount'];
        //     }
        // }

        // $date_format = 'm.d.y';
        // if( array_key_exists('date_format', $config) ) {
        //     $date_format = $config['date_format'];
        // }
        // $args = array(
        //     'posts_per_page' => $amount,
        //     'orderby' => 'post_date',
        //     'order' => 'DESC',
        //     'post_type' => 'lay_news',
        //     'fields' => 'ids',
        //     'post_status' => 'publish'
        // );
        $array = array();
        // $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            foreach ($query->posts as $post_id){
                $array []= array('id' => $post_id, 'title' => get_the_title($post_id), 'date' => get_the_date($date_format, $post_id));
            }
        }

        $css_prefix = $target == 'modal' ? '.lay-input-modal ' : '';

        $lineMarkup = '';
        // error_log(print_r($config, true));
        if( $config['line'] === 'true' || $config['line'] === true  ) {
            $lineMarkup = 
            $css_prefix.'.lay-news-element-'.$config['uniqueId'].'>.lay-content{
                border-bottom: 1px solid '.$config['lineColor'].';
                margin-bottom: '.$config['space_below_line'].'px;
                padding-bottom: '.$config['space_above_line'].'px;
            }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].'>.lay-content:last-child{
                border-bottom: none;
            }';
        } else {
            $lineMarkup = 
            $css_prefix.'.lay-news-element-'.$config['uniqueId'].'>.lay-content{
                margin-bottom: '.$config['space_below_line'].'px;
            }';
        }
        $markup =
        '<style>
            '.$lineMarkup.'
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-separator{ margin-left: '.$config['separator_space'].'px; margin-right: '.$config['separator_space'].'px; }
        </style>';

        // show title, show separator, show date
        $show_title = true;
        if( array_key_exists('show_title', $config) ) {
            if($config['show_title'] === 'false' || $config['show_title'] === false) {
                $show_title = false;
            }
        }

        $separator = '<div class="lay-news-element-separator _'.$config['separator_textformat'].'_no_spaces">'.$config['separator_text'].'</div>';
        $show_separator = true;
        if( $config['show_separator'] === 'false' || $config['show_separator'] === false ) {
            $show_separator = false;
            $separator = '';
        }

        $show_date = true;
        if( $config['show_date'] === 'false' || $config['show_date'] === false ) {
            $show_date = false;
        }

        $show_date_first = false;
        if( array_key_exists('show_date_first', $config) && ( $config['show_date_first'] === 'true' || $config['show_date_first'] === true ) ) {
            $show_date_first = true;
        }
        // # show title, show separator, show date

        $getImagehoverMarkup = $target == 'frontend' ? true : false;

        $markup .= 
        '<div class="lay-news-element-wrap">
            <div class="lay-news-element lay-news-element-layout-fullcontent lay-news-element-'.$config['uniqueId'].'">';
        foreach ($array as $news){
            $id = $news['id'];
            $layout = Lay_Layout::getLayout($id, 'lay_news', '', false, $getImagehoverMarkup);
            $date = $show_date ? '<div class="lay-news-element-date _'.$config['date_textformat'].'_no_spaces">'.$news['date'].'</div>' : '';

            $_title = $show_title ? __($news['title']) : '';

            $t = '';
            if( $show_date_first ) {
                $t = $date.$separator.'<div class="lay-news-element-title _'.$config['title_textformat'].'_no_spaces">'.$_title.'</div>';
            } else {
                $t = '<div class="lay-news-element-title _'.$config['title_textformat'].'_no_spaces">'.$_title.'</div>'.$separator.$date;
            }

            $title =
            '<div class="lay-news-element-title-wrap">
                '.$t.'
            </div>';
            if( !$show_title && !$show_separator && !$show_date ) {
                $title = '';
            }
            $markup .= $title.$layout['markup'];
        }

        return $markup.'</div></div>';
    }

    public static function get_news_feed_columns_layout($config, $target, $query, $date_format){
        $imageSpaceBottom = array_key_exists('imageSpaceBottom', $config) ? $config['imageSpaceBottom'] : 10;

        $alignment = array_key_exists('columnsLayoutType', $config) ? $config['columnsLayoutType'] : 'top-aligned';

        $colCountDesktop = array_key_exists('colCount', $config['desktop']) ? $config['desktop']['colCount'] : 4;
        $colCountTablet = array_key_exists('colCount', $config['tablet']) ? $config['tablet']['colCount'] : 3;
        $colCountPhone = array_key_exists('colCount', $config['phone']) ? $config['phone']['colCount'] : 2;

        $rowGutterDesktop = array_key_exists('rowGutter', $config['desktop']) ? $config['desktop']['rowGutter'] : 20;
        $rowGutterTablet = array_key_exists('rowGutter', $config['tablet']) ? $config['tablet']['rowGutter'] : 20;
        $rowGutterPhone = array_key_exists('rowGutter', $config['phone']) ? $config['phone']['rowGutter'] : 20;

        $rowGutterMuDesktop = array_key_exists('rowGutterMu', $config['desktop']) ? $config['desktop']['rowGutterMu'] : 'px';
        $rowGutterMuTablet = array_key_exists('rowGutterMu', $config['tablet']) ? $config['tablet']['rowGutterMu'] : 'px';
        $rowGutterMuPhone = array_key_exists('rowGutterMu', $config['phone']) ? $config['phone']['rowGutterMu'] : 'px';

        $colGutterDesktop = array_key_exists('colGutter', $config['desktop']) ? $config['desktop']['colGutter'] : 20;
        $colGutterTablet = array_key_exists('colGutter', $config['tablet']) ? $config['tablet']['colGutter'] : 20;
        $colGutterPhone = array_key_exists('colGutter', $config['phone']) ? $config['phone']['colGutter'] : 20;

        $colGutterMuDesktop = array_key_exists('colGutterMu', $config['desktop']) ? $config['desktop']['colGutterMu'] : 'px';
        $colGutterMuTablet = array_key_exists('colGutterMu', $config['tablet']) ? $config['tablet']['colGutterMu'] : 'px';
        $colGutterMuPhone = array_key_exists('colGutterMu', $config['phone']) ? $config['phone']['colGutterMu'] : 'px';

        $read_more_underline = array_key_exists('read_more_underline', $config) ? $config['read_more_underline'] : true;
        if( $read_more_underline === 'false' || $read_more_underline === '' ) {
            $read_more_underline = false;
        }
        else if( $read_more_underline === 'true' || $read_more_underline === '1' ) {
            $read_more_underline = true;
        }

        // $amount = -1;
        // if( array_key_exists('amount', $config) ) {
        //     if($config['amount'] > 0) {
        //         $amount = $config['amount'];
        //     }
        // }

        // $date_format = 'm.d.y';
        // if( array_key_exists('date_format', $config) ) {
        //     $date_format = $config['date_format'];
        // }
        // $args = array(
        //     'posts_per_page' => $amount,
        //     'orderby' => 'post_date',
        //     'order' => 'DESC',
        //     'post_type' => 'lay_news',
        //     'fields' => 'ids',
        //     'post_status' => 'publish'
        // );
        $array = array();
        // $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            foreach ($query->posts as $post_id){
                $array []= array('id' => $post_id, 'title' => get_the_title($post_id), 'date' => get_the_date($date_format, $post_id));
            }
        }

        // error_log(print_r('news', true));
        // error_log(print_r($array, true));

        $phone_breakpoint = get_option('lay_breakpoint', 600);
        $phone_breakpoint = (int)$phone_breakpoint;

        $tablet_breakpoint = get_option( 'lay_tablet_breakpoint', 1024 );
        $tablet_breakpoint = (int)$tablet_breakpoint;


        $media_queries = '';
        $preview_desktop = $target == 'modal' ? '.lay-input-modal .preview-desktop ' : '';
        $preview_tablet = $target == 'modal' ? '.lay-input-modal .preview-tablet ' : '';
        $preview_phone = $target == 'modal' ? '.lay-input-modal .preview-phone ' : '';

        if( $target == 'gridder' ) {
            $preview_desktop = '.show-desktop-version ';
            $preview_tablet = '.show-tablet-version ';
            $preview_phone = '.show-phone-version ';
        }

        if( $target == 'frontend' ) {
            $media_queries .= '@media (min-width: '.($tablet_breakpoint+1).'px){';
        }
        $media_queries .=
            $preview_desktop.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row{
                width: calc( 100% / '.$colCountDesktop.' - '.($colCountDesktop-1).' * '.$colGutterDesktop.$colGutterMuDesktop.' / '.$colCountDesktop.' );
                margin-right: '.$colGutterDesktop.$colGutterMuDesktop.';
                margin-bottom: '.$rowGutterDesktop.$rowGutterMuDesktop.';
            }
            '.$preview_desktop.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row:nth-child('.$colCountDesktop.'n){ margin-right: 0; }';
        if( $target == 'frontend' ) {
            $media_queries .= '}';
        }

        if( $target == 'frontend' ) {
            $media_queries .= '@media (max-width: '.($tablet_breakpoint).'px) and (min-width: '.($phone_breakpoint+1).'px){';
        }
        $media_queries .=
            $preview_tablet.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row{
                width: calc( 100% / '.$colCountTablet.' - '.($colCountTablet-1).' * '.$colGutterTablet.$colGutterMuTablet.' / '.$colCountTablet.' );
                margin-right: '.$colGutterTablet.$colGutterMuTablet.';
                margin-bottom: '.$rowGutterTablet.$rowGutterMuTablet.';
            }
            '.$preview_tablet.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row:nth-child('.$colCountTablet.'n){ margin-right: 0; }';
        if( $target == 'frontend' ) {
            $media_queries .= '}';
        }

        if( $target == 'frontend' ) {
            $media_queries .= '@media (max-width: '.($phone_breakpoint).'px){';
        }
        $media_queries .=
            $preview_phone.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row{
                width: calc( 100% / '.$colCountPhone.' - '.($colCountPhone-1).' * '.$colGutterPhone.$colGutterMuPhone.' / '.$colCountPhone.' );
                margin-right: '.$colGutterPhone.$colGutterMuPhone.';
                margin-bottom: '.$rowGutterPhone.$rowGutterMuPhone.';
            }
            '.$preview_phone.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row:nth-child('.$colCountPhone.'n){ margin-right: 0; }';
        if( $target == 'frontend' ) {
            $media_queries .= '}';
        }

        $css_prefix = $target == 'modal' ? '.lay-input-modal ' : '';

        $markup =
        '<style>
            '.$media_queries.'
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-image { margin-bottom:'.$imageSpaceBottom.'px; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row .lay-news-image{
                margin-right: 0;
            }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row>div>div{ display: inline-block; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row .lay-news-element-excerpt{ display: block; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-excerpt{ margin-top: '.$config['excerpt_spacetop'].'px; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-read-more{ margin-top: '.$config['readmore_spacetop'].'px; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-separator{ margin-left: '.$config['separator_space'].'px; margin-right: '.$config['separator_space'].'px; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-read-more{ display: block; } 
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row{ border-bottom: none; } 
        </style>';

        // show title, show separator, show date
        $show_title = true;
        if( array_key_exists('show_title', $config) ) {
            if($config['show_title'] === 'false' || $config['show_title'] === false) {
                $show_title = false;
            }
        }

        $separator = '<div class="lay-news-element-separator _'.$config['separator_textformat'].'_no_spaces">'.$config['separator_text'].'</div>';
        $show_separator = true;
        if( $config['show_separator'] === 'false' || $config['show_separator'] === false ) {
            $show_separator = false;
            $separator = '';
        }

        $show_date = true;
        if( $config['show_date'] === 'false' || $config['show_date'] === false ) {
            $show_date = false;
        }

        $show_date_first = false;
        if( array_key_exists('show_date_first', $config) && ( $config['show_date_first'] === 'true' || $config['show_date_first'] === true ) ) {
            $show_date_first = true;
        }
        // # show title, show separator, show date

        $markup .= 
        '<div class="lay-news-element-wrap">
        <div class="lay-news-element lay-news-element-layout-columns lay-news-element-alignment-'.$alignment.' lay-news-element-'.$config['uniqueId'].'">';
            foreach ($array as $news) {
                $separator = '<div class="lay-news-element-separator _'.$config['separator_textformat'].'_no_spaces">'.$config['separator_text'].'</div>';
                if( $show_separator == false ) {
                    $separator = '';
                }
                $date = '<div class="lay-news-element-date _'.$config['date_textformat'].'_no_spaces">'.$news['date'].'</div>';
                if( $show_date == false ) {
                    $date = '';
                }
                $excerpt_content = get_the_excerpt($news['id']);
                $excerpt = '<div class="lay-news-element-excerpt _'.$config['excerpt_textformat'].'_no_spaces">'.$excerpt_content.'</div>';
                if( $config['show_excerpt'] === 'false' || $config['show_excerpt'] === false || trim($excerpt_content) == '' ) {
                    // if there is no excerpt we need a br, so show more doesnt land on same line
                    $excerpt = '<br/>';
                }
                $readmore = '';
                if( $config['show_read_more'] === 'true' ||  $config['show_read_more'] === true ) {
                    $readmore = '<div class="lay-news-element-read-more '.($read_more_underline ? 'link-in-text' : '').' _'.$config['readmore_textformat'].'_no_spaces">'.$config['read_more_text'].'</div>';
                }

                $attid = get_post_thumbnail_id($news['id']);
                $img = LayElFunctions::getLazyImgByImageId($attid);
                if( $target != 'frontend' ) {
                    $img = wp_get_attachment_image($attid, array(200, 200));
                }
                $src_ = wp_get_attachment_image_src($attid);
                $pb = 0;
                if( is_array($src_) ) {
                    $pb = $src_[2] / $src_[1] * 100;
                }

                if( $img != '' ) {
                    $img = '<div class="ph" style="padding-bottom:'.Lay_LayoutFunctions::replaceCommaWithDot($pb).'%;">'.$img.'</div>';
                }

                // https://qtranslatexteam.wordpress.com/faq/#HowToTranslateCustomFields
                $_title = $show_title ? '<div class="lay-news-element-title _'.$config['title_textformat'].'_no_spaces">'.__($news['title']).'</div>' : '';
                
                $t = '';
                if( $show_date_first ) {
                    $t = $date.$separator.$_title;
                } else {
                    $t = $_title.$separator.$date;
                }
                
                $markup .= 
                '<a href="'.get_permalink($news['id']).'" data-id="'.$news['id'].'" data-type="news" data-title="'.__($news['title']).'" class="lay-news-element-row">
                    <div class="lay-news-image">
                        '.$img.'
                    </div>
                    <div>
                        '.$t.'
                        '.__($excerpt).'
                        '.$readmore.'
                    </div>
                </a>';
            }

        $markup .= 
        '</div>';
        $markup .= 
        '</div>';
        return $markup;

    }

    public static function get_news_feed_list_layout($config, $target, $query, $date_format){

        $array = array();
        if ( $query->have_posts() ) {
            foreach ($query->posts as $post_id){
                $array []= array('id' => $post_id, 'title' => get_the_title($post_id), 'date' => get_the_date($date_format, $post_id));
            }
        }

        $phone_breakpoint = get_option('lay_breakpoint', 600);
        $phone_breakpoint = (int)$phone_breakpoint;

        $tablet_breakpoint = get_option( 'lay_tablet_breakpoint', 1024 );
        $tablet_breakpoint = (int)$tablet_breakpoint;

        $css_prefix = $target == 'modal' ? '.lay-input-modal ' : '';

        $lineMarkup = '';
        if( $config['line'] === 'true' || $config['line'] === true  ) {
            $lineMarkup = 
            $css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row{
                border-bottom: 1px solid '.$config['lineColor'].';
                margin-bottom: '.$config['space_below_line'].'px;
                padding-bottom: '.$config['space_above_line'].'px;
            }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row:last-child{
                border-bottom: none;
            }';
        } else {
            $lineMarkup = 
            $css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row{
                margin-bottom: '.$config['space_below_line'].'px;
            }';
        }

        $desktop_width = array_key_exists('desktop', $config) ? $config['desktop']['image_width'] : 180;
        $tablet_width = array_key_exists('tablet', $config) ? $config['tablet']['image_width'] : 150;
        $phone_width = array_key_exists('phone', $config) ? $config['phone']['image_width'] : 100;

        $read_more_underline = array_key_exists('read_more_underline', $config) ? $config['read_more_underline'] : true;
        if( $read_more_underline === 'false' || $read_more_underline === '' ) {
            $read_more_underline = false;
        }
        else if( $read_more_underline === 'true' || $read_more_underline === '1' ) {
            $read_more_underline = true;
        }

        $media_queries = '';
        $preview_desktop = ($target == 'modal') ? '.lay-input-modal .preview-desktop ' : '';
        $preview_tablet = ($target == 'modal') ? '.lay-input-modal .preview-tablet ' : '';
        $preview_phone = ($target == 'modal') ? '.lay-input-modal .preview-phone ' : '';
        
        if( $target == 'gridder' ) {
            $preview_desktop = '.show-desktop-version ';
            $preview_tablet = '.show-tablet-version ';
            $preview_phone = '.show-phone-version ';
        }
        // media queries
        // desktop
        if( $target == 'frontend' ) {
            $media_queries .= '@media (min-width: '.($tablet_breakpoint+1).'px){';
        }
        $media_queries .=
            $preview_desktop.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row .ph{
                width: '.$desktop_width.'px;
            }';
        if( $target == 'frontend' ) {
            $media_queries .= '}';
        }
        // tablet
        if( $target == 'frontend' ) {
            $media_queries .= '@media (max-width: '.($tablet_breakpoint).'px) and (min-width: '.($phone_breakpoint+1).'px){';
        }
        $media_queries .=
            $preview_tablet.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row .ph{
                width: '.$tablet_width.'px;
            }';
        if( $target == 'frontend' ) {
            $media_queries .= '}';
        }
        // phone
        if( $target == 'frontend' ) {
            $media_queries .= '@media (max-width: '.($phone_breakpoint).'px){';
        }
        $media_queries .=
            $preview_phone.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row .ph{
                width: '.$phone_width.'px;
            }';
        if( $target == 'frontend' ) {
            $media_queries .= '}';
        }
        // #end media queries

        // show title, show separator, show date
        $show_title = true;
        if( array_key_exists('show_title', $config) ) {
            if($config['show_title'] === 'false' || $config['show_title'] === false) {
                $show_title = false;
            }
        }

        $separator = '<div class="lay-news-element-separator _'.$config['separator_textformat'].'_no_spaces">'.$config['separator_text'].'</div>';
        $show_separator = true;
        if( $config['show_separator'] === 'false' || $config['show_separator'] === false ) {
            $show_separator = false;
            $separator = '';
        }

        $show_date = true;
        if( $config['show_date'] === 'false' || $config['show_date'] === false ) {
            $show_date = false;
        }
        $show_date_first = false;
        if( array_key_exists('show_date_first', $config) && ( $config['show_date_first'] === 'true' || $config['show_date_first'] === true ) ) {
            $show_date_first = true;
        }
        // # show title, show separator, show date

        $image_spaceright = array_key_exists('image_spaceright', $config) ? $config['image_spaceright'] : 10;
        $markup =
        '<style>
            '.$media_queries.'
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row .lay-news-image{
                margin-right: '.$image_spaceright.'px;
            }
            '.$lineMarkup.'
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row{ width: 100%; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row>div>div{ display: inline-block; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-row .lay-news-element-excerpt{ display: block; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-excerpt{ margin-top: '.$config['excerpt_spacetop'].'px; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-read-more{ margin-top: '.$config['readmore_spacetop'].'px; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-separator{ margin-left: '.$config['separator_space'].'px; margin-right: '.$config['separator_space'].'px; }
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-element-read-more{ display: block; } 
            '.$css_prefix.'.lay-news-element-'.$config['uniqueId'].' .lay-news-image { margin-bottom:0px; }
        </style>
        <div class="lay-news-element-wrap">
        <div class="lay-news-element lay-news-element-layout-list lay-news-element-'.$config['uniqueId'].'">';
            foreach ($array as $news) {
                // $separator = '<div class="lay-news-element-separator _'.$config['separator_textformat'].'_no_spaces">'.$config['separator_text'].'</div>';
                // if( $config['show_separator'] === 'false' || $config['show_separator'] === false ) {
                //     $separator = '';
                // }
                $date = '<div class="lay-news-element-date _'.$config['date_textformat'].'_no_spaces">'.$news['date'].'</div>';
                if( $show_date == false ) {
                    $date = '';
                }
                $excerpt_content = get_the_excerpt($news['id']);
                $excerpt = '<div class="lay-news-element-excerpt _'.$config['excerpt_textformat'].'_no_spaces">'.$excerpt_content.'</div>';
                if( $config['show_excerpt'] === 'false' || $config['show_excerpt'] === false || trim($excerpt_content) == '' ) {
                    // if there is no excerpt we need a br, so show more doesnt land on same line
                    $excerpt = '<br/>';
                }
                $readmore = '';
                if( $config['show_read_more'] === 'true' ||  $config['show_read_more'] === true ) {
                    $readmore = '<div class="lay-news-element-read-more '.($read_more_underline ? 'link-in-text' : '').' _'.$config['readmore_textformat'].'_no_spaces">'.$config['read_more_text'].'</div>';
                }

                $attid = get_post_thumbnail_id($news['id']);
                $img = LayElFunctions::getLazyImgByImageId($attid);
                if( $target != 'frontend' ) {
                    $img = wp_get_attachment_image($attid, array(200, 200));
                }
                $src_ = wp_get_attachment_image_src($attid);
                $pb = 0;
                if( is_array($src_) ) {
                    $pb = $src_[2] / $src_[1] * 100;
                }

                if( $img != '' ) {
                    $img = '<div class="ph" style="padding-bottom:'.Lay_LayoutFunctions::replaceCommaWithDot($pb).'%;">'.$img.'</div>';
                }

                $_title = $show_title ? '<div class="lay-news-element-title _'.$config['title_textformat'].'_no_spaces">'.__($news['title']).'</div>' : '';
                
                $t = '';
                if( $show_date_first ) {
                    $t = $date.$separator.$_title;
                } else {
                    $t = $_title.$separator.$date;
                }
                // https://qtranslatexteam.wordpress.com/faq/#HowToTranslateCustomFields
                $markup .= 
                '<a href="'.get_permalink($news['id']).'" data-id="'.$news['id'].'" data-type="news" data-title="'.__($news['title']).'" class="lay-news-element-row">
                    <div class="lay-news-image">
                        '.$img.'
                    </div>
                    <div>
                        '.$t.'
                        '.__($excerpt).'
                        '.$readmore.'
                    </div>
                </a>';
            }

        $markup .= 
        '</div>';
        $markup .= 
        '</div>';
        return $markup;
    }

    public static function lay_register_news_post_type(){
        $name = get_option( 'misc_options_news_feature_name', 'News' );
        $slug = get_option( 'misc_options_news_feature_slug', 'news' );


        register_post_type('lay_news',
            array(
                'show_in_menu' => true,
                'menu_position' => 5,
                'labels' => array(
                    'name' => $name
                ),
                'rewrite' => array( 
                    'slug' => $slug, // use this slug instead of post type name
                    'with_front' => FALSE // if you have a permalink base such as /news/ then setting this to false ensures your custom post type permalink structure will be /products/ instead of /blog/products/
                ),
                'public'      => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-welcome-write-blog',
                'supports' => array( 'title', 'excerpt', 'thumbnail' )
            )
        );

        register_taxonomy('lay_news_category', 'lay_news', array(
            'labels' => array(
                'name' => 'News Category'
            ),
            'hierarchical' => true,
            'public'      => true,
            'show_admin_column' => true
        ));
    }

}
new LayNews();