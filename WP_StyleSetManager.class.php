<?php
// Load LESS Compiler
if ( file_exists( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' ) ) {
    require_once( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' );
}
// Load SASS Compiler
if ( file_exists( __DIR__ . '/vendor/leafo/scss/scss.inc.php' ) ) {
    require_once( __DIR__ . '/vendor/leafo/scss/scss.inc.php' );
}

require_once 'WP_StyleSet.class.php';
require_once 'WP_StyleUnit.class.php';

class WP_StyleSetManager {

    public $sets = array();
    public $units = array();

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
    - units: array of units
    - vars: default vars it pass to each compile cycle. These are overridden by unit vars of same name.
    - functions: array of PHP functions to register to the compilers.
    - import_dirs: array of paths to look for files to import. Default to active theme root.
    - contributor: array('handle' => 'basset', 'type' => 'theme')

    */
    public function add_set($handle, $set) {

        $this->sets[$handle] = $set;
        return $set;
    }

    public function get_set($handle) {
        return $this->sets[$handle];
    }

    // add item to set
    public function register_unit($unit, $set) {
        global $wp_style_sets;

        $wp_style_sets[$set] = $unit;
    }
}


?>
