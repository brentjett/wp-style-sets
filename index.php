<?php
/*
Plugin Name: WP Style Sets
Version: 0.1
Author: Brent Jett
Description: A concept plugin for creating a set of styles to be compiled and output as either a file or <style> block.
*/

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

// Print enqueued <style> blocks
add_action('wp_print_styles', function() {
    global $wp_style_set_manager;

    $sets = $wp_style_set_manager->sets;
    foreach($sets as $set) {
        if ($set->is_enqueued && ($set->render_as == 'embed')) {
            if ($css = $set->render()) {
                print "\n\n<style id='$set->handle'>\n$css\n</style>\n\n";
            }
        }
    }
}, 100);

// On wp_head - render sets that are <style> block sets and are enqueued
// On wp_enqueue_scripts - render sets that are files and are enqueued
// On wp_print_styles - render sets that are embed <style> blocks that are enqueued
// on mc_css - render sets that are marked for editor include
// admin_enqueue_scripts support?



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
