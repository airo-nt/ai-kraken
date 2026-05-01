<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

#[AsEventListener(event: KernelEvents::EXCEPTION)]
final class ApiExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        if (!str_starts_with($request->getPathInfo(), '/api/')) {
            return;
        }

        $exception = $event->getThrowable();
        if ($exception instanceof HandlerFailedException) {
            $response = new JsonResponse(['error' => 'Something went wrong, please try later'], 500);
            $event->setResponse($response);
        }
    }
}
