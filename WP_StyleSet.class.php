<?php
class WP_StyleSet {

    //public $manager; // Not sure why I need it after all
    public $handle = '';
    private $name = '';
    public $units = array();
    public $vars = array();
    public $is_enqueued = false; // if true, print to front side
    public $is_editor_style = false; // add to editor
    public $render_as = 'embed'; // embed for <style> block, file path for file

    function __construct($args) {

        if (isset($args['handle'])) $this->handle = $args['handle'];
        if (isset($args['name'])) $this->name = $args['name'];
        if (isset($args['vars'])) $this->vars = $args['vars'];
        //if (isset($args['units'])) $this->units = $args['units'];
        if (isset($args['is_enqueued'])) $this->is_enqueued = $args['is_enqueued'];
        if (isset($args['is_editor_style'])) $this->is_editor_style = $args['is_editor_style'];
        if (isset($args['render_as'])) $this->render_as = $args['render_as'];

        /*
        if (isset($args['manager']) {
            $this->manager = $args['manager'];
        } else {
            global $wp_style_set_manager;
            $this->manager = $wp_style_set_manager;
        }
        */

        add_filter('wp_stylesets/compile/css', array($this, 'compile_css_unit'), 10, 2);
        add_filter('wp_stylesets/compile/less', array($this, 'compile_less_unit'), 10, 2);

    }

    public function __get($name) {
        if ($name == 'name') {
            if ($this->name != '') {
                return $this->name;
            } else {
                return $this->handle;
            }
        }
        if ($this->{$var}) {
            return $this->{$var};
        }
    }

    public function render() {

        $css = '';
        $set_vars = $this->vars();

        if (!empty($this->units)) {
            foreach($this->units as $handle => $unit) {

                $lang = $unit->lang;
                $css .= apply_filters("wp_stylesets/compile/{$lang}", $unit, $set_vars );
            }
        }
        return $css;
    }

    // Get any compile variables specified on the set
    public function vars() {
        return apply_filters('wp_stylesets/set_vars', $this->vars, $this);
    }

    public function add_unit($unit) {
        $this->units[] = $unit;
    }

    public function compile_css_unit($unit, $set_vars) {

        $css = "\n\n/* Style Unit: $unit->handle/$unit->name */\n";

        if (is_callable($unit->source)) {
            $css .= call_user_func($unit->source);
        } else {
            if (file_exists($unit->source)) {
                $css .= file_get_contents($unit->source);
            }
        }
        return $css;
    }

    public function compile_less_unit($unit, $set_vars) {
        $css = $unit->source() . "\n";
        return $css;
    }

}
?>
