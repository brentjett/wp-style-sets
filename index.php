<?php
/*
Plugin Name: WP Style Sets API
Version: 0.1
Author: Brent Jett
Description: A concept plugin for creating a set of styles to be compiled and output as either a file or <style> block.
*/
define('WP_STYLE_SETS_PLUGIN_ACTIVE', true);

require_once 'WP_StyleSetManager.class.php';

// Import test script
require_once 'test-files/tests.php';

// Setup manager object
add_action('init', function() {
    if (class_exists('WP_StyleSetManager')) {
        $manager = new WP_StyleSetManager();
        $GLOBALS['wp_style_set_manager'] = $manager;
    }
});



function wp_register_style_set($handle, $args = array()) {
    global $wp_style_set_manager;

    $args['handle'] = $handle;
    $set = new WP_StyleSet($args);
    $wp_style_set_manager->add_set($handle, $set);

    if (!empty($args['units'])) {
        foreach($args['units'] as $handle => $unit) {
            wp_add_style_to_set($handle, $set->handle, $unit);
        }
    }
    return $set;
}

function wp_enqueue_style_set($handle, $args = array()) {
    global $wp_style_set_manager;
    if (empty($args)) {

        // Check if set is already registered
        $set = $wp_style_set_manager->get_set($handle);
        if (isset($set)) {
            $set->is_enqueued = true;
        }
    } else {
        // not yet registered
        $set = wp_register_style_set($handle, $args);
        $set->is_enqueued = true;
    }
    return $set;
}

function wp_add_style_to_set($handle, $set_handle, $args = array()) {
    global $wp_style_set_manager;

    $set = $wp_style_set_manager->get_set($set_handle);
    if ($set) {
        $unit = new WP_StyleUnit($args);
        $unit->handle = $handle;
        $set->add_unit($unit);
    }
    return $unit;
}
?>
