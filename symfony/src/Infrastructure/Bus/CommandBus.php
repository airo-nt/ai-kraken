<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus;

use App\Application\Bus\CommandBusInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly MessageBusInterface $bus
    ) {}

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(object $command): void
    {
        $this->bus->dispatch($command);
    }
}
