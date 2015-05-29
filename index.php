<?php
/*
Plugin Name: WP Style Sets
Version: 0.1
Author: Brent Jett
Description: A concept plugin for creating a set of styles to be compiled and output as either a file or <style> block.
*/

// Load LESS Compiler
if ( file_exists( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' ) ) {
    // load LESS parser
    require_once( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' );
}
// Load SASS Compiler
if ( file_exists( __DIR__ . '/vendor/leafo/scss/scss.inc.php' ) ) {
    // load LESS parser
    require_once( __DIR__ . '/vendor/leafo/scss/scss.inc.php' );
}

add_action('init', function() {
    if (class_exists('WP_StyleSetManager')) {
        $GLOBALS['wp_style_set_manager'] = new WP_StyleSetManager();
    }
});

class WP_StyleSetManager {

    public $style_sets = array();

    function __construct() {

    }

    public function get_style_sets() {
        return apply_filters('wp_stylesets/pre_get', $this->style_sets);
    }

    // add new set
    public function register_styleset($handle, $args = array()) {
        global $wp_style_sets;

        $wp_style_sets[$handle] = $args;
    }

    // add item to set
    public function add_style_unit_to_set($unit, $set) {
        global $wp_style_sets;
        $wp_style_sets[$set] = $unit;
    }

    // render set
    public function render_styleset($handle) {
        $units = $wp_style_sets
        $units = apply_filters('wp_stylesets/pre_render/units', $units);
        // returns css? or if file type, url to cached file?
    }

}

?>
