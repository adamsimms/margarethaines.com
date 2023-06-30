<?php
class LayRowFunctions{

    public function __construct(){

    }

    public static function getBgSet( $bgimage ) {
        $sizes = $bgimage['sizes'];
        $sizesToBeFilled = ['_265', '_512', '_768', '_1024', '_1280', '_1920', '_2560', '_3200', '_3840', '_4096'];
        $srcset = '';
        $full_src = LTUtility::getFullURL($bgimage['url']);

        foreach($sizes as $key => $value) {
            if( array_search($key, $sizesToBeFilled) !== false ){
                $src = $value['url'];
                $src = LTUtility::getFullURL($src);
    
                $srcset = $src.' '.substr($key, 1).'w, ' . $srcset;
                $ix = array_search($key, $sizesToBeFilled);

                if($ix !== false){
                    array_splice( $sizesToBeFilled, $ix, 1 );
                }
            }
        }
        // fill rest of sizes with full image
        for($i=0; $i<count($sizesToBeFilled); $i++){
            $srcset .= $full_src.' '.substr($sizesToBeFilled[$i], 1).'w, ';
        }
        $srcset = substr($srcset, 0, -2);
        return $srcset;
    }

    // getBackgroundVideoBgSet, the difference to getBgSet is that we don't have .url, .w , .h
    // meaning the data structure is different!!
    // This placeholder image is used on mobile devices that do not support inline autoplaying videos.
    public static function getBackgroundVideoBgSet( $sizes ) {
        $markup = '';
        $sizesToBeFilled = ['_265', '_512', '_768', '_1024', '_1280', '_1920', '_2560', '_3200', '_3840', '_4096'];
        $srcset = '';
        $full_src = LTUtility::getFullURL($sizes['full']);

        foreach($sizes as $key => $value) {
            if( array_search($key, $sizesToBeFilled) !== false ){
                $src = $value;
                $src = LTUtility::getFullURL($src);

                $srcset = $src.' '.substr($key, 1).'w, ' . $srcset;
                $ix = array_search($key, $sizesToBeFilled);

                if($ix !== false){
                    array_splice( $sizesToBeFilled, $ix, 1 );
                }
            }
        }
        // fill rest of sizes with full image
        for($i=0; $i<count($sizesToBeFilled); $i++){
            $srcset .= $full_src.' '.substr($sizesToBeFilled[$i], 1).'w, ';
        }
        $srcset = substr($srcset, 0, -2);
        return $srcset;
    }

    public static function getBgAr( $bgimageObj ){
        if( array_key_exists('_265', $bgimageObj['sizes']) ){
            if( array_key_exists('w', $bgimageObj['sizes']['_265']) ){
                return $bgimageObj['sizes']['_265']['h'] / $bgimageObj['sizes']['_265']['w'];
            }
        }
        return '';
    }

    public static function getBgDataWDataH( $bgimageObj ){
        if( array_key_exists('_265', $bgimageObj['sizes']) ){
            if( array_key_exists('w', $bgimageObj['sizes']['_265']) ){
                return 'data-w="'.$bgimageObj['sizes']['_265']['h'].'" data-h="'.$bgimageObj['sizes']['_265']['w'].'"';
            }
        }
        return '';
    }

    public static function mergeAllRows($all_rows, &$array_to_merge_to){
        $row = array_splice( $all_rows, 0, 1 );
        if( is_array($row) ) {
            $array_to_merge_to = array_merge( $array_to_merge_to, $row );
        }
        if( count($all_rows) == 0 ) {
            return;
        }
        LayRowFunctions::mergeAllRows($all_rows, $array_to_merge_to);
    }

}
new LayRowFunctions();