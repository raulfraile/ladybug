<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

/**
 * AbstractType is the base type all specific types extends from
 */
abstract class AbstractType implements RenderizableTypeInterface, LoadableInterface
{

    const TYPE_ID = '';

    /** @var string $id */
    protected $id;

    /** @var string $type */
    protected $type;

    /** @var mixed $value */
    protected $value;

    /** @var int $level */
    protected $level;

    /** @var string $encoding */
    protected $encoding;

    /** @var int $length */
    protected $length;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id = uniqid();
        $this->level = 0;
    }

    /**
     * Gets type id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets type id
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets type
     *
     * @return string Variable type
     */
    public function getType()
    {
        return static::TYPE_ID;
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
     * Gets the formatted value
     *
     * @return string
     */
    public function getFormattedValue()
    {
        return (string) $this->value;
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

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getLength()
    {
        return $this->length;
    }

    /**
     * Get the template name that must be used to render this type
     *
     * @return string
     */
    public function getTemplateName()
    {
        return $this->type;
    }

    public function load($var, $level = 1)
    {
        $this->level = $level;
        $this->value = $var;
    }

    /**
     * Set encoding
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * Get encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    public function __clone()
    {
        $this->id = uniqid();
    }

    public function getInlineValue()
    {
        return $this->value;
    }
}
