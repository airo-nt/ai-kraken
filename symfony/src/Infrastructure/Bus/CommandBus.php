<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus;

use App\Application\Bus\CommandBusInterface;
use App\Application\Bus\Exception\CommandDispatchException;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly MessageBusInterface $bus
    ) {}

    public function dispatch(object $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (ExceptionInterface $e) {
            throw CommandDispatchException::fromPrevious($e);
        }
    }
}
