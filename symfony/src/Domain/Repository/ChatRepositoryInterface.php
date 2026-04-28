<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;

interface ChatRepositoryInterface
{
    public function findByChatId(ChatId $chatId): ?Chat;

    public function save(Chat $chat): void;
}
