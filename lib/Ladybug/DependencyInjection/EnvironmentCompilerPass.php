<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class EnvironmentCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('environment_resolver')) {
            return;
        }

        $definition = $container->getDefinition(
            'environment_resolver'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.environment'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'register',
                array(new Reference($id))
            );
        }
    }
}