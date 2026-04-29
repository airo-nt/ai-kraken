<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Telegram;

use App\Application\Client\Telegram\DTO\BotUpdatesResponse;
use App\Application\Client\Telegram\Exception\TelegramClientException;
use App\Application\Client\Telegram\TelegramClientInterface;
use Psr\Log\LoggerInterface;

final class TelegramClientLogDecorator implements TelegramClientInterface
{
    public function __construct(
        private readonly TelegramClientInterface $telegramClient,
        private readonly LoggerInterface $logger
    ) {}

    public function getBotUpdates(int $lastUpdateId): BotUpdatesResponse
    {
        try {
            return $this->telegramClient->getBotUpdates($lastUpdateId);
        } catch (TelegramClientException $e) {
            $this->logger->error('Telegram API call failed', [
                'last_update_id' => $lastUpdateId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function sendMessage(int $chatId, string $text): void
    {
        try {
            $this->telegramClient->sendMessage($chatId, $text);
        } catch (TelegramClientException $e) {
            $this->logger->error('Telegram API call failed', [
                'chat_id' => $chatId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}
