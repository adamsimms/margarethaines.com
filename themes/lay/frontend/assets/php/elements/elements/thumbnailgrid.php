<?php

// todo: different css for desktop, tablet, phone

class LayThumbnailgrid{

    public $el;
    public $config;
    public $postid;

    public function __construct($el, $postid){
        $this->el = $el;
        $this->postid = $postid;
    }

    public function getMarkup(){
        $thumbs_data_array = array();
        $thumbs_array = array();

        $this->config = $this->el['config'];

        $limitThumbnails = array_key_exists('limitThumbnails', $this->config) ? $this->config['limitThumbnails'] : 0;

        $useImagehover = false;
        if( isset($this->config['useImagehover']) && class_exists('LayThemeImagehover') ) {
            $useImagehover = $this->config['useImagehover'] ? true : false;
        }
        $use_tag_filter = ( array_key_exists('showtagfilter', $this->config) && $this->config['showtagfilter'] == true ) ? true : false;
        $use_cat_filter = ( array_key_exists('showfilter', $this->config) && $this->config['showfilter'] == true ) ? true : false;
        $sort_by_date_only = ( array_key_exists('sortbydate', $this->config) && $this->config['sortbydate'] == true ) ? true : false;

        // if filter is true, load all thumbnails, not just the ones of the current category
        if( $use_cat_filter == true ) {
            $categories = get_categories( array( 'hide_empty' => true, 'orderby' => 'menu_order' ) );
            foreach( $categories as $category ) {
                $thumbs_data_array = LayThumnbailgridFunctions::get_thumbnails_data_for_thumbnailgrid_by_catid( $category->term_id, $this->config );
                // hide thumbnails that are not of current category
                $display = $this->config['cat_id'] == $category->term_id ? true : false;
                foreach( $thumbs_data_array as $thumb_data ) {
                    $thumb_data['classes'] = $display ? 'show-filtered' : 'hide-filtered';
                    $thumb_data['display'] = $display;
                    $thumb_data['filter_id'] = $category->term_id;
                    $thumbs_array []= new LayThumbnail( $thumb_data, $useImagehover );
                }
            }
        } else {
            $thumbs_data_array = LayThumnbailgridFunctions::get_thumbnails_data_for_thumbnailgrid_by_catid( $this->config['cat_id'], $this->config );
            foreach( $thumbs_data_array as $thumb_data ) {
                $thumbs_array []= new LayThumbnail( $thumb_data, $useImagehover );
            }
        }

        // when not using any filters, only return limited amount of thumbnails
        // otherwise, return all thumbnails and hiding them is done with js
        if( $limitThumbnails > 0 && $use_cat_filter == false && $use_tag_filter == false ) {
            $thumbs_array_clone = [];
            $limitThumbnails = $limitThumbnails < count($thumbs_array) ? $limitThumbnails : count($thumbs_array);
            for( $i = 0; $i < $limitThumbnails; $i++ ) {
                $thumbs_array_clone []= $thumbs_array[$i];
            }
            $thumbs_array = $thumbs_array_clone;
        }
        
        $thumbs_markup = '';
        foreach( $thumbs_array as $thumb ) {
            // hide projectthumbnail of currently shown project
            if( LayFrontend_Options::$hide_current_project_from_thumbnailgrid == 'on' && $thumb->el['postid'] == $this->postid ){
                continue;
            }
            $thumbs_markup .= $thumb->getMarkup();
        }

        $filter = '';
        $tagsfilter = '';
        $class = '';

        if( $use_cat_filter ) {
            $class .= ' use-filter';
        } else {
            $class .= ' no-cats-filter';
        }

        if( $use_tag_filter ) {
            $class .= ' use-tags-filter';
        } else {
            $class .= ' no-tags-filter';
        }

        $dataAttrs = '';

        if( $useImagehover ) {
            $dataAttrs = 'data-imagehover';
        }

        $filter = LayThumnbailgridFunctions::lay_get_thumbnailgrid_filter_markup($this->config);

        // error_log(print_r($tagsfilter, true));
        // error_log(print_r($use_tag_filter, true));

        return
        '<div class="thumbs-collection-region layout-type-'.$this->config['layoutType'].' '.$class.'" data-config="'.htmlspecialchars(json_encode($this->config)).'" '.$dataAttrs.'>
            <div class="lay-thumbnailgrid-filter-wrap">'.$filter.'</div>
            <div class="thumb-collection">
                '.$thumbs_markup.'
            </div>
        </div>';
    }

}