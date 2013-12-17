<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Object;

/**
 * MethodParameter is an abstraction of a parameter belonging to a class method
 */
class MethodParameter
{

    /** @var string $name Parameter name */
    protected $name = null;

    /** @var string $type Parameter type */
    protected $type = null;

    /** @var bool $reference */
    protected $reference = false;

    /** @var mixed $defaultValue */
    protected $defaultValue = null;

    /**
     * Sets the parameter default value.
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Gets the parameter default value.
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Sets or unsets the parameter as passed by reference
     * @param boolean $reference True if the parameter is passed by reference
     */
    public function setReference($reference = true)
    {
        $this->reference = $reference;
    }

    /**
     * Checks if the parameter is passed by reference
     *
     * @return boolean True if the parameter is passed by reference
     */
    public function isReference()
    {
        return $this->reference;
    }

    /**
     * Sets the parameter name.
     * @param string $name Parameter name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the parameter name.
     *
     * @return string Parameter name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the parameter type.
     * @param string $type Parameter type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the parameter type.
     *
     * @return string Parameter type
     */
    public function getType()
    {
        return $this->type;
    }
}
