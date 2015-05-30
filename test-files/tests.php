<?php

add_action('wp_enqueue_scripts', function() {

    // wp_register_style( $handle, $src, $deps = array(), $ver = false, $media = 'all' );
    //  wp_enqueue_style( $handle, $src = false, $deps = array(), $ver = false, $media = 'all' );

    wp_enqueue_style_set("basset-content-set", array(
        'name' => 'Basset Content Styles',
        'units' => array(
            'basset-vars' => array(
                'name' => 'Basset Variables',
                'lang' => 'css',
                'source' => 'my_test_function'
            ),
            'basset-tests' => array(
                'name' => 'Basset Tests',
                'lang' => 'css',
                'source' => function() {
                    return "body .page { background:#333; color:white; } p {text-align:center;}";
                }
            ),
            'test-less-file' => array(
                'name' => 'Test Less File',
                'lang' => 'less',
                'source' => __DIR__ . '/test-static.less'
            ),
            'test-scss-file' => array(
                'name' => 'Test SCSS File',
                'lang' => 'scss',
                'source' => __DIR__ . '/test-scss.scss'
            ),
        ),
        'vars' => array(
            'primary_color' => 'white',
            'primary_background_color' => 'navy'
        )
    ));

});

// TESTING: Add inspector content before page content
add_filter('the_content', function($content) {
    global $wp_style_set_manager;
    $sets = $wp_style_set_manager->sets();
    if (!empty($sets) ) {
        foreach($sets as $handle => $set) {
            $set->inspect();
        }
    }

    ob_start();



    return ob_get_clean() . $content;
});



function my_test_function() {
    ob_start();
    ?>
    main { /* empty - from my_test_function() */ }
    <?
    return ob_get_clean();
}
?>
