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

use Ladybug\Type\TypeInterface;

/**
 * Constant is an abstraction of a class constant
 */
class Constant
{

    /** @var string $name Constant name */
    protected $name = null;

    /** @var TypeInterface $value Constant value */
    protected $value = null;

    /**
     * Constructor.
     * @param string        $name  Constant name
     * @param TypeInterface $value Constant value
     */
    public function __construct($name, TypeInterface $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Gets the constant name.
     *
     * @return string Constant name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the constant value.
     *
     * @return TypeInterface Constant value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets the level of the underlying object value.
     *
     * @return int Level
     */
    public function getLevel()
    {
        if (is_null($this->value)) {
            return 0;
        }

        return $this->value->getLevel();
    }
}
