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

class FactoryType
{

    /** @var array $types */
    protected $types;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->types = array();
    }

    /**
     * Adds a new type.
     * @param TypeInterface $type
     * @param string        $key
     */
    public function add(TypeInterface $type, $key = null)
    {
        $this->types[!is_null($key) ? $key : get_class($type)] = $type;
    }

    /**
     * Factory method.
     * @param mixed $var
     * @param int   $level
     *
     * @return TypeInterface
     */
    public function factory($var, $level = 1)
    {
        $result = null;

        if (null === $var) {
            $result = clone($this->types['type_null']);
        } elseif (is_bool($var)) {
            $result = clone($this->types['type_bool']);
        } elseif (is_string($var)) {
            $result = clone($this->types['type_string']);
        } elseif (is_int($var)) {
            $result = clone($this->types['type_int']);
        } elseif (is_float($var)) {
            $result = clone($this->types['type_float']);
        } elseif (is_array($var)) {
            $result = clone($this->types['type_array']);
        } elseif (is_object($var)) {
            $result = clone($this->types['type_object']);
        } elseif ($this->isResource($var)) {
            $result = clone($this->types['type_resource']);
        }

        /** @var TypeInterface $result */
        $result->load($var, $level);

        return $result;
    }

    protected function isResource($var)
    {
        return !is_null(@get_resource_type($var));
    }
}
