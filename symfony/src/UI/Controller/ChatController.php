<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Bus\QueryBusInterface;
use App\Application\Query\GetChatsQuery;
use App\Application\Repository\DTO\PaginatedResult;
use App\Infrastructure\Http\PaginationParamsFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ChatController extends AbstractController
{
    public function __construct(
        private readonly PaginationParamsFactory $paginationParamsFactory,
        private readonly QueryBusInterface $queryBus
    ) {}

    #[Route('/api/chats', name: 'api_chat_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $pagination = $this->paginationParamsFactory->fromRequest($request);

        /* @var PaginatedResult $result */
        $result = $this->queryBus->ask(new GetChatsQuery($pagination->getPage(), $pagination->getLimit()));

        return $this->json($result->toArray());
    }
}
