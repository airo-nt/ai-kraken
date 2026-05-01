<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Telegram\DTO;

final readonly class BotTelegramResponseBody
{
    public function __construct(
        private array $data
    ) {}

    public function isOk(): bool
    {
        return $this->data['ok'] ?? false;
    }

    public function getResult(): ?array
    {
        return $this->data['result'] ?? null;
    }

    public function getErrorCode(): ?int
    {
        return $this->data['error_code'] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }
}
