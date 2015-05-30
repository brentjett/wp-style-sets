<?php


class WP_StyleSet {

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

        add_filter('wp_stylesets/compile/css', array($this, 'compile_css_unit'), 10, 3);
        add_filter('wp_stylesets/compile/less', array($this, 'compile_less_unit'), 10, 3);
        add_filter('wp_stylesets/compile/scss', array($this, 'compile_scss_unit'), 10, 3);
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

    public function add_unit($unit) {
        $this->units[] = $unit;
    }

    public function render() {

        $set_vars = $this->vars;
        $css = '';

        if (!empty($this->units)) {
            foreach($this->units as $handle => $unit) {

                $unit->raw_css = "\n\n/* Style Unit: $unit->handle/$unit->name */\n";

                // Get Source Text
                if (is_callable($unit->source)) {
                    $unit->raw_css .= call_user_func($unit->source);
                } else {
                    if (file_exists($unit->source)) {
                        $unit->raw_css .= file_get_contents($unit->source);
                    }
                }

                // Compile
                $lang = $unit->lang;
                $vars = array('test_var' => 'TEST VAR');
                $unit->compiled_css .= apply_filters("wp_stylesets/compile/{$lang}", $unit->raw_css, $vars, $unit );
                $css .= $unit->compiled_css;
            }
        }
        return $css;
    }




    public function compile_css_unit($raw_css, $vars, $unit) {
        return $raw_css;
    }

    public function compile_less_unit($raw_css, $vars, $unit) {
        // Load LESS Compiler
        if ( file_exists( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' ) ) {
            require_once( __DIR__ . '/vendor/leafo/lessphp/lessc.inc.php' );
        }
        $less = new lessc();
        $less->setVariables($vars);
        return $less->compile($raw_css);
    }

    public function compile_scss_unit($raw_css, $vars, $unit) {
        // Load SASS Compiler
        if ( file_exists( __DIR__ . '/vendor/leafo/scssphp/scss.inc.php' ) ) {
            require_once( __DIR__ . '/vendor/leafo/scssphp/scss.inc.php' );
        }

        $scss = new scssc();
        $scss->setVariables($vars);
        return $scss->compile($raw_css);
    }

    /* Print HTML inspector view - Needs Work */
    public function inspect() {
        ?>
        <div class="set-inspector" style="padding:20px; border:1px solid red;">
            <h1 style="margin-top:0px;"><?php print $this->name ?></h1>
            <?php foreach($this->units as $handle => $unit) { ?>
                <div><?=$unit->handle ?></div>
                <div><?=$unit->name ?> - <?=$unit->lang ?></div>
            <?php } ?>
        </div>
        <?
    }

}
?>
