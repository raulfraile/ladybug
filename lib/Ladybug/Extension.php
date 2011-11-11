<?php

namespace Ladybug;

class Extension {
    
    protected $var;
    protected $icon;
    protected $color_cli;
    protected $color_html;
    
    public function __construct($var) {
        $this->var = $var;
        $this->icon = NULL;
        $this->color_cli = NULL;
        $this->color_html = NULL;
    }
}