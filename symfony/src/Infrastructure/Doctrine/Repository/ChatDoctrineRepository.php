<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;
use App\Domain\Repository\ChatRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\ChatDoctrine;
use App\Infrastructure\Doctrine\Transformer\ChatTransformer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ChatDoctrineRepository extends ServiceEntityRepository implements ChatRepositoryInterface
{
    public function __construct(
        private readonly ManagerRegistry $registry,
        private readonly ChatTransformer $transformer
    ) {
        parent::__construct($registry, ChatDoctrine::class);
    }

    public function isExistsByChatId(ChatId $chatId): bool
    {
        return $this->createQueryBuilder('c')
                ->select('1')
                ->where('c.chatId = :chatId')
                ->setParameter('chatId', $chatId->getValue())
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult() !== null;
    }

    public function create(Chat $chat): void
    {
        $chatDoctrine = $this->transformer->toDoctrine($chat);
        $this->getEntityManager()->persist($chatDoctrine);
        $this->getEntityManager()->flush();
    }
}
