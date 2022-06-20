<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank()]
    #[Assert\Date()]
    private $ReservationsAt;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank()]
    #[Assert\Date()]
    private $ReservationsMaxAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private $ReservationsLongAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private $ReservationsLongMaxAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private $user;

    #[ORM\ManyToOne(targetEntity: Books::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private $books;

    #[ORM\Column(type: 'boolean')]
    private $Remove;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationsAt(): ?\DateTimeInterface
    {
        return $this->ReservationsAt;
    }

    public function setReservationsAt(\DateTimeInterface $ReservationsAt): self
    {
        $this->ReservationsAt = $ReservationsAt;

        return $this;
    }

    public function getReservationsMaxAt(): ?\DateTimeInterface
    {
        return $this->ReservationsMaxAt;
    }

    public function setReservationsMaxAt(?\DateTimeInterface $ReservationsMaxAt): self
    {
        $this->ReservationsMaxAt = $ReservationsMaxAt;

        return $this;
    }

    public function getReservationsLongAt(): ?\DateTimeInterface
    {
        return $this->ReservationsLongAt;
    }

    public function setReservationsLongAt(?\DateTimeInterface $ReservationsLongAt): self
    {
        $this->ReservationsLongAt = $ReservationsLongAt;

        return $this;
    }

    public function getReservationsLongMaxAt(): ?\DateTimeInterface
    {
        return $this->ReservationsLongMaxAt;
    }

    public function setReservationsLongMaxAt(?\DateTimeInterface $ReservationsLongMaxAt): self
    {
        $this->ReservationsLongMaxAt = $ReservationsLongMaxAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBooks(): ?Books
    {
        return $this->books;
    }

    public function setBooks(?Books $books): self
    {
        $this->books = $books;

        return $this;
    }

    public function isRemove(): ?bool
    {
        return $this->Remove;
    }

    public function setRemove(bool $Remove): self
    {
        $this->Remove = $Remove;

        return $this;
    }
}
