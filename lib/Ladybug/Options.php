<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Options class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

use Ladybug\Type\TFactory;

class Options {
    
    private $options;
    
    public function __construct() {
        $this->options = array(
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
    }
    
    /**
     * Add or update an option value
     *
     * @param string $key Option name
     * @param mixed $value Option value
     */
    public function setOption($key, $value) {
        $this->options[$key] = $value;
    }
    
    /**
     * Gets the value of the given option name
     *
     * @param string $key Option name
     * @param mixed $default Default value, in case the option name does not exist
     * @return mixed Option value
     */
    public function getOption($key, $default = NULL) {
        if (isset($this->options[$key])) return $this->options[$key];
        else return $default;
    }
}