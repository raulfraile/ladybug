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

use Ladybug\Type\TypeInterface;

class Property
{

    /** @var string $name */
    protected $name;

    /** @var TypeInterface $value */
    protected $value;

    /** @var string $name */
    protected $visibility;

    /**
     * Set property name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get property name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set property visibility
     * @param string $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Get property visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getLevel()
    {
        return $this->value->getLevel();
    }

}
