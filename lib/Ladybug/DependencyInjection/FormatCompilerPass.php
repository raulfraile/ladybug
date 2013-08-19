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
 * FormatCompilerPass modifies the container registering formats
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class FormatCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'format_resolver', self::TAG_FORMAT, 'register');
    }
}
