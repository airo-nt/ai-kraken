<?php

declare(strict_types=1);

namespace App\Application\Client\Ai\DTO;

final readonly class ChatCompletionResponse
{
    public function __construct(private string $aiMessage) {}

    public function getAiMessage(): string
    {
        return $this->aiMessage;
    }
}
