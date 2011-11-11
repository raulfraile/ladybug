<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Type/TString variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Variable;
use Ladybug\CLIColors;

class TString extends Variable {
    
    protected $length;
    
    public function __construct($var) {
        $this->type = 'string';
        $this->value = $var;
        $this->length = strlen($this->value);
    }
    
    public function getValue() {
        return '"' . $this->value . '"';
    }
}