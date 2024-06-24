<?php

namespace App\EventSubscriber;

use App\Repository\GeneralSettingsRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class GeneralSettingsSubscriber implements EventSubscriberInterface
{


    public function __construct(
        private GeneralSettingsRepository $generalSettingsRepository,
        private Environment $twig
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'injectGeneralSettings',
        ];
    }

    public function injectGeneralSettings(RequestEvent $event)
    {
        $siteSettings = $this->generalSettingsRepository->find(1);
        $this->twig->addGlobal('siteSettings', $siteSettings);
    }
}
