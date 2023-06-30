<?php

class LayPresets{

    public function __construct(){
        add_action( 'after_switch_theme', array($this, 'on_switch_theme'), 10, 2 );
    }

    public static function on_switch_theme( $old_name, $old_theme ){
        global $wpdb;
        // https://developer.wordpress.org/reference/functions/wp_insert_post/
    }

}

new LayPresets();