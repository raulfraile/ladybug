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
 * InspectorCompilerPass modifies the container registering inspectors
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class InspectorCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'inspector_manager', self::TAG_INSPECTOR, 'add');
    }
}
