<?php

declare(strict_types=1);

namespace App\Application\Command;

final readonly class ProcessBotUpdateCommand
{
    public function __construct(
        private int $chatId,
        private string $text,
        private ?string $userName
    ) {}

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
