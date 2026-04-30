<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Application\Repository\ChatReadRepositoryInterface;
use App\Application\Repository\DTO\PaginatedResult;

final class GetChatsQueryHandler
{
    public function __construct(
        private readonly ChatReadRepositoryInterface $repository
    ) {}

    public function __invoke(GetChatsQuery $query): PaginatedResult
    {
        return $this->repository->findPaginated(
            $query->getPage(),
            $query->getLimit()
        );
    }
}
