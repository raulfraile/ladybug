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
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

abstract class AbstractCompilerPass implements CompilerPassInterface
{

    const TAG_ENVIRONMENT   = 'ladybug.environment';
    const TAG_FORMAT        = 'ladybug.format';
    const TAG_INSPECTOR     = 'ladybug.inspector';
    const TAG_METADATA      = 'ladybug.metadata';
    const TAG_RENDER        = 'ladybug.renderer';
    const TAG_THEME         = 'ladybug.theme';
    const TAG_TYPE          = 'ladybug.type';
    const TAG_TYPE_EXTENDED = 'ladybug.type.extended';

    /**
     * Processes tagged services
     *
     * @param ContainerBuilder $container
     * @param string           $manager
     * @param string           $tag
     * @param string           $method
     */
    protected function processTaggedServices(ContainerBuilder $container, $manager, $tag, $method, $params = array())
    {
        if (!$container->hasDefinition($manager)) {
            return;
        }

        $definition = $container->getDefinition($manager);

        $taggedServices = $container->findTaggedServiceIds($tag);

        foreach ($taggedServices as $id => $attributes) {
            $methodParams = array();

            if (!empty($attributes)) {
                foreach ($params as $param) {
                    if (isset($attributes[0][$param])) {
                        $methodParams[] = $attributes[0][$param];
                    }
                }
            }

            $definition->addMethodCall(
                $method,
                array_merge(array(new Reference($id), $id), $methodParams)
            );
        }
    }

}
