<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Telegram;

use App\Application\Client\Telegram\DTO\BotUpdateResponse;
use App\Application\Client\Telegram\DTO\BotUpdatesResponse;
use App\Application\Client\Telegram\Exception\TelegramClientException;
use App\Application\Client\Telegram\TelegramClientInterface;
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

            $content = $response->toArray();
            $isSuccessResponse = ($content['ok'] ?? false) && isset($content['result']);
            if (!$isSuccessResponse) {
                throw new TelegramClientException(
                    'Failed to fetch updates from bot telegram: invalid content'
                );
            }

            $result = [];
            foreach ($content['result'] as $item) {
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
}
