<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\ObjectType;

class MethodParameter
{

    /** @var string $name */
    protected $name;

    /** @var string $type */
    protected $type;

    /** @var bool $isReference */
    protected $isReference = false;

    /** @var mixed $defaultValue */
    protected $defaultValue = null;

    /**
     * Set default value
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Get default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param boolean $isReference
     */
    public function setIsReference($isReference)
    {
        $this->isReference = $isReference;
    }

    /**
     * @return boolean
     */
    public function getIsReference()
    {
        return $this->isReference;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
