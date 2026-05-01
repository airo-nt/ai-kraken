<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Infrastructure\Http\DTO\Pagination;
use Symfony\Component\HttpFoundation\Request;

final class PaginationParamsFactory
{
    private const int DEFAULT_PAGE = 1;
    private const int DEFAULT_LIMIT = 20;
    private const int MAX_LIMIT = 100;

    public function fromRequest(Request $request): Pagination
    {
        $page = (int) $request->query->get('page', self::DEFAULT_PAGE);
        $limit = (int) $request->query->get('limit', self::DEFAULT_LIMIT);

        $page = $page < 1 ? self::DEFAULT_PAGE : $page;
        $limit = $limit < 1 ? self::DEFAULT_LIMIT : min($limit, self::MAX_LIMIT);

        return new Pagination($page, $limit);
    }
}
