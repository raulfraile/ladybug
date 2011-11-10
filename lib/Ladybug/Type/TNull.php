<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Type/TNull variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Variable;

class TNull extends Variable {
    
    public function __construct() {
        $this->type = 'null';
        $this->value = NULL;
    }
    
    public function render($array_key = NULL) {
        return '<div class="final">'.$this->renderArrayKey($array_key).'<strong><em>' . $this->type . '</em></strong> '.$this->value.'</div>';
    }
}