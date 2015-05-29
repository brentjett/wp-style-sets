<?php
/*
Plugin Name: WP Style Sets
Version: 0.1
Author: Brent Jett
Description: A concept plugin for creating a set of styles to be compiled and output as either a file or <style> block.
*/

require_once 'WP_StyleSetManager.class.php';

add_action('init', function() {
    if (class_exists('WP_StyleSetManager')) {
        $GLOBALS['wp_style_set_manager'] = new WP_StyleSetManager();
    }
});

?>
