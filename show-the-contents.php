<?php

/**
 * Plugin Name: show the contents
 * Plugin URI:
 * Description: Plugin to list all your posts or pages using by shortcode [stc_list_post]
 * Version: 1.0.0 
 * Author: darkblue
 * License: GPL2
 * Text Domain: stc
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !defined( 'STC_VERSION' ) ) {
	define( 'STC_VERSION', '1.0.0' );
}

if( !defined( 'STC_DIR' ) ) {
	define( 'STC_DIR', plugin_dir_path( __FILE__ ) );
}

if( !defined( 'STC_URI' ) ) {
	define( 'STC_URI', plugins_url( '/', __FILE__ ) );
}


if( !defined( 'STC_FILE' ) ) {
	define( 'STC_FILE', __FILE__ );
}

if( !defined( 'STC_BASENAME' ) ) {
	define( 'STC_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * Include files
 */

include_once "inc/stc-functions.php";
include_once "inc/class-show-contents.php";

include_once "inc/shortcode/stc-shortcode-grid.php";



// /**
//  * Add shortcode 
//  */
// add_shortcode( 'show-content', 'stc_show_shortcode' );
// function stc_show_shortcode( $atts, $content ) {
	
// 	echo plugin_dir_url( __FILE__ );
// 	echo PHP_EOL;
// 	echo STC_URI;
// }

