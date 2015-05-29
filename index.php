<?php
/*
Plugin Name: WP Style Sets
Version: 0.1
Author: Brent Jett
Description: A concept plugin for creating a set of styles to be compiled and output as either a file or <style> block.
*/

// Load Less Compiler
if ( file_exists( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' ) ) {
    // load LESS parser
    require_once( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' );
}

add_action('init', function() {

});
$brj_style_sets = array();

// add new set
// add item to set

// render set
function render_styleset_for_name($name) {
    $units = apply_filters('wp_stylesets/pre_render/units', $units);
    // returns css? or if file type, url to cached file?
}

?>
