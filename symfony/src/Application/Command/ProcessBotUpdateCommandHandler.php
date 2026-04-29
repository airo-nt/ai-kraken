<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Client\Ai\AiClientInterface;
use App\Application\Client\Telegram\TelegramClientInterface;
use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;
use App\Domain\Repository\ChatRepositoryInterface;

final class ProcessBotUpdateCommandHandler
{
    public function __construct(
        private readonly ChatRepositoryInterface $chatRepository,
        private readonly TelegramClientInterface $telegramClient,
        private readonly AiClientInterface $aiClient
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
            $this->telegramClient->sendMessage($command->getChatId(), "Hello, I'm AiKraken. Ask your questions.");
            return;
        }

        $this->telegramClient->sendMessage($command->getChatId(), "Please wait, I'm generating a response for you...");
        $response = $this->aiClient->chatCompletion($command->getText());
        $this->telegramClient->sendMessage($command->getChatId(), $response->getAiMessage());
    }
}
