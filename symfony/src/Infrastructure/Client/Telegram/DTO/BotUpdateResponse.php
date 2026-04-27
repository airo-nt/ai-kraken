<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Telegram\DTO;

final readonly class BotUpdateResponse
{
    public function __construct(
        private int $updateId,
        private int $chatId,
        private string $text
    ) {}

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
