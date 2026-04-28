<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Transformer;

use App\Domain\Model\Chat;
use App\Domain\Model\ValueObject\ChatId;
use App\Infrastructure\Doctrine\Entity\ChatDoctrine;

final class ChatTransformer
{
    public function toDomain(ChatDoctrine $chatDoctrine): Chat
    {
        return new Chat(
            new ChatId($chatDoctrine->getChatId()),
            $chatDoctrine->getCreatedAt()
        );
    }

    public function toDoctrine(Chat $chat): ChatDoctrine
    {
        return new ChatDoctrine()
            ->setChatId($chat->getChatId()->getValue())
            ->setCreatedAt($chat->getCreatedAt());
    }
}
