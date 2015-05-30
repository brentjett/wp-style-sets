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
                'name' => 'Basset Variables',
                'lang' => 'css',
                'source' => function() {
                    return "body { background:#333; } p {text-align:center;}";
                }
            ),
            'test-file' => array(
                'name' => 'Test File',
                'lang' => 'css',
                'source' => __DIR__ . '/test-files/test.css'
            )
        ),
        'vars' => array(
            'primary_color' => 'white',
            'primary_background_color' => 'navy'
        )
    ));

});

function my_test_function() {
    ob_start();
    ?>
    main {
        color:red;
        background:yellow;
        font-style:italic;
    }
    <?
    return ob_get_clean();
}
?>
