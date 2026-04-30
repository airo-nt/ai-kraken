<?php

declare(strict_types=1);

namespace App\Application\Repository\DTO;

/**
 * @template T
 */
final readonly class PaginatedResult
{
    /**
     * @param T[] $items
     */
    public function __construct(
        private array $items,
        private int $page,
        private int $limit,
        private int $total
    ) {}

    /**
     * @return T[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
