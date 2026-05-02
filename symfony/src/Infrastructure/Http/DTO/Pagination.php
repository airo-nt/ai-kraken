<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\DTO;

final readonly class Pagination
{
    public function __construct(
        private int $page,
        private int $limit,
    ) {}

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
