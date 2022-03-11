<?php

namespace App\Event\Listener\Admin\Cms;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use App\Entity\Cms\Page;
use Symfony\Component\String\Slugger\AsciiSlugger;

class PageUpdateListener
{
    public function __invoke(ResourceControllerEvent $event)
    {
        /** @var Page */
        $page = $event->getSubject();

        if (!$page instanceof Page) {
            return new \LogicException('subject should by a Page object');
        }

        $page->setSlug(strtolower((new AsciiSlugger())->slug($page->getTitle())));
    }
}