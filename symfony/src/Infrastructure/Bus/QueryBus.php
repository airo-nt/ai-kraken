<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus;

use App\Application\Bus\QueryBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus
    ) {}

    public function ask(object $query): mixed
    {
        return $this->handle($query);
    }
}
