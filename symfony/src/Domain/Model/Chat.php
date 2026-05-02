<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Model\ValueObject\ChatId;
use DateTimeImmutable;

final class Chat
{
    private ChatId $chatId;

    private ?string $userName;

    private DateTimeImmutable $createdAt;

    public function __construct(
        ChatId             $chatId,
        ?string            $userName,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->chatId = $chatId;
        $this->userName = $userName;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    public function getChatId(): ChatId
    {
        return $this->chatId;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
