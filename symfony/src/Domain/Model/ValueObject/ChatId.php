<?php

declare(strict_types=1);

namespace App\Domain\Model\ValueObject;

final readonly class ChatId
{
    public function __construct(private int $value) {}

    public function getValue(): int
    {
        return $this->value;
    }
}
