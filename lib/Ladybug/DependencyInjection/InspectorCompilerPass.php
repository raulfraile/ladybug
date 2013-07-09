<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class InspectorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('inspector_factory')) {
            return;
        }

        $definition = $container->getDefinition(
            'inspector_factory'
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