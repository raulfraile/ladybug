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

namespace Ladybug\Type;

use Ladybug\Options;
use Ladybug\Exception\InvalidTypeException;
use Ladybug\Type\BaseType;
use Pimple;

class FactoryType
{
    public static function factory($var, $level, Pimple $container)
    {
        $result = null;

        if ($var instanceof BaseType) {
            $class = get_class($var);
            $result = new $class($var->getValue(), $level, $container);
        } elseif ($var === null) {
            $result = new NullType($level, $container);
        } elseif (is_bool($var)) {
            $result = new BoolType($var, $level, $container);
        } elseif (is_string($var)) {
            $result = new StringType($var, $level, $container);
        } elseif (is_int($var)) {
            $result = new IntType($var, $level, $container);
        } elseif (is_float($var)) {
            $result = new FloatType($var, $level, $container);
        } elseif (is_array($var)) {
            $result = new ArrayType($var, $level, $container);
        } elseif (is_object($var)) {
            $result = new ObjectType($var, $level, $container);
        } elseif (is_resource($var)) {
            $result = new ResourceType($var, $level, $container);
        } else {
            throw new InvalidTypeException();
        }

        return $result;
    }
}
