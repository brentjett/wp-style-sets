<?php

add_filter('the_content', function($content) {
    global $wp_style_set_manager;
    ob_start();

    $set = $wp_style_set_manager->get_set('my-first-set');

    $unitA = new WP_StyleUnit(array(
        'handle' => 'basset-vars',
        'name' => 'Basset Variables',
        'lang' => 'css',
        'source' => function() {
            return 'body { background:yellow; }';
        }
    ));
    $set->addUnit($unitA);

    $unitB = new WP_StyleUnit(array(
        'handle' => 'test-two',
        'name' => 'Test Two',
        'lang' => 'less',
        'source' => function() {
            return '@color:red; body { background:@color; }';
        }
    ));
    $set->addUnit($unitB);

    $css = $set->render();

    print "<pre>$css</pre>";

    print "<style>$css</style>";

    $content = ob_get_clean();
    return $content;
});
?>
