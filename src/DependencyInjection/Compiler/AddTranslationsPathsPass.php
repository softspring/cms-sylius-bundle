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
            // add modules translations if exists
            $modulesPath = $container->getParameter('kernel.project_dir') . '/' . trim($collectionPath, '/') . '/modules';
            if (!is_dir($modulesPath)) {
                continue;
            }

            foreach ((new Finder())->directories()->in("$modulesPath/*")->name('translations') as $transDirectory) {
                foreach ((new Finder())->in($transDirectory->getRealPath())->files() as $file) {
                    $fileNameParts = explode('.', $file->getBasename());
                    $format = array_pop($fileNameParts);
                    $locale = array_pop($fileNameParts);
                    $domain = implode('.', $fileNameParts);
                    $collection[] = $file->getRealPath();
                }
            }
        }

        $definition->replaceArgument(0, $collection);
    }
}
