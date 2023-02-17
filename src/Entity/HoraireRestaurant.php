<?php

namespace App\Entity;

use App\Repository\HoraireRestaurantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRestaurantRepository::class)]
class HoraireRestaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jour = null;

    #[ORM\Column]
    private ?bool $ouvert = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $open_midi = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $close_midi = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $open_soir = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $close_soir = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function isOuvert(): ?bool
    {
        return $this->ouvert;
    }

    public function setOuvert(bool $ouvert): self
    {
        $this->ouvert = $ouvert;

        return $this;
    }

    public function getOpenMidi(): ?\DateTimeInterface
    {
        return $this->open_midi;
    }

    public function setOpenMidi(?\DateTimeInterface $open_midi): self
    {
        $this->open_midi = $open_midi;

        return $this;
    }

    public function getCloseMidi(): ?\DateTimeInterface
    {
        return $this->close_midi;
    }

    public function setCloseMidi(?\DateTimeInterface $close_midi): self
    {
        $this->close_midi = $close_midi;

        return $this;
    }

    public function getOpenSoir(): ?\DateTimeInterface
    {
        return $this->open_soir;
    }

    public function setOpenSoir(?\DateTimeInterface $open_soir): self
    {
        $this->open_soir = $open_soir;

        return $this;
    }

    public function getCloseSoir(): ?\DateTimeInterface
    {
        return $this->close_soir;
    }

    public function setCloseSoir(?\DateTimeInterface $close_soir): self
    {
        $this->close_soir = $close_soir;

        return $this;
    }
}
