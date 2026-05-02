<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Telegram;

use App\Application\Client\Telegram\DTO\BotUpdateResponse;
use App\Application\Client\Telegram\DTO\BotUpdatesResponse;
use App\Application\Client\Telegram\Exception\TelegramClientException;
use App\Application\Client\Telegram\TelegramClientInterface;
use App\Infrastructure\Client\Telegram\DTO\BotTelegramResponseBody;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class TelegramClient implements TelegramClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $botBaseUri,
        private readonly string $botToken
    ) {
    }

    public function getBotUpdates(int $lastUpdateId): BotUpdatesResponse
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->botBaseUri . $this->botToken . '/getUpdates',
                [
                    'query' => [
                        'offset'  => $lastUpdateId + 1,
                        'timeout' => 10
                    ]
                ]
            );

            $body = new BotTelegramResponseBody($response->toArray(false));
            if (!$body->isOk()) {
                throw new TelegramClientException(
                    sprintf(
                        'Failed to fetch updates from bot telegram (%d): %s',
                        $body->getErrorCode() ?? 0,
                        $body->getDescription() ?? 'Unknown error'
                    )
                );
            }

            $result = [];
            foreach ($body->getResult() as $item) {
                $message = $item['message'];
                $result[] = new BotUpdateResponse(
                    $item['update_id'],
                    $message['chat']['id'],
                    $message['text'],
                    $message['chat']['username'] ?? null
                );
            }

            return new BotUpdatesResponse($result);
        } catch (ExceptionInterface $e) {
            throw new TelegramClientException(
                sprintf('Failed to fetch updates from bot telegram: %s', $e->getMessage()),
                previous: $e
            );
        }
    }

    public function sendMessage(int $chatId, string $text): void
    {
        try {
            $response = $this->httpClient->request('POST', $this->botBaseUri . $this->botToken . '/sendMessage', [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $text
                ]
            ]);

            $body = new BotTelegramResponseBody($response->toArray(false));
            if (!$body->isOk()) {
                throw new TelegramClientException(
                    sprintf(
                        'Failed to send message by bot telegram (%d): %s',
                        $body->getErrorCode() ?? 0,
                        $body->getDescription() ?? 'Unknown error'
                    )
                );
            }
        } catch (ExceptionInterface $e) {
            throw new TelegramClientException(
                sprintf('Failed to send message by bot telegram: %s', $e->getMessage()),
                previous: $e
            );
        }
    }
}
