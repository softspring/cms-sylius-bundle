<?php

declare(strict_types=1);

namespace Softspring\CmsSyliusBundle\Tests\Unit\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Softspring\CmsSyliusBundle\DependencyInjection\Compiler\AddTranslationsPathsPass;
use Sylius\Bundle\ThemeBundle\Translation\Provider\Resource\SymfonyTranslatorResourceProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AddTranslationsPathsPassTest extends TestCase
{
    public function testItDoesNothingWhenProviderIsMissing(): void
    {
        $container = new ContainerBuilder();

        (new AddTranslationsPathsPass())->process($container);

        self::assertFalse($container->hasDefinition(SymfonyTranslatorResourceProvider::class));
    }

    public function testItAddsCollectionTranslationFiles(): void
    {
        $projectDir = sys_get_temp_dir().'/cms-sylius-translations-'.bin2hex(random_bytes(4));
        $this->createFile($projectDir.'/collections/blog/translations/messages.en.yaml');
        $this->createFile($projectDir.'/collections/blog/blocks/header/translations/block.en.yaml');
        $this->createFile($projectDir.'/collections/blog/sites/main/translations/site.en.yaml');

        $definition = new Definition(null, [[]]);
        $container = new ContainerBuilder();
        $container->setParameter('kernel.project_dir', $projectDir);
        $container->setParameter('sfs_cms.collections', ['collections/blog']);
        $container->setDefinition(SymfonyTranslatorResourceProvider::class, $definition);

        (new AddTranslationsPathsPass())->process($container);

        $paths = $definition->getArgument(0);

        self::assertCount(3, $paths);
        self::assertContains($projectDir.'/collections/blog/translations/messages.en.yaml', $paths);
        self::assertContains($projectDir.'/collections/blog/blocks/header/translations/block.en.yaml', $paths);
        self::assertContains($projectDir.'/collections/blog/sites/main/translations/site.en.yaml', $paths);
    }

    private function createFile(string $path): void
    {
        $directory = \dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, 'test: true');
    }
}
