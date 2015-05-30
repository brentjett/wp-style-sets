<?php
class WP_StyleUnit {

    /*
    Style Unit
    - handle : basset-vars
    - name : Basset Vars
    - lang : less
    - contributor : array('handle' => 'basset', 'type' => 'theme')
    - source : path/to/file.less OR function_to_return_less()
    - vars? : an array of vars to use at compile - might override any vars of same name defined in Set
    - is_library: Declare that a unit is a library of vars and mixins. DOES NOT PRINT ANYTHING
    */

    public $handle;
    public $name;
    public $lang = 'css'; // css, less, scss
    public $source = ''; // file path or callable function
    public $source_args = array();
    public $vars = array();
    public $is_library = false;

    function __construct($args = array()) {
        if ($args['handle']) $this->handle = $args['handle'];
        if ($args['name']) $this->name = $args['name'];
        if ($args['lang']) $this->lang = $args['lang'];
        if ($args['source']) $this->source = $args['source'];
        if ($args['source_args']) $this->source_args = $args['source_args'];
        if ($args['vars']) $this->vars = $args['vars'];
        if ($args['is_library']) $this->is_library = $args['is_library'];
    }

}
?>
