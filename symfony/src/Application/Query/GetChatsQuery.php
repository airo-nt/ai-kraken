<?php

declare(strict_types=1);

namespace App\Application\Query;

final readonly class GetChatsQuery
{
    public function __construct(
        private int $page,
        private int $limit
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
