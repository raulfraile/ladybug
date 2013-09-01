<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

use Ladybug\Exception\InvalidTypeException;

class ExtendedTypeFactory
{

    /** @var array $types */
    protected $types;

    public function __construct()
    {
        $this->types = array();
    }

    public function add(ExtendedTypeInterface $type, $key = null)
    {
        $this->types[!is_null($key) ? $key : get_class($type)] = $type;
    }

    /**
     * @param $var
     * @param  int                                     $level
     * @return TypeInterface
     * @throws \Ladybug\Exception\InvalidTypeException
     */
    public function factory($type, $level = 0)
    {
        $result = null;

        if (!array_key_exists('type_extended_' . $type, $this->types)) {
            throw new InvalidTypeException;
        }

        $result = clone($this->types['type_extended_' . $type]);
        $result->setLevel($level);

        return $result;
    }
}
