<?php
/**
 * @package wpapi-shortcodes-and-widgets
 * @version 1.0
 */
/*
Plugin Name: wpapi shortcodes and widgets
Plugin URI: http://wordpress.org/plugins/wpapi-shortcodes-and-widgets/
Description: get WP-API's data, making original widget and shortcodes.
Author: Hidetaka Okamoto
Version: 1.0
Author URI: http://wp-kyoto.net/
*/
/*  Copyright 2015 Hidetaka OKamoto

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
require_once 'wpapi-class-content.php';
require_once 'wpapi-class-shortcode.php';
require_once 'wpapi-class-widget.php';
define( 'WPAPI_GET_CONTENT_URL', plugins_url( '', __FILE__ ) );


add_shortcode('wpapi-posts', 'wpapi_echo_posts');
add_action( 'wp_enqueue_scripts', 'wpapi_set_stylesheet' );
add_action('widgets_init','wpapi_setup_widget');

function wpapi_echo_posts($attr){
    $WpapiShortcodes = new WpapiShortcodes();
    $html = $WpapiShortcodes->get_api($attr);
    return $html;
}

function wpapi_set_stylesheet(){
    wp_enqueue_style( 'wpapi', WPAPI_GET_CONTENT_URL."/wpapi.css" );
}

function wpapi_setup_widget(){
    register_widget( 'WpapiWidget' );
}
