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

    public function findByChatId(ChatId $chatId): ?Chat
    {
        /* @var ChatDoctrine|null $chatDoctrine */
        $chatDoctrine = $this->find($chatId->getValue());

        return $chatDoctrine ? $this->transformer->toDomain($chatDoctrine) : null;
    }

    public function save(Chat $chat): void
    {
        $chatDoctrine = $this->transformer->toDoctrine($chat);
        $this->getEntityManager()->persist($chatDoctrine);
        $this->getEntityManager()->flush();
    }
}
