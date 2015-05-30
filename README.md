# WP Style Sets API

A concept plugin for creating a set of styles to be compiled and output as either a file or style block.

The idea is that you can create a style set and then add pieces of css/less/sass to it that is ultimately rendered out and cached as a file or, if intended as a style block, in a transient field in the options table.

```php
wp_register_style_set($handle, $args = array())
wp_enqueue_style_set($handle, $args = array())

wp_add_style_to_set($handle, $set_handle, $args = array())
```

## Example
```php
add_action('wp_enqueue_scripts', function() {
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
```
