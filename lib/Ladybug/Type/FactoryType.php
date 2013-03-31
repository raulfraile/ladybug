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
use Ladybug\Extension\Type\BaseType as ExtensionType;
use Pimple;

class FactoryType
{
    public static function factory($var, $level, Pimple $container, $key = null)
    {
        $result = null;

        if ($var instanceof \Ladybug\Extension\Type\CollectionType) {
            $data = array();
            foreach ($var->getData() as $key => $item) {
                $data[$key] = FactoryType::factory($item, $level, $container);
            }
            $var->setProcessedData($data);

            return $var;
        } elseif ($var instanceof ExtensionType) {
            //$class = get_class($var);
            //$result = new $class($var->getValue(), $level, $container);
            $result = $var;
        } elseif ($var === null) {
            $result = new NullType($level, $container, $key);
        } elseif (is_bool($var)) {
            $result = new BoolType($var, $level, $container, $key);
        } elseif (is_string($var)) {
            $result = new StringType($var, $level, $container, $key);
        } elseif (is_int($var)) {
            $result = new IntType($var, $level, $container, $key);
        } elseif (is_float($var)) {
            $result = new FloatType($var, $level, $container, $key);
        } elseif (is_array($var)) {
            $result = new ArrayType($var, $level, $container, $key);
        } elseif (is_object($var)) {
            $result = new ObjectType($var, $level, $container, $key);
        } elseif (is_resource($var)) {
            $result = new ResourceType($var, $level, $container, $key);
        } else {
            throw new InvalidTypeException();
        }

        return $result;
    }
}
