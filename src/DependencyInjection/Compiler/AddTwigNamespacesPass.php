<?php

namespace Softspring\CmsSyliusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AddTwigNamespacesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $twigFilesystemLoaderDefinition = $container->getDefinition('twig.loader.native_filesystem');

        // register project namespaces before collections to allow overriding
        $twigFilesystemLoaderDefinition->addMethodCall('prependPath', ['%kernel.project_dir%/vendor/softspring/cms-sylius-bundle/theme/', 'SfsCms']);
    }
}
