<?php

namespace Softspring\CmsSyliusBundle\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class CmsMenuBuilder
{
    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $cmsRootMenuItem = $menu
            ->addChild('sfs_cms')
            ->setLabel('sfs_sylius_cms_plugin.ui.cms')
        ;

        $cmsRootMenuItem
            ->addChild('pages', [
                'route' => 'sfs_cms_admin_content_page_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.pages')
            ->setLabelAttribute('icon', 'page')
        ;

        $cmsRootMenuItem
            ->addChild('routes', [
                'route' => 'sfs_cms_admin_routes_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.routes')
            ->setLabelAttribute('icon', 'route')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'sfs_cms_admin_blocks_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.blocks')
            ->setLabelAttribute('icon', 'block')
        ;

        $cmsRootMenuItem
            ->addChild('menus', [
                'route' => 'sfs_cms_admin_menus_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.menus')
            ->setLabelAttribute('icon', 'menu')
        ;

        $cmsRootMenuItem
            ->addChild('medias', [
                'route' => 'sfs_media_admin_medias_list',
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.medias')
            ->setLabelAttribute('icon', 'media')
        ;
    }
}
