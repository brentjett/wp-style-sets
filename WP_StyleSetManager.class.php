<?php

require_once 'WP_StyleSet.class.php';
require_once 'WP_StyleUnit.class.php';

class WP_StyleSetManager {

    private $sets = array();
    public $units = array();

    function __construct() {
        add_action('wp_print_styles', array($this, 'print_styles'));
    }

    public function sets() {
        return apply_filters('wp_stylesets/pre_get', $this->sets);
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

    // Print enqueued <style> blocks on wp_print_styles
    public function print_styles() {
        global $wp_style_set_manager;

        $sets = $wp_style_set_manager->sets;
        foreach($sets as $set) {
            if ($set->is_enqueued && ($set->render_as == 'embed')) {
                if ($css = $set->render()) {
                    print "Render Set: $set->name \n\n<style id='$set->handle'>$css</style>\n\n";
                }
            }
        }
    }
}


?>
