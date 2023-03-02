<?php

namespace Softspring\CmsSyliusBundle\Menu;

use Softspring\CmsBundle\Config\CmsConfig;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class CmsMenuBuilder
{
    protected CmsConfig $cmsConfig;

    public function __construct(CmsConfig $cmsConfig)
    {
        $this->cmsConfig = $cmsConfig;
    }

    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $cmsRootMenuItem = $menu
            ->addChild('sfs_cms')
            ->setLabel('sfs_sylius_cms_plugin.ui.cms')
        ;

        $order = ['catalog', 'sfs_cms', 'sales', 'customers', 'marketing'];
        $order = array_merge($order, array_diff(array_keys($menu->getChildren()), $order));
        $menu->reorderChildren($order);

        foreach ($this->cmsConfig->getContents() as $contentId => $contentConfig) {
            $cmsRootMenuItem
                ->addChild($contentId, [
                    'route' => "sfs_cms_admin_content_{$contentId}_list",
                ])
                ->setLabel("sfs_sylius_cms_plugin.ui.contents.{$contentId}")
                ->setLabelAttribute( 'icon', $contentConfig['meta']['sylius']['icon'] ?? 'vertically file alternate')
            ;
        }

        $cmsRootMenuItem
            ->addChild('routes', [
                'route' => 'sfs_cms_admin_routes_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.routes')
            ->setLabelAttribute('icon', 'vertically linkify')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'sfs_cms_admin_blocks_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.blocks')
            ->setLabelAttribute('icon', 'th')
        ;

        $cmsRootMenuItem
            ->addChild('menus', [
                'route' => 'sfs_cms_admin_menus_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.menus')
            ->setLabelAttribute('icon', 'bars')
        ;

        $cmsRootMenuItem
            ->addChild('medias', [
                'route' => 'sfs_media_admin_medias_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.medias')
            ->setLabelAttribute('icon', 'image outline')
        ;
    }
}
