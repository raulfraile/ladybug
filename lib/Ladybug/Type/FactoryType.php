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
use Ladybug\Type\BaseType;
use Ladybug\Extension\Type\BaseType as ExtensionType;
use Ladybug\Container;

class FactoryType
{

    /** @var Container $container */
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function factory($var, $key = null, $level = 0)
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
            $result = $this->container->get('ladybug.type.null');
            $result->load($var, $key);
        } elseif (is_bool($var)) {
            $result = $this->container->get('ladybug.type.bool');
            $result->load($var, $key);
        } elseif (is_string($var)) {
            $result = $this->container->get('ladybug.type.string');
            $result->load($var, $key);
        } elseif (is_int($var)) {
            $result = $this->container->get('ladybug.type.int');
            $result->load($var, $key);
        } elseif (is_float($var)) {
            $result = $this->container->get('ladybug.type.float');
            $result->load($var, $key);
        } elseif (is_array($var)) {
            $result = $this->container->get('ladybug.type.array');
            $result->load($var, $key);

        } elseif (is_object($var)) {
            $result = $this->container->get('ladybug.type.object');
            $result->setLevel($level+1);
            $result->load($var, $key);
        } elseif (is_resource($var)) {
            $result = $this->container->get('ladybug.type.resource');
            $result->setLevel($level++);
            $result->load($var, $key);
        } else {
            throw new InvalidTypeException();
        }

        return $result;
    }
}
