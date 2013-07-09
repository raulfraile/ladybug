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

namespace Ladybug\Metadata;

use Ladybug\Exception\InvalidTypeException;
use Ladybug\Type\AbstractType;
use Ladybug\Extension\Type\BaseType as ExtensionType;
use Ladybug\Container;

class MetadataResolver
{

    protected $metadatas;

    public function __construct()
    {
        $this->metadatas = array();
    }

    public function add(MetadataInterface $metadata)
    {
        $this->metadatas[] = $metadata;
    }


    public function resolve($className)
    {
        foreach ($this->metadatas as $metadata) {
            if ($metadata->hasMetadata($className)) {
                return $metadata;
            }
        }

        return null;
    }

    public function getMetadata($className)
    {
        foreach ($this->metadatas as $metadata) {
            if ($metadata->hasMetadata($className)) {
                return $metadata->getMetadata($className);
            }
        }

        return array();
    }

    public function has($key)
    {
        return array_key_exists($key, $this->metadatas);
    }
}
