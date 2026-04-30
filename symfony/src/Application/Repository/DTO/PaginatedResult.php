<?php

declare(strict_types=1);

namespace App\Application\Repository\DTO;

use App\Application\Presentation\ArrayableInterface;

/**
 * @template T of ArrayableInterface
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

    public function toArray(): array
    {
        return [
            'items' => array_map(fn(ArrayableInterface $item) => $item->toArray(), $this->getItems()),
            'page' => $this->getPage(),
            'limit' => $this->getLimit(),
            'total' => $this->getTotal()
        ];
    }
}
