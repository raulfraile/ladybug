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
 * RendererCompilerPass modifies the container registering renders
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class RendererCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'renderer_resolver', self::TAG_RENDER, 'add');
    }
}
