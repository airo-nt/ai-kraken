<?php

declare(strict_types=1);

namespace App\Application\Client\Telegram\DTO;

final readonly class BotUpdateResponse
{
    public function __construct(
        private int $updateId,
        private int $chatId,
        private string $text,
        private ?string $userName
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

    public function getUserName(): ?string
    {
        return $this->userName;
    }
}
