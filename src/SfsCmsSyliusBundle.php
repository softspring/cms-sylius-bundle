<?php

namespace Softspring\CmsSyliusBundle;

use Softspring\CmsSyliusBundle\DependencyInjection\Compiler\AddTwigNamespacesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SfsCmsSyliusBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddTwigNamespacesPass());
    }
}
