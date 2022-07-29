<?php

namespace Softspring\CmsSyliusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SfsCmsSyliusExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config/services'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
//        $doctrineConfig = [];
//
//        // add a default config to force load target_entities, will be overwritten by ResolveDoctrineTargetEntityPass
//        $doctrineConfig['orm']['resolve_target_entities'][BlockInterface::class] = 'App\Entity\Block';
//        $doctrineConfig['orm']['resolve_target_entities'][ContentInterface::class] = 'App\Entity\Content';
//
//        // disable auto-mapping for this bundle to prevent mapping errors
//        $doctrineConfig['orm']['mappings']['SfsCmsBundle'] = [
//            'is_bundle' => true,
//            'mapping' => true,
//        ];
//
//        $container->prependExtensionConfig('doctrine', $doctrineConfig);

//        $container->prependExtensionConfig('twig', [
//            'paths' => [
//                '%kernel.project_dir%/cms'=> 'cms',
//                '%kernel.project_dir%/cms/modules'=> 'module', // use @module/html/render.html.twig
//                '%kernel.project_dir%/vendor/softspring/cms-module-collection/modules'=> 'module', // use @module/html/render.html.twig
//                '%kernel.project_dir%/cms/contents'=> 'content', // use @content/article/render.html.twig
//                '%kernel.project_dir%/cms/blocks'=> 'block', // use @block/header/render.html.twig
//                '%kernel.project_dir%/cms/layouts'=> 'layout', // use @layout/default/render.html.twig
//                '%kernel.project_dir%/cms/menus'=> 'menu', // use @menu/main/render.html.twig
//            ],
//        ]);
    }
}
