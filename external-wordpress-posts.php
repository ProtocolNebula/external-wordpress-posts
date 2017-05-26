<?php
/**
 * @package External Wordpress Posts
 */
/*
Plugin Name: External Wordpress Posts
Plugin URI: https://github.com/ProtocolNebula/external-wordpress-posts
Description: This plugin let you insert posts from other wordpress in real time through shortodes (based in wpapi-shortcode-and-widgets)
Version: 3.2
Author: Ruben Arroyo (ProtocolNebula), hideokamoto
Author URI: https://ruben.arrayzone.com/
License: GPLv2 or later
Text Domain: posts
Original plugin: https://es.wordpress.org/plugins/wpapi-shortcode-and-widgets/
*/

/*
External Wordpress Posts is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
External Wordpress Posts is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with External Wordpress Posts. If not, see LICENSE.txt

Copyright 2017 Rubén Arroyo
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once 'wpapi-class-content.php';
require_once 'wpapi-class-shortcode.php';

define( 'EXTERNALWORDPRESSPOSTS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// [external-wordpress-posts url="external-url"]
function externalwordpressposts( $atts ) {
    $attr = shortcode_atts( array(
        'url' => false,
		'posts_per_page'=>4
    ), $atts );

    if ($attr['url']) {
        $WpapiShortcodes = new WpapiShortcodes();
        $html = $WpapiShortcodes->get_api($attr);
        return $html;
    } else {
        return 'No url specified in external-wordpress-posts shortode';
    }
}
add_shortcode( 'external-wordpress-posts', 'externalwordpressposts' );