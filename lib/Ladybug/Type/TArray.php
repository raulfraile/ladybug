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

use Ladybug\Options;
use Ladybug\CLIColors;

class TArray extends TBase
{

    const TYPE_ID = 'array';

    protected $length;

    public function __construct($var, $level, Options $options)
    {
        parent::__construct(self::TYPE_ID, array(), $level, $options);

        $this->length = count($var);

        if ($this->level < $this->options->getOption('array.max_nesting_level')) {
            foreach ($var as $k=>$v) {
                $this->add($v, $k);
            }
        }
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        if ($length >= 0) $this->length = $length;
    }

    public function add($var, $index = null)
    {
        $this->value[$index] = TFactory::factory($var, $this->level, $this->options);
    }

    // override
    protected function _renderHTML($array_key = null, $escape = true)
    {
        $label = $this->type . '(' . $this->length . ')';

        $result = $this->renderTreeSwitcher($label, $array_key);

        if ($this->length > 0) {
            $result .= '<ol>';

            foreach ($this->value as $k=>$v) {

                $result .= '<li>'.$v->render($k, 'html', true).'</li>';
            }
            $result .= '</ol>';
        }

        return $result;
    }

    // override
    protected function _renderCLI($array_key = null)
    {
        $label = $this->type . '(' . $this->length . ')';

        $result = '';

        if (!is_null($array_key)) $result .= '[' . $array_key . ']: ';

        $result .= CLIColors::getColoredString($label, 'yellow') . "\n";

        foreach ($this->value as $k=>$v) {
            $result .= $this->indentCLI() . $v->render($k, 'cli');
        }

        return $result;
    }

    // override
    protected function _renderTXT($array_key = null)
    {
        $label = $this->type . '(' . $this->length . ')';

        $result = '';

        if (!is_null($array_key)) $result .= '[' . $array_key . ']: ';

        $result .= $label . "\n";

        foreach ($this->value as $k=>$v) {
            $result .= $this->indentTXT() . $v->render($k, 'txt');
        }

        return $result;
    }

    public function export()
    {
        $value = array();

        foreach ($this->value as $k=>$v) {
            $value[] = $v->export();
        }

        return array(
            'type' => $this->type,
            'value' => $value,
            'length' => $this->length
        );
    }
}
