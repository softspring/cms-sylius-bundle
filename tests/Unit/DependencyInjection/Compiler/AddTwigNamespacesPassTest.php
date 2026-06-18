<?php

declare(strict_types=1);

namespace Softspring\CmsSyliusBundle\Tests\Unit\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Softspring\CmsSyliusBundle\DependencyInjection\Compiler\AddTwigNamespacesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AddTwigNamespacesPassTest extends TestCase
{
    public function testItPrependsTemplateNamespaces(): void
    {
        $definition = new Definition();
        $container = new ContainerBuilder();
        $container->setDefinition('twig.loader.native_filesystem', $definition);

        (new AddTwigNamespacesPass())->process($container);

        $methodCalls = $definition->getMethodCalls();
        $namespaces = array_map(fn (array $call): string => $call[1][1], $methodCalls);

        self::assertContains('SfsCms', $namespaces);
        self::assertContains('SfsMedia', $namespaces);
        self::assertContains('SfsCmsSectionsPlugin', $namespaces);
    }
}
