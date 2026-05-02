<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $error = $statusCode = null;
        if ($exception instanceof HandlerFailedException) {
            $error = 'Something went wrong, please try later';
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif ($exception instanceof NotFoundHttpException) {
            $error = 'Endpoint not found';
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        if ($error && $statusCode) {
            $event->setResponse(new JsonResponse(['error' => $error], $statusCode));
        }
    }
}
