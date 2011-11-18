<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

use Ladybug\Type\TFactory;

class Options {
    private $options = array(
        'array.max_nesting_level' => 8,
        'object.max_nesting_level' => 3,
        'object.show_data' => TRUE,
        'object.show_classinfo' => TRUE,
        'object.show_constants' => TRUE,
        'object.show_methods' => TRUE,
        'object.show_properties' => TRUE,
        'processor.active' => TRUE,
        'bool.html_color' => '#008',
        'bool.cli_color' => 'blue',
        'float.html_color' => '#800',
        'float.cli_color' => 'red',
        'int.html_color' => '#800',
        'int.cli_color' => 'red',
        'string.html_color' => '#080',
        'string.cli_color' => 'green',
        'string.show_quotes' => TRUE
    );
    
    public function __construct() {
        
    }
    
    public function setOption($key, $value) {
        $this->options[$key] = $value;
    }
    
    public function getOption($key, $default = NULL) {
        if (isset($this->options[$key])) return $this->options[$key];
        else return $default;
    }
}