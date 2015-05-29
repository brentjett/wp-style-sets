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
        $manager = new WP_StyleSetManager();
        $GLOBALS['wp_style_set_manager'] = $manager;
    }
    do_action('wp_stylesets/register', $manager);
});

// On wp_head - render sets that are <style> block sets and are ENQUEUED
// On wp_enqueue_scripts - render sets that are files and are ENQUEUED
// on mc_css - render sets that are marked for editor include
// admin_enqueue_scripts support?

// TESTING Script

function test_print_some_css() {
    ?>
    body {
        background:red;
    }
    <?php
}

function test_return_array_css() {
    return array(
        'body' => array(
            'background' => 'blue',
            'color' => 'white'
        )
    );
}

add_action('wp_stylesets/register', function($manager) {

    /*
    Style Set
    - handle: basset-content
    - name: Basset Content
    - type is inferred from units
    - units: array of unitsn
    - vars: default vars it pass to each compile cycle. These are overridden by unit vars of same name.
    - functions: array of PHP functions to register to the compilers.
    - import_dirs: array of paths to look for files to import. Default to active theme root.
    - contributor: array('handle' => 'basset', 'type' => 'theme') - assume plugin, maybe go look for the handle in dirs.

    */
    $set = $manager->register_set('my-first-styleset', array(
        'name' => 'My First Styleset',
        'vars' => array(
            'main_color' => 'blue'
        ),
        'contributor' => array('handle' => 'wp-style-sets'),
        'render_as' => 'file'
    ));

    print_r($set);

});

add_filter('the_content', function($content) {
    global $wp_style_set_manager;
    ob_start();

    $set = $wp_style_set_manager->get_set('my-first-set');
    print_r($set);

    $content = ob_get_clean();
    return $content;
});

?>
