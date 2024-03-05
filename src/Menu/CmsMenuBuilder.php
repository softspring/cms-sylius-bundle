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
                    'extras' => ['routes' => [
                        ['route' => "sfs_cms_admin_content_{$contentId}_list"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_create"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_import"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_details"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_update"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_duplicate"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_routes"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_delete"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_unpublish"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_preview"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_content"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_content_from_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_versions"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_keep_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_unkeep_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_recompile_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_version_preview"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_publish_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_export_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_version_info"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_import_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_cleanup_versions"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_seo"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_seo_version"],
                        ['route' => "sfs_cms_admin_content_{$contentId}_delete_version"],
                    ]],
                ])
                ->setLabel("sfs_sylius_cms_plugin.ui.contents.{$contentId}")
                ->setLabelAttribute('icon', $contentConfig['meta']['sylius']['icon'] ?? 'vertically file alternate')
            ;
        }

        $cmsRootMenuItem
            ->addChild('routes', [
                'route' => 'sfs_cms_admin_routes_list',
                'extras' => ['routes' => [
                    ['route' => 'sfs_cms_admin_routes_list'],
                    ['route' => 'sfs_cms_admin_routes_create'],
                    ['route' => 'sfs_cms_admin_routes_update'],
                    ['route' => 'sfs_cms_admin_routes_delete'],
                    ['route' => 'sfs_cms_admin_routes_read'],
                ]],
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.routes')
            ->setLabelAttribute('icon', 'vertically linkify')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'sfs_cms_admin_blocks_list',
                'extras' => ['routes' => [
                    ['route' => 'sfs_cms_admin_blocks_list'],
                    ['route' => 'sfs_cms_admin_blocks_create'],
                    ['route' => 'sfs_cms_admin_blocks_update'],
                    ['route' => 'sfs_cms_admin_blocks_delete'],
                    ['route' => 'sfs_cms_admin_blocks_read'],
                ]],
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.blocks')
            ->setLabelAttribute('icon', 'th')
        ;

        $cmsRootMenuItem
            ->addChild('menus', [
                'route' => 'sfs_cms_admin_menus_list',
                'extras' => ['routes' => [
                    ['route' => 'sfs_cms_admin_menus_list'],
                    ['route' => 'sfs_cms_admin_menus_create'],
                    ['route' => 'sfs_cms_admin_menus_update'],
                    ['route' => 'sfs_cms_admin_menus_delete'],
                    ['route' => 'sfs_cms_admin_menus_read'],
                ]],
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.menus')
            ->setLabelAttribute('icon', 'bars')
        ;

        $cmsRootMenuItem
            ->addChild('medias', [
                'route' => 'sfs_media_admin_medias_list',
                'extras' => ['routes' => [
                    ['route' => 'sfs_media_admin_medias_list'],
                    ['route' => 'sfs_media_admin_medias_create'],
                    ['route' => 'sfs_media_admin_medias_update'],
                    ['route' => 'sfs_media_admin_medias_delete'],
                    ['route' => 'sfs_media_admin_medias_read'],
                ]],
            ])
            ->setLabel('sfs_sylius_cms_plugin.ui.medias')
            ->setLabelAttribute('icon', 'image outline')
        ;
    }
}
