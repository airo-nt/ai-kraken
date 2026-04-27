<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Telegram\DTO;

final readonly class BotUpdatesResponse implements \IteratorAggregate
{
    public function __construct(private array $botUpdates) {}

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->botUpdates);
    }
}
