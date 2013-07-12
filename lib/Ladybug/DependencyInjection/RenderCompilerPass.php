<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RenderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('render_resolver')) {
            return;
        }

        $definition = $container->getDefinition(
            'render_resolver'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.render'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'add',
                array(new Reference($id), $id)
            );
        }
    }
}
