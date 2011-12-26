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
use Ladybug\Options;
use Ladybug\CLIColors;

class TString extends Variable {
    
    protected $length;
    protected $encoding;
    
    public function __construct($var, $level, Options $options) {
        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->encoding);
        
        parent::__construct('string', $var, $level, $options);
    }
    
    public function getValue() {
        if ($this->options->getOption('string.show_quotes')) return '"' . $this->value . '"';
        else return $this->value;
    }
    
    protected function _renderHTML($array_key = NULL) {
        return '<div class="final">'.$this->renderArrayKey($array_key).'<span class="type">'.$this->type.'('.$this->length.')</span> <span style="color:'.$this->getColor('html').'">'.htmlentities($this->getValue()).'</span></div>';
    }
    
    protected function _renderCLI($array_key = NULL) {
        return $this->renderArrayKey($array_key) . $this->type .'('.$this->length.') '. CLIColors::getColoredString($this->getValue(), $this->getColor('cli')) . "\n";
    }
    
    public function export() {
        $return = array(
            'type' => $this->type,
            'value' => $this->value,
            'length' => $this->length,
            'encoding' => $this->encoding
        );
        
        return $return;
    }
}