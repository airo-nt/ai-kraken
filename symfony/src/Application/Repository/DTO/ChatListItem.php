<?php

declare(strict_types=1);

namespace App\Application\Repository\DTO;

use App\Application\Presentation\ArrayableInterface;

final readonly class ChatListItem implements ArrayableInterface
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

    public function toArray(): array
    {
        return [
            'chat_id' => $this->getChatId(),
            'user_name' => $this->getUserName(),
            'created_at' => $this->getCreatedAt()
        ];
    }
}
