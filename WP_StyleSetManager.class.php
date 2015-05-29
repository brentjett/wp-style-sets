<?php
// Load LESS Compiler
if ( file_exists( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' ) ) {
    require_once( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' );
}
// Load SASS Compiler
if ( file_exists( __DIR__ . '/vendor/leafo/scss/scss.inc.php' ) ) {
    require_once( __DIR__ . '/vendor/leafo/scss/scss.inc.php' );
}

class WP_StyleSetManager {

    public $style_sets = array();

    function __construct() {

    }

    public function get_style_sets() {
        return apply_filters('wp_stylesets/pre_get', $this->style_sets);
    }

    // add new set
    /*
    Style Set
    - handle: basset-content
    - name: Basset Content
    - type is inferred from units
    - units: array of unitsn
    - vars: default vars it pass to each compile cycle. These are overridden by unit vars of same name.
    - functions: array of PHP functions to register to the compilers.
    - import_dirs: array of paths to look for files to import. Default to active theme root.
    - contributor: array('handle' => 'basset', 'type' => 'theme')

    */
    public function register_styleset($handle, $args = array()) {
        global $wp_style_sets;

        $wp_style_sets[$handle] = $args;
    }

    // add item to set
    /*
    Style Unit
    - handle : basset-vars
    - name : Basset Vars
    - type : less
    - contributor : array('handle' => 'basset', 'type' => 'theme')
    - source : path/to/file.less OR function_to_return_less()
    - vars? : an array of vars to use at compile - might override any vars of same name defined in Set
    */
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
