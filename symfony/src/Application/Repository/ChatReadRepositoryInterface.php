<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Repository\DTO\ChatItemDTO;
use App\Application\Repository\DTO\PaginatedResult;
use App\Application\Repository\Exception\ReadRepositoryException;

interface ChatReadRepositoryInterface
{
    /**
     * @return PaginatedResult<ChatItemDTO>
     * @throws ReadRepositoryException
     */
    public function findPaginated(int $page, int $limit): PaginatedResult;
}
