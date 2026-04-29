<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Ai;

use App\Application\Client\Ai\AiClientInterface;
use App\Application\Client\Ai\DTO\ChatCompletionResponse;
use App\Application\Client\Ai\Exception\AiClientException;
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

            $content = $response->toArray();
            $aiMessage = $content['choices'][0]['message']['content'] ?? null;
            if ($aiMessage === null) {
                throw new AiClientException('Null answer from github ai chat');
            }

            return new ChatCompletionResponse($aiMessage);
        } catch (ExceptionInterface $e) {
            throw new AiClientException(
                sprintf('Failed get answer from github ai chat: %s', $e->getMessage()),
                previous: $e
            );
        }
    }
}
