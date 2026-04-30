<?php

declare(strict_types=1);

namespace App\Application\Repository\DTO;

final readonly class ChatItemDTO
{
    public function __construct(
        private int $chatId,
        private ?string $userName,
        private string $createdAt
    ) {}

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
