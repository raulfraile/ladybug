<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Type/TBool variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Variable;

class TBool extends Variable {
    
    public function __construct($var) {
        $this->type = 'bool';
        $this->value = $var;
    }
    
    public function render($array_key = NULL) {
        $value = $this->value ? 'TRUE' : 'FALSE';
        
        return '<div class="final">'.$this->renderArrayKey($array_key).'<strong><em>bool</em></strong> <span style="color:'.self::COLOR_BOOL.'">'.$value.'</span></div>';
    }
}