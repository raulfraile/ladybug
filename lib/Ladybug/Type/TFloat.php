<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Type/TFloat variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Variable;
use Ladybug\CLIColors;

class TFloat extends Variable {
    
    public function __construct($var, $level = 0) {
        parent::__construct('float', $var, $level);
    }
    
}