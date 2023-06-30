<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Like it says on the tin: requires posts to have a featured image set before they'll be published.
Author: Press Up
Version: 0.5.0
Author URI: http://pressupinc.com
*/ 

function load_highlight_css() {
    wp_enqueue_style( 'css-require-title-and-fi-highlight', get_template_directory_uri().'/assets/plugins/require-featured-image-and-title/highlight.css' );
}
add_action( 'admin_enqueue_scripts', 'load_highlight_css' );

register_activation_hook( __FILE__, 'rfi_set_default_on_activation' );
function rfi_set_default_on_activation() {
    add_option( 'rfi_post_types', array('post') );
}

add_action( 'admin_enqueue_scripts', 'rfi_enqueue_edit_screen_js' );
function rfi_enqueue_edit_screen_js( $hook ) {

    global $post;
    if ( $hook != 'post.php' && $hook != 'post-new.php' )
        return;

    if ( in_array( $post->post_type, rfi_return_post_types() ) ) {
        wp_register_script( 'rfi-admin-js', get_template_directory_uri().'/assets/plugins/require-featured-image-and-title/require-featured-image-and-title-on-edit.js', array( 'jquery' ) );
        wp_enqueue_script( 'rfi-admin-js' );
    }
}

/**
 * These are helpers that aren't ever registered with events
 */

function rfi_return_post_types() {
    return apply_filters( 'rfi_post_types' , array( 'post' ) ); 
}