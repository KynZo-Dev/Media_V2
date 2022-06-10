<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'reservations')]
    private $User;

    #[ORM\Column(type: 'date')]
    private $ReservationsAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private $ReservationsMaxAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private $ReservationsLongAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private $ReservationsLongMaxAt;

    #[ORM\Column(type: 'boolean')]
    private $ReservationsRemove;

    public function __construct()
    {
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->User->removeElement($user);

        return $this;
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

    public function isReservationsRemove(): ?bool
    {
        return $this->ReservationsRemove;
    }

    public function setReservationsRemove(bool $ReservationsRemove): self
    {
        $this->ReservationsRemove = $ReservationsRemove;

        return $this;
    }
}
