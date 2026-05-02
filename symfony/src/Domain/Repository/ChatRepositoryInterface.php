<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;
use App\Domain\Repository\Exception\ValidationException;

interface ChatRepositoryInterface
{
    public function isExistsByChatId(ChatId $chatId): bool;

    /**
     * @throws ValidationException
     */
    public function create(Chat $chat): void;
}
