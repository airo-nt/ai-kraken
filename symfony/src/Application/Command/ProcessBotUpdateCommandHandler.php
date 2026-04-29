<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Client\Telegram\TelegramClientInterface;
use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;
use App\Domain\Repository\ChatRepositoryInterface;

final class ProcessBotUpdateCommandHandler
{
    public function __construct(
        private readonly ChatRepositoryInterface $chatRepository,
        private readonly TelegramClientInterface $telegramClient
    ) {}

    public function __invoke(ProcessBotUpdateCommand $command): void
    {
        $chatId = new ChatId($command->getChatId());
        $isExistsChat = $this->chatRepository->isExistsByChatId($chatId);
        if (!$isExistsChat) {
            $chat = new Chat($chatId, $command->getUserName());
            $this->chatRepository->create($chat);
        }

        if ($command->getText() === '/start') {
            $this->telegramClient->sendMessage($command->getChatId(), 'Hello, Im AiKraken. Ask your questions.');
            return;
        }
    }
}
