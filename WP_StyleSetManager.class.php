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
    - units: array of unitsn
    - vars: default vars it pass to each compile cycle. These are overridden by unit vars of same name.
    - functions: array of PHP functions to register to the compilers.
    - import_dirs: array of paths to look for files to import. Default to active theme root.
    - contributor: array('handle' => 'basset', 'type' => 'theme')

    */
    public function register_set($handle, $args = array()) {

        $set = new WP_StyleSet();
        $set->manager = $this;
        $set->handle = $handle;
        $set->name = $args['name'];
        $set->vars = $args['vars'];
        // deal with args

        $this->sets[$handle] = $set;
        return $set;
    }

    public function get_set($handle) {
        return $this->sets[$handle];
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
    - is_library: Declare that a unit is a library of vars and mixins. DOES NOT PRINT ANYTHING
    */
    public function register_unit($unit, $set) {
        global $wp_style_sets;

        $wp_style_sets[$set] = $unit;
    }
}


?>
