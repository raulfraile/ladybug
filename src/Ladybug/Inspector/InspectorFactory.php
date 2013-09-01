<?php

/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/FactoryType: Types factory
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector;

class InspectorFactory
{

    protected $inspectors;

    public function __construct()
    {

    }

    public function add(InspectorInterface $inspector, $key)
    {
        $this->inspectors[$key] = $inspector;
    }

    /**
     * @param $var
     * @param  int                                     $level
     * @return TypeInterface
     * @throws \Ladybug\Exception\InvalidTypeException
     */
    public function factory($class)
    {
        return $this->inspectors[$class];
    }

    public function has($key)
    {
        return array_key_exists($key, $this->inspectors);
    }
}
