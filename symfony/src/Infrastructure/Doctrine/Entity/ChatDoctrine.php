<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'chats')]
class ChatDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[Assert\Positive]
    private int $chatId;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    #[Assert\Length(min: 5, max: 32)]
    private ?string $userName;

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function setChatId(int $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }
}
