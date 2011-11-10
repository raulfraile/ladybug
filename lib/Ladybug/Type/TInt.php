<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Type/TInt variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Variable;

class TInt extends Variable {
    
    public function __construct($var) {
        $this->type = 'int';
        $this->value = $var;
    }
    
    public function render($array_key = NULL) {
        return '<div class="final">'.$this->renderArrayKey($array_key).'<strong><em>int</em></strong> <span style="color:'.self::COLOR_INT.'">'.$this->value.'</span></div>';
    }
}