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
 * TypeCompilerPass modifies the container registering types
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class TypeCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'type_factory', self::TAG_TYPE, 'add');
        $this->processTaggedServices($container, 'type_extended_factory', self::TAG_TYPE_EXTENDED, 'add');
    }
}
