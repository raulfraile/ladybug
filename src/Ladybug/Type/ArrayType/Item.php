<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\ArrayType;

use Ladybug\Type\TypeInterface;

class Item
{

    /** @var mixed $key */
    protected $key;

    /** @var TypeInterface $value */
    protected $value;

    /**
     * Constructor.
     * @param string        $key
     * @param TypeInterface $value
     */
    public function __construct($key, TypeInterface $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Sets the item key
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Gets the item key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets the item value
     * @param TypeInterface $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Gets the item value.
     *
     * @return TypeInterface
     */
    public function getValue()
    {
        return $this->value;
    }

    public function setLevel($level)
    {
        $this->value->setLevel($level);
    }

    public function getLevel()
    {
        return $this->value->getLevel();
    }

}
