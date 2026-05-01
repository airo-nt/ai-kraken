<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Ai;

use App\Application\Client\Ai\AiClientInterface;
use App\Application\Client\Ai\DTO\ChatCompletionResponse;
use App\Application\Client\Ai\Exception\AiClientException;
use App\Infrastructure\Client\Ai\DTO\GithubAiResponseBody;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GithubAiClient implements AiClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $githubAiHttpClient
    ) {
    }

    public function chatCompletion(string $text): ChatCompletionResponse
    {
        try {
            $messages[] = [
                'role' => 'user',
                'content' => $text
            ];
            $response = $this->githubAiHttpClient->request(
                'POST',
                '/inference/chat/completions',
                [
                    'json' => [
                        'model' => 'openai/gpt-4.1',
                        'messages' => $messages
                    ]
                ]
            );

            $body = new GithubAiResponseBody($response->toArray(false));
            $responseCode = $response->getStatusCode();
            if ($body->getMessage() === null) {
                throw new AiClientException(
                    sprintf('Failed get answer from github ai chat (%d): %s',
                        $responseCode,
                        $body->getErrorMessage() ?? 'Unknown error'
                    )
                );
            }

            return new ChatCompletionResponse($body->getMessage());
        } catch (ExceptionInterface $e) {
            throw new AiClientException(
                sprintf('Failed get answer from github ai chat: %s', $e->getMessage()),
                previous: $e
            );
        }
    }
}
