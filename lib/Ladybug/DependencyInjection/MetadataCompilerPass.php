<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * MetadataCompilerPass modifies the container registering metadatas
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class MetadataCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'metadata_resolver', self::TAG_METADATA, 'add');
    }
}
