<?php

declare(strict_types=1);

namespace App\Application\Client\Ai;

use App\Application\Client\Ai\DTO\ChatCompletionResponse;
use App\Application\Client\Ai\Exception\AiClientException;

interface AiClientInterface
{
    /**
     * @throws AiClientException
     */
    public function chatCompletion(string $text): ChatCompletionResponse;
}
