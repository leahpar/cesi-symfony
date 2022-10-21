<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class NotFoundSubscriber implements EventSubscriberInterface
{

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse(
                new RedirectResponse('https://google.fr/RTFM')
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            //KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
