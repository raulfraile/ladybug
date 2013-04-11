<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/BaseType: Base type
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Pimple;

/**
 * BaseType is the base type all specific types extends from
 */
abstract class BaseType implements TypeInterface
{

    /** @var string $type */
    protected $type;

    /** @var mixed $value */
    protected $value;

    /** @var int $level */
    protected $level;

    /** @var string $encoding */
    protected $encoding;

    protected $length;

    protected $container;

    protected $key;

    /**
     * Constructor
     *
     * @param string  $type
     * @param mixed   $value
     * @param int     $level
     */
    public function __construct($type, $value, $level, \Ladybug\Container $container, $key = null)
    {

        $this->type = $type;
        $this->value = $value;
        $this->container = $container;
        $this->level = $level + 1;
        $this->key = null;
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

    public function getFormattedValue()
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
     * Renders the variable node in the dump tree
     *
     * @param  mixed   $array_key if the variable is part of an array, its value
     * @param  string  $format    Format: html or cli
     * @param  boolean $escape
     * @return string  Variable representation
     */
    public function render($array_key = NULL, $format = 'html', $escape = false)
    {

        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../Theme/' . $this->getOption('theme') . '/' . $format);
        $twig = new Twig_Environment($loader);

        $result = $twig->render('t_'.static::TYPE_ID.'.'.$format.'.twig', array_merge(
            array(),//$this->getViewParameters(),
            array('var' => $this, 'array_key' => $array_key, 'level' => $this->level)
        ));


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

    public function getViewParameters()
    {
        return array(
            'value' => $this->value,
            'encoding' => $this->encoding,
            'type' => $this->type,
            'length' => $this->length
        );
    }

    public function getOption($key, $default = null)
    {
        return $this->container->getParameter($key);
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getLength()
    {
        return $this->length;
    }

    function getParameters()
    {
        return array(
            'var' => $this,
            'array_key' => $this->key,
            'level' => $this->level
        );
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }


}
