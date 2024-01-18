<?php

namespace App\Entity;

use App\Repository\TokensRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: TokensRepository::class)]
#[Broadcast]
class Tokens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $user_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $val = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cr_d = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(?string $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getVal(): ?string
    {
        return $this->val;
    }

    public function setVal(?string $val): static
    {
        $this->val = $val;

        return $this;
    }

    public function getCrD(): ?\DateTimeInterface
    {
        return $this->cr_d;
    }

    public function setCrD(?\DateTimeInterface $cr_d): static
    {
        $this->cr_d = $cr_d;

        return $this;
    }
}
