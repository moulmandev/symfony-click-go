<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $day;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $endDate;

    /**
     * @ORM\ManyToMany(targetEntity=Shop::class, inversedBy="reservations")
     */
    private $shop;

    /**
     * @ORM\OneToMany(targetEntity=Command::class, mappedBy="reservation")
     */
    private $commands;

    public function __construct()
    {
        $this->shop = new ArrayCollection();
        $this->commands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShop(): Collection
    {
        return $this->shop;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->shop->contains($shop)) {
            $this->shop[] = $shop;
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        $this->shop->removeElement($shop);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getDay() . " (" . $this->getStartDate() . " - " . $this->getEndDate() . ")";
    }

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->setReservation($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->removeElement($command)) {
            // set the owning side to null (unless already changed)
            if ($command->getReservation() === $this) {
                $command->setReservation(null);
            }
        }

        return $this;
    }


}
