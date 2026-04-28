<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;
use App\Domain\Repository\ChatRepositoryInterface;

final class ProcessBotUpdateCommandHandler
{
    public function __construct(
        private readonly ChatRepositoryInterface $chatRepository
    ) {}

    public function __invoke(ProcessBotUpdateCommand $command): void
    {
        $chatId = new ChatId($command->getChatId());
        $chat = $this->chatRepository->findByChatId($chatId);
        if (!$chat) {
            $chat = new Chat($chatId, $command->getUserName());
            $this->chatRepository->save($chat);
        }
    }
}
