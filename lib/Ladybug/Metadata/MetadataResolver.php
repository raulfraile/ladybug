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

    public function has($className)
    {
        foreach ($this->metadatas as $metadata) {
            if ($metadata->hasMetadata($className)) {
                return true;
            }
        }

        return false;
    }
}
