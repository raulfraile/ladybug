<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Type/TArray variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Variable;

use Ladybug\Type\TFactory;

class TArray extends Variable {
    
    public function __construct($var, $level = 0) {
        $this->type = 'array';
        $this->value = array();
        $this->length = count($var);
        $this->level = $level + 1;
        
        if ($this->level < \Ladybug\Dumper::MAX_NESTING_LEVEL_ARRAYS) {
            foreach ($var as $k=>$v) {
                $this->add($v, $k);
            }
        }
    }
    
    public function getLength() {
        return $this->length;
    }
    
    public function add($var, $index = NULL) {
        $this->value[$index] = TFactory::factory($var, $this->level);
    }
    
    public function render($array_key = NULL) {
        $label = $this->type . '(' . count($this->value) . ')';
        $result = $this->renderTreeSwitcher($label, $array_key) . '<ol>';
        
        foreach ($this->value as $k=>$v) {
            $result .= '<li>'.$v->render($k).'</li>';
        }
        $result .= '</ol>';
        
        return $result;
    }
}