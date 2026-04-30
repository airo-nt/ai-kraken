<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Application\Repository\ChatReadRepositoryInterface;
use App\Application\Repository\DTO\ChatItemDTO;
use App\Application\Repository\DTO\PaginatedResult;
use App\Application\Repository\Exception\ReadRepositoryException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;

final class ChatReadDoctrineRepository implements ChatReadRepositoryInterface
{
    public function __construct(private readonly Connection $connection) {}

    public function findPaginated(int $page, int $limit): PaginatedResult
    {
        $offset = ($page - 1) * $limit;

        $sql = '
            SELECT chat_id, user_name, created_at
            FROM chats
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset
        ';

        try {
            $rows = $this->connection->fetchAllAssociative(
                $sql,
                [
                    'limit' => $limit,
                    'offset' => $offset
                ],
                [
                    'limit' => ParameterType::INTEGER,
                    'offset' => ParameterType::INTEGER
                ]
            );
        } catch (Exception $e) {
            throw new ReadRepositoryException($e);
        }

        $items = array_map(
            fn(array $row) => new ChatItemDTO(
                (int) $row['chat_id'],
                $row['user_name'] ?: null,
                $row['created_at']
            ),
            $rows
        );


        try {
            $total = (int) $this->connection->fetchOne('SELECT COUNT(chat_id) FROM chats');
        } catch (Exception $e) {
            throw new ReadRepositoryException($e);
        }

        return new PaginatedResult($items, $page, $limit, $total);
    }
}
