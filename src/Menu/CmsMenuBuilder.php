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
    }
}
