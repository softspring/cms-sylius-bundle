<?php

declare(strict_types=1);

namespace Softspring\CmsSyliusBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Softspring\CmsSyliusBundle\DependencyInjection\Compiler\AddTranslationsPathsPass;
use Softspring\CmsSyliusBundle\DependencyInjection\Compiler\AddTwigNamespacesPass;
use Softspring\CmsSyliusBundle\SfsCmsSyliusBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SfsCmsSyliusBundleTest extends TestCase
{
    public function testItReturnsPackagePath(): void
    {
        self::assertSame(\dirname(__DIR__, 2), (new SfsCmsSyliusBundle())->getPath());
    }

    public function testItRegistersCompilerPasses(): void
    {
        $container = new ContainerBuilder();

        (new SfsCmsSyliusBundle())->build($container);

        $passes = $container->getCompilerPassConfig()->getBeforeOptimizationPasses();

        self::assertNotEmpty(array_filter($passes, fn (object $pass): bool => $pass instanceof AddTwigNamespacesPass));
        self::assertNotEmpty(array_filter($passes, fn (object $pass): bool => $pass instanceof AddTranslationsPathsPass));
    }
}
