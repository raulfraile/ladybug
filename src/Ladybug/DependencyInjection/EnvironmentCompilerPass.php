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
 * EnvironmentCompilerPass modifies the container registering environments
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class EnvironmentCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'environment_resolver', self::TAG_ENVIRONMENT, 'register');
    }
}
