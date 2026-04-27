<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Model\ValueObject\ChatId;
use DateTimeImmutable;

final class Chat
{
    private ChatId $chatId;

    private DateTimeImmutable $createdAt;

    public function __construct(
        ChatId             $chatId,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->chatId = $chatId;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    public function getChatId(): ChatId
    {
        return $this->chatId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
