<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class FormatCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('format_resolver')) {
            return;
        }

        $definition = $container->getDefinition(
            'format_resolver'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.format'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'register',
                array(new Reference($id), $id)
            );
        }
    }
}
