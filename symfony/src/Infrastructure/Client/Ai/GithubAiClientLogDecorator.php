<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Ai;

use App\Application\Client\Ai\AiClientInterface;
use App\Application\Client\Ai\DTO\ChatCompletionResponse;
use App\Application\Client\Ai\Exception\AiClientException;
use Psr\Log\LoggerInterface;

final class GithubAiClientLogDecorator implements AiClientInterface
{
    public function __construct(
        private readonly AiClientInterface $inner,
        private readonly LoggerInterface $logger
    ) {
    }

    public function chatCompletion(string $text): ChatCompletionResponse
    {
        try {
            return $this->inner->chatCompletion($text);
        } catch (AiClientException $e) {
            $this->logger->error('GithubAi API call failed', [
                'text' => $text,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}
