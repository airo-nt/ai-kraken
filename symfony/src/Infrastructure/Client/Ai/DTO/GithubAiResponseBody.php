<?php

declare(strict_types=1);

namespace App\Infrastructure\Client\Ai\DTO;

final readonly class GithubAiResponseBody
{
    public function __construct(
        private array $data
    ) {}

    public function getMessage(): ?string
    {
        return $this->data['choices'][0]['message']['content'] ?? null;
    }

    public function getErrorMessage(): ?string
    {
        return $this->data['error']['message'] ?? null;
    }
}
