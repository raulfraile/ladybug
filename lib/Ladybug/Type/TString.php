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
    protected $encoding;

    /**
     * Constructor
     * @param string  $var
     * @param int     $level
     * @param Options $options
     */
    public function __construct($var, $level, Options $options)
    {
        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->encoding);

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

    protected function _renderHTML($array_key = null)
    {
        return '<div class="final">'.
            $this->renderArrayKey($array_key).
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

    private function _getEncodingForHtmlentities()
    {
        $validEncodings = array(
            'iso-8859-1', 'iso8859-1',
            'iso-8859-5', 'iso8859-5',
            'iso-8859-15', 'iso8859-15',
            'utf-8',
            'cp866', 'ibm866', '866',
            'cp1251', 'Windows-1251', 'win-1251', '1251',
            'cp1252', 'Windows-1252', '1252',
            'KOI8-R', 'koi8-ru', 'koi8r',
            'BIG5', '950',
            'GB2312', '936',
            'BIG5-HKSCS',
            'Shift_JIS', 'SJIS', 'SJIS-win', 'cp932', '932',
            'EUC-JP', 'EUCJP', 'eucJP-win',
            'MacRoman'
        );

        if (in_array($this->encoding, $validEncodings)) {
            return $this->encoding;
        } else {
            return 'ISO-8859-1';
        }
    }
}
