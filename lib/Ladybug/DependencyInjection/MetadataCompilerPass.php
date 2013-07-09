<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class MetadataCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('metadata_resolver')) {
            return;
        }

        $definition = $container->getDefinition(
            'metadata_resolver'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.metadata'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'add',
                array(new Reference($id))
            );
        }
    }
}