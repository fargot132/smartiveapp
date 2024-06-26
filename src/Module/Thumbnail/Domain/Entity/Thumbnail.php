<?php

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailStatus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\ErrorMessageVO;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\HeightVO;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\ImagePathVO;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\ThumbnailPathVO;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\WidthVO;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Infrastructure\Persistence\Repository\ThumbnailRepository;

#[ORM\Entity(repositoryClass: ThumbnailRepository::class)]
class Thumbnail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded(class: ImagePathVO::class)]
    private ?ImagePathVO $imagePath = null;

    #[ORM\Embedded(class: ThumbnailPathVO::class)]
    private ?ThumbnailPathVO $thumbnailPath = null;

    #[ORM\Embedded(class: WidthVO::class)]
    private ?WidthVO $width = null;

    #[ORM\Embedded(class: HeightVO::class)]
    private ?HeightVO $height = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Embedded(class: ErrorMessageVO::class)]
    private ?ErrorMessageVO $errorMessage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getImagePath(): ?ImagePathVO
    {
        return $this->imagePath;
    }

    public function setImagePath(ImagePathVO $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getThumbnailPath(): ?ThumbnailPathVO
    {
        return $this->thumbnailPath;
    }

    public function setThumbnailPath(?ThumbnailPathVO $thumbnailPath): static
    {
        $this->thumbnailPath = $thumbnailPath;

        return $this;
    }

    public function getWidth(): ?WidthVO
    {
        return $this->width;
    }

    public function setWidth(WidthVO $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?HeightVO
    {
        return $this->height;
    }

    public function setHeight(HeightVO $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getDestination(): ?ThumbnailDestination
    {
        return ThumbnailDestination::tryFrom($this->destination);
    }

    public function setDestination(ThumbnailDestination $destination): static
    {
        $this->destination = $destination->value;

        return $this;
    }

    public function getStatus(): ?ThumbnailStatus
    {
        return ThumbnailStatus::tryFrom($this->status);
    }

    public function setStatus(ThumbnailStatus $status): static
    {
        $this->status = $status->value;

        return $this;
    }

    public function getErrorMessage(): ?ErrorMessageVO
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?ErrorMessageVO $errorMessage): static
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }
}
