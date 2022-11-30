<?php

declare(strict_types=1);

namespace App\Locale\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class LocaleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // try to see if the locale has been set as a _language routing parameter
        if ($locale = $request->attributes->get('_language')) {
            $request->cookies->set('language', $locale);
        }

        $locale = $request->cookies->get('language');

        if ($locale) {
            $request->setLocale($locale);
        }
    }
}
