<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TypeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('type_factory')) {
            return;
        }

        $definition = $container->getDefinition(
            'type_factory'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.type'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'add',
                array(new Reference($id), $id)
            );
        }

        // extended types

        $definition = $container->getDefinition(
            'type_extended_factory'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.type.extended'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'add',
                array(new Reference($id), $id)
            );
        }
    }
}
