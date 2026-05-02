<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Client\Ai\AiClientInterface;
use App\Application\Client\Ai\Exception\AiClientException;
use App\Application\Client\Telegram\TelegramClientInterface;
use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;
use App\Domain\Repository\ChatRepositoryInterface;
use App\Domain\Repository\Exception\ValidationException;

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
        $chatIdValue = $chatId->getValue();
        $isExistsChat = $this->chatRepository->isExistsByChatId($chatId);
        if (!$isExistsChat) {
            $chat = new Chat($chatId, $command->getUserName());
            try {
                $this->chatRepository->create($chat);
            } catch (ValidationException) {
                $this->telegramClient->sendMessage($chatIdValue, 'Something went wrong. Please try later.');
                return;
            }
        }

        if ($command->getText() === '/start') {
            $this->telegramClient->sendMessage($chatIdValue, "Hello, I'm AiKraken. Ask your questions.");
            return;
        }

        $this->telegramClient->sendMessage($chatIdValue, 'Please wait. Generating answer...');
        try {
            $response = $this->aiClient->chatCompletion($command->getText());
        } catch (AiClientException) {
            $this->telegramClient->sendMessage($chatIdValue, 'Something went wrong. Please try later.');
            return;
        }
        $this->telegramClient->sendMessage($chatIdValue, $response->getAiMessage());
    }
}
