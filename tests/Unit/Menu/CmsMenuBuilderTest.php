<?php

declare(strict_types=1);

namespace Softspring\CmsSyliusBundle\Tests\Unit\Menu;

use Knp\Menu\MenuFactory;
use PHPUnit\Framework\TestCase;
use Softspring\CmsBundle\Config\CmsConfig;
use Softspring\CmsBundle\Manager\SiteManagerInterface;
use Softspring\CmsSyliusBundle\Menu\CmsMenuBuilder;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class CmsMenuBuilderTest extends TestCase
{
    public function testItBuildsCmsMenuEntries(): void
    {
        $factory = new MenuFactory();
        $menu = $factory->createItem('root');
        $menu->addChild('sales');
        $menu->addChild('catalog');
        $menu->addChild('customers');
        $menu->addChild('marketing');

        $builder = new CmsMenuBuilder($this->createCmsConfig([
            'page' => [
                'meta' => [
                    'sylius' => [
                        'icon' => 'file alternate',
                    ],
                ],
            ],
            'article' => [
                'meta' => [],
            ],
        ], [
            [
                'name' => 'SfsCmsSectionsPlugin',
                'class' => 'Softspring\CmsSectionsPlugin\SfsCmsSectionsPlugin',
            ],
        ]));

        $builder->buildMenu(new MenuBuilderEvent($factory, $menu));

        $cmsMenu = $menu->getChild('sfs_cms');

        self::assertNotNull($cmsMenu);
        self::assertSame('sfs_sylius_cms_plugin.ui.cms', $cmsMenu->getLabel());
        self::assertSame(['catalog', 'sfs_cms', 'sales', 'customers', 'marketing'], array_keys($menu->getChildren()));
        self::assertSame('sfs_cms_admin_content_page_list', $cmsMenu->getChild('page')->getExtra('routes')[0]['route']);
        self::assertSame('file alternate', $cmsMenu->getChild('page')->getLabelAttribute('icon'));
        self::assertSame('vertically file alternate', $cmsMenu->getChild('article')->getLabelAttribute('icon'));
        self::assertNotNull($cmsMenu->getChild('sections'));
        self::assertNotNull($cmsMenu->getChild('routes'));
        self::assertNotNull($cmsMenu->getChild('blocks'));
        self::assertNotNull($cmsMenu->getChild('menus'));
        self::assertNotNull($cmsMenu->getChild('medias'));
    }

    public function testItOmitsSectionsMenuWhenSectionsPluginIsNotRegistered(): void
    {
        $factory = new MenuFactory();
        $menu = $factory->createItem('root');
        $menu->addChild('catalog');
        $menu->addChild('sales');
        $menu->addChild('customers');
        $menu->addChild('marketing');

        (new CmsMenuBuilder($this->createCmsConfig()))->buildMenu(new MenuBuilderEvent($factory, $menu));

        self::assertNull($menu->getChild('sfs_cms')->getChild('sections'));
    }

    private function createCmsConfig(array $contents = [], array $registeredPlugins = []): CmsConfig
    {
        return new CmsConfig(
            [],
            [],
            $contents,
            [],
            [],
            [],
            $this->createStub(SiteManagerInterface::class),
            $registeredPlugins,
        );
    }
}
