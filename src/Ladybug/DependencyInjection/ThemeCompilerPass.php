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
 * ThemeCompilerPass modifies the container registering themes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class ThemeCompilerPass extends AbstractCompilerPass
{
    public function process(ContainerBuilder $container)
    {
        $this->processTaggedServices($container, 'theme_resolver', self::TAG_THEME, 'addTheme', array(
            'theme_default'
        ));
    }
}
