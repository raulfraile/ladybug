<?php

namespace Ladybug\ObjectMetadata;

use Ladybug\Container;

class ObjectMetadataResolver
{

    /** @var array $environments */
    protected $metadatas = array();

    public function __construct(Container $container)
    {
        $this->register($container['metadata.php_objects']);
        $this->register($container['metadata.symfony']);
        $this->register($container['metadata.aura']);
        $this->register($container['metadata.silex']);
        $this->register($container['metadata.twig']);
    }

    /**
     * Registers a new environment
     *
     * When resolving, this environment is preferred over previously registered ones.
     *
     * @param MetadataInterface $environment
     */
    public function register(MetadataInterface $metadata)
    {
        array_unshift($this->metadatas, $metadata);
    }

    /**
     * Resolve environment
     *
     * @return MetadataInterface
     */
    public function resolve($class)
    {
        foreach ($this->metadatas as $item) {
            /** @var MetadataInterface $item */

            if ($item->hasMetadata($class)) {
                return $item->getMetadata($class);
            }
        }

        return array();
    }
}
