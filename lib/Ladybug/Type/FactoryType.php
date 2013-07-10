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

use Ladybug\Exception\InvalidTypeException;
use Ladybug\Extension\Type\BaseType as ExtensionType;
use Ladybug\Container;

class FactoryType
{

    /** @var Container $container */
    protected $container;

    protected $types;

    public function __construct()
    {

    }

    public function add(TypeInterface $type, $key = null)
    {
        $this->types[!is_null($key) ? $key : get_class($type)] = $type;
    }

    /**
     * @param $var
     * @param  int                                     $level
     * @return TypeInterface
     * @throws \Ladybug\Exception\InvalidTypeException
     */
    public function factory($var, $level = 0)
    {
        $result = null;

        if ($var instanceof \Ladybug\Type\Extended\CollectionType) {
            $data = array();
            foreach ($var->getData() as $key => $item) {
                $data[$key] = FactoryType::factory($item, $level);
            }
            $var->setProcessedData($data);

            return $var;
        } elseif ($var instanceof ExtensionType) {
            //$class = get_class($var);
            //$result = new $class($var->getValue(), $level, $container);
            $result = $var;
        } elseif ($var === null) {
            $result = clone($this->types['type_null']);
            $result->setLevel($level+1);
            $result->load($var);
        } elseif (is_bool($var)) {
            $result = clone($this->types['type_bool']);
            $result->setLevel($level+1);
            $result->load($var);
        } elseif (is_string($var)) {
            $result = clone($this->types['type_string']);
            $result->setLevel($level+1);
            $result->load($var);
        } elseif (is_int($var)) {
            $result = clone($this->types['type_int']);
            $result->setLevel($level+1);
            $result->load($var);
        } elseif (is_float($var)) {
            $result = clone($this->types['type_float']);
            $result->setLevel($level+1);
            $result->load($var);
        } elseif (is_array($var)) {
            $result = clone($this->types['type_array']);
            $result->setLevel($level+1);
            $result->load($var);
        } elseif (is_object($var)) {
            $result = clone($this->types['type_object']);
            $result->setLevel($level+1);
            $result->load($var);
        } elseif (is_resource($var)) {
            $result = clone($this->types['type_resource']);
            $result->setLevel($level+1);
            $result->load($var);
        } else {
            throw new InvalidTypeException();
        }

        return $result;
    }
}
