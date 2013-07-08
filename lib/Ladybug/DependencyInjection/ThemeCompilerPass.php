<?php

namespace Ladybug\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ThemeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('theme_resolver')) {
            return;
        }

        $definition = $container->getDefinition(
            'theme_resolver'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ladybug.theme'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'register',
                array(new Reference($id), $id)
            );
        }
    }
}