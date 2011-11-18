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
use Ladybug\Options;
use Ladybug\CLIColors;

class TNull extends Variable {
    
    public function __construct($level, Options $options) {
        parent::__construct('null', NULL, $level, $options);
    }
    
    public function getValue() {
        return NULL;
    }
}