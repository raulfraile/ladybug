<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/TBase: Base type
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;
use Ladybug\CLIColors;

/**
 * TBase is the base type all specific types extends from
 */
abstract class TBase
{

    /** @var string $type */
    protected $type;

    /** @var mixed $value */
    protected $value;

    /** @var int $level */
    protected $level;

    /** @var Options $options */
    protected $options;

    /** @var string $encoding */
    protected $encoding;

    /**
     * Constructor
     *
     * @param string  $type
     * @param mixed   $value
     * @param int     $level
     * @param Options $options
     */
    public function __construct($type, $value, $level, Options $options)
    {
        $this->type = $type;
        $this->value = $value;
        $this->level = $level + 1;
        $this->options = $options;
    }

    /**
     * Gets the variable type
     *
     * @return string Variable type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the variable type
     *
     * @param string $type Variable type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the variable value
     *
     * @return mixed Variable value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the variable value
     *
     * @param mixed $value Variable value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Gets the variable level in the dump tree
     *
     * @return int Variable level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Sets the variable level in the dump tree
     *
     * @param int $level Variable level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Gets the variable color based on variable type
     *
     * @param  string $format Format: html or cli
     * @return string Color value
     */
    protected function getColor($format = 'html')
    {
        if ($format == 'html') return $this->options->getOption($this->type.'.html_color');
        elseif ($format == 'cli') return $this->options->getOption($this->type.'.cli_color');
        else return NULL;
    }

    /**
     * Renders the variable node in the dump tree
     *
     * @param  mixed  $array_key if the variable is part of an array, its value
     * @param  string $format    Format: html or cli
     * @return string Variable representation
     */
    public function render($array_key = NULL, $format = 'html', $escape = false)
    {
        if ($format == 'html') return $this->_renderHTML($array_key, $escape);
        elseif ($format == 'cli') return $this->_renderCLI($array_key, $escape);
        elseif ($format == 'txt') return $this->_renderTXT($array_key, $escape);
        else return NULL;
    }

    /**
     * Renders the variable node in the dump tree using HTML code
     *
     * @param  mixed  $array_key if the variable is part of an array, its value
     * @return string Variable representation
     */
    protected function _renderHTML($array_key = NULL, $escape = false)
    {
        $html = '<div class="final">';
            $html .= $this->renderArrayKey($array_key, $escape);
            $html .= '<span class="type">'.$this->type.'</span> ';
            $html .= '<span style="color:'.$this->getColor('html').'">'.$this->getValue().'</span>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Renders the variable node in the dump tree using CLI code
     *
     * @param  mixed  $array_key if the variable is part of an array, its value
     * @return string Variable representation
     */
    protected function _renderCLI($array_key = NULL)
    {
        $cli = $this->renderArrayKey($array_key) . $this->type . ' ';
        $cli .= CLIColors::getColoredString($this->getValue(), $this->getColor('cli'));
        $cli .= "\n";

        return $cli;
    }

    /**
     * Renders the variable node in the dump tree using TXT code
     *
     * @param  mixed  $array_key if the variable is part of an array, its value
     * @return string Variable representation
     */
    protected function _renderTXT($array_key = NULL)
    {
        $ret = $this->renderArrayKey($array_key) . $this->type . ' ';
        $ret .= $this->getValue();
        $ret .= "\n";

        return $ret;
    }

    protected function renderArrayKey($key, $escape = true)
    {
        if (is_null($key)) {
            return NULL;
        }
        else {
            return '['. ($escape ? htmlentities($key, ENT_COMPAT, $this->_getEncodingForHtmlentities()) : $key). ']: ';
        }
    }

    protected function renderTreeSwitcher($label, $array_key = NULL)
    {
        $tree_id = \Ladybug\Dumper::getTreeId();

        $result = '<label for="tree_'.$this->type.'_'.$tree_id.'">';
            $result .= $this->renderArrayKey($array_key);
            $result .= '<span class="switcher">'.$label.'</span>';
        $result .= '</label>';

        $result .= '<input type="checkbox" id="tree_'.$this->type.'_'.$tree_id.'"';

        if ($this->options->getOption('general.expanded')) {
            $result .= ' checked';
        }

        $result .= ' />';

        return $result;
    }

    protected function getIncludeClass($name, $type = 'object')
    {
        $class = '';
        $path_array = explode('\\', $name);
        $path_number = count($path_array);
        $class_name = '';

        for ($i=0;$i<$path_number;$i++) {
            $class_name .= str_replace(' ', '', ucwords($path_array[$i]));
            if (($i+1) < $path_number) $class_name .= '\\';
        }

        if ($type == 'object') $class = 'Ladybug\\Extension\\Object\\'.$class_name;
        elseif ($type == 'resource') $class = 'Ladybug\\Extension\\Resource\\'.$class_name;

        return $class;
    }

    protected function indentCLI($increment = 0)
    {
        $char1 = CLIColors::getColoredString('   ', 'dark_gray');
        $char2 = CLIColors::getColoredString(' | ', 'dark_gray');

        $result = '';
        for ($i=0;$i<($this->level + $increment);$i++) {
            if ($i==0) $result .= $char1;
            else $result .= $char2;
        }

        return $result;
    }

    protected function indentTXT($increment = 0)
    {
        $char1 = '   ';
        $char2 = ' | ';

        $result = '';
        for ($i=0;$i<($this->level + $increment);$i++) {
            if ($i==0) $result .= $char1;
            else $result .= $char2;
        }

        return $result;
    }

    public function export()
    {
        $return = array(
            'type' => $this->type,
            'value' => $this->value
        );

        return $return;
    }

    protected function _getEncodingForHtmlentities()
    {
        $validEncodings = array(
            'ISO-8859-1', 'ISO8859-1',
            'ISO-8859-5', 'ISO8859-5',
            'ISO-8859-15', 'ISO8859-15',
            'UTF-8',
            'CP866', 'IBM866', '866',
            'CP1251', 'WINDOWS-1251', 'WIN-1251', '1251',
            'CP1252', 'WINDOWS-1252', '1252',
            'KOI8-R', 'KOI8-RU', 'KOI8R',
            'BIG5', '950',
            'GB2312', '936',
            'BIG5-HKSCS',
            'SHIFT_JIS', 'SJIS', 'SJIS-WIN', 'CP932', '932',
            'EUC-JP', 'EUCJP', 'EUCJP-WIN',
            'MACROMAN'
        );

        if (in_array(strtoupper($this->encoding), $validEncodings)) {
            return $this->encoding;
        } else {
            return 'ISO-8859-1';
        }
    }
}
