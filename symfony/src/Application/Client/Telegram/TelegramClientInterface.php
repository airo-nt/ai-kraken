<?php

declare(strict_types=1);

namespace App\Application\Client\Telegram;

use App\Application\Client\Telegram\DTO\BotUpdatesResponse;
use App\Application\Client\Telegram\Exception\TelegramClientException;

interface TelegramClientInterface
{
    /**
     * @throws TelegramClientException
     */
    public function getBotUpdates(int $lastUpdateId): BotUpdatesResponse;
}
