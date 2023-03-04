<?php

namespace Softspring\CmsSyliusBundle\DependencyInjection\Compiler;

use Sylius\Bundle\ThemeBundle\Translation\Provider\Resource\SymfonyTranslatorResourceProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

class AddTranslationsPathsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(SymfonyTranslatorResourceProvider::class)) {
            return;
        }

        $definition = $container->getDefinition(SymfonyTranslatorResourceProvider::class);
        $collection = $definition->getArgument(0);

        foreach ($container->getParameter('sfs_cms.collections') as $collectionPath) {
            foreach (['module', 'block', 'content', 'layout', 'menu', 'site'] as $item) {
                $path = $container->getParameter('kernel.project_dir').'/'.trim($collectionPath, '/')."/{$item}s";
                if (is_dir($path)) {
                    foreach ((new Finder())->directories()->in("$path/*")->name('translations') as $transDirectory) {
                        foreach ((new Finder())->in($transDirectory->getRealPath())->files() as $file) {
                            $collection[] = $file->getRealPath();
                        }
                    }
                }
            }
        }

        $definition->replaceArgument(0, $collection);
    }
}
