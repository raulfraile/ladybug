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



    public function __clone()
    {
        $this->id = uniqid();
    }

    public function getInlineValue()
    {
        return $this->value;
    }
}
