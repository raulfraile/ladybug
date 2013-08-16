<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class InspectorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('inspector_manager')) {
            return;
        }

        $definition = $container->getDefinition(
            'inspector_manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.inspector'
        );

        foreach ($taggedServices as $id => $attributes) {

            $definition->addMethodCall(
                'add',
                array(new Reference($id), $id)
            );
        }
    }
}
