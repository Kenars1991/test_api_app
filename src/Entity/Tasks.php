<?php

namespace App\Entity;

use App\Repository\TasksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: TasksRepository::class)]
#[Broadcast]
class Tasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1500, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 1500, nullable: true)]
    private ?string $descr = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cr_d = null;

    #[ORM\Column(length: 1500, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_done = null;

    #[ORM\Column(nullable: true)]
    private ?int $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(?string $descr): static
    {
        $this->descr = $descr;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDateDone(): ?\DateTimeInterface
    {
        return $this->date_done;
    }

    public function setDateDone(?\DateTimeInterface $date_done): static
    {
        $this->date_done = $date_done;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
