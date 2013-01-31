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

use Ladybug\Options;
use Ladybug\CLIColors;

class TString extends TBase
{

    const TYPE_ID = 'string';

    protected $length;

    /**
     * Constructor
     * @param string  $var
     * @param int     $level
     * @param Options $options
     */
    public function __construct($var, $level, Options $options)
    {
        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->_getEncodingForHtmlentities());        


        parent::__construct(self::TYPE_ID, $var, $level, $options);
    }

    public function getValue()
    {
        if ($this->options->getOption('string.show_quotes')) {
            return '"' . $this->value . '"';
        } else {
            return $this->value;
        }
    }

    protected function _renderHTML($array_key = null, $escape = false)
    {
        return '<div class="final">'.
            $this->renderArrayKey($array_key, $escape).
            '<span class="type">' .
                $this->type . '(' . $this->length . ')</span> ' .
                '<span style="color:' . $this->getColor('html') . '">' .
                    htmlentities($this->getValue(), ENT_COMPAT, $this->_getEncodingForHtmlentities()) .
                '</span></div>';
    }

    protected function _renderCLI($array_key = null)
    {
        return $this->renderArrayKey($array_key) . $this->type .'('.$this->length.') '. CLIColors::getColoredString($this->getValue(), $this->getColor('cli')) . "\n";
    }

    protected function _renderTXT($array_key = null)
    {
        return $this->renderArrayKey($array_key) . $this->type .'('.$this->length.') '. $this->getValue() . "\n";
    }

    public function export()
    {
        return array(
            'type' => $this->type,
            'value' => $this->value,
            'length' => $this->length,
            'encoding' => $this->encoding
        );
    }
}
