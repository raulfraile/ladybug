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

class FactoryType
{

    /** @var array $types */
    protected $types;

    public function __construct()
    {
        $this->types = array();
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
    public function factory($var)
    {
        $result = null;

        /*if ($var instanceof \Ladybug\Type\Extended\CollectionType) {
            $data = array();
            foreach ($var->getData() as $key => $item) {
                $data[$key] = FactoryType::factory($item, $level);
            }
            $var->setProcessedData($data);

            return $var;
        } else*/if ($var === null) {
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
        } elseif (is_resource($var)) {
            $result = clone($this->types['type_resource']);
        }

        /** @var TypeInterface $result */
        $result->load($var);

        return $result;
    }
}
