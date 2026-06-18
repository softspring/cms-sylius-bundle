<?php

declare(strict_types=1);

namespace Softspring\CmsSyliusBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Softspring\CmsSyliusBundle\DependencyInjection\SfsCmsSyliusExtension;
use Softspring\CmsSyliusBundle\Menu\CmsMenuBuilder;
use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SfsCmsSyliusExtensionTest extends TestCase
{
    public function testItLoadsServices(): void
    {
        $container = new ContainerBuilder();

        (new SfsCmsSyliusExtension())->load([], $container);

        self::assertTrue($container->hasDefinition(CmsMenuBuilder::class));
    }

    public function testItPrependsTwigAndAssetMapperConfiguration(): void
    {
        $container = new ContainerBuilder();

        (new SfsCmsSyliusExtension())->prepend($container);

        $twigConfig = $container->getExtensionConfig('twig')[0];
        self::assertArrayHasKey('sfs_cms_sylius_bundle', $twigConfig['globals']);
        self::assertArrayHasKey('version', $twigConfig['globals']['sfs_cms_sylius_bundle']);

        if (interface_exists(AssetMapperInterface::class)) {
            $frameworkConfig = $container->getExtensionConfig('framework')[0];
            self::assertArrayHasKey('asset_mapper', $frameworkConfig);
            self::assertSame('@softspring/cms-sylius-bundle', array_values($frameworkConfig['asset_mapper']['paths'])[0]);
        } else {
            self::assertSame([], $container->getExtensionConfig('framework'));
        }
    }
}
