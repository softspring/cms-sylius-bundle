<?php

namespace Softspring\CmsSyliusBundle\DependencyInjection;

use Composer\InstalledVersions;
use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SfsCmsSyliusExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config/services'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $assetsPath = \dirname(__DIR__, 2).'/assets';
        $assetsDistPath = $assetsPath.'/dist';
        $version = InstalledVersions::getVersion('softspring/cms-sylius-bundle');
        if (str_ends_with($version, '-dev')) {
            $version = InstalledVersions::getPrettyVersion('softspring/cms-sylius-bundle');
        }
        $container->prependExtensionConfig('twig', [
            'globals' => [
                'sfs_cms_sylius_bundle' => [
                    'version' => $version,
                    'version_branch' => str_ends_with($version, '-dev') ? str_replace('.x-dev', '', $version) : false,
                ],
            ],
        ]);

        if (interface_exists(AssetMapperInterface::class)) {
            $container->prependExtensionConfig('framework', [
                'asset_mapper' => [
                    'paths' => [
                        $assetsDistPath => '@softspring/cms-sylius-bundle',
                    ],
                ],
            ]);
        }
    }
}
