<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $subMenu = $menu
            ->addChild('cms')
            ->setLabel('CMS')
        ;

        $subMenu
            ->addChild('pages', ['route' => 'app_dummy'])
            ->setLabel('Pages')
            ->setLabelAttribute('icon', 'file alternate outline')
        ;
    }
}
