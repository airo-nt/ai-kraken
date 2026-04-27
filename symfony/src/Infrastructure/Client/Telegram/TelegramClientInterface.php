<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Telegram;

use App\Infrastructure\Client\Telegram\DTO\BotUpdatesResponse;
use App\Infrastructure\Client\Telegram\Exception\TelegramClientException;

interface TelegramClientInterface
{
    /**
     * @throws TelegramClientException
     */
    public function getBotUpdates(int $lastUpdateId): BotUpdatesResponse;
}
