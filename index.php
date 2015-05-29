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

    $set = $manager->register_styleset('my-first-styleset', args(
        'name' => 'My First Styleset'
    ));

});

add_filter('the_content', function($content) {
    ob_start();



    $content = ob_get_clean();
    return $content;
});

?>
