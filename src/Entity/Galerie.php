<?php
namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalerieRepository::class)]
class Galerie
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\Column(length: 255)]
    private string $imageFilename;

    #[ORM\Column(length: 255)]
    private string $format = 'paysage';

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ordre = null;

    public function __construct()
    {
        $this->uuid = uniqid();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getimageFilename(): string
    {
        return $this->imageFilename;
    }

    public function setimageFilename($imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }
    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat($format) : self
    {
        $this->format = $format;

        return $this;
    }
    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
?>