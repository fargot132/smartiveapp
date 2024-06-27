<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Application\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\Enum\ThumbnailDestination;

class ThumbnailDto
{
    public function __construct(
        private int $id,
        private string $imageFileName,
        private int $width,
        private int $height,
        private ThumbnailDestination $destination
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getImageFileName(): string
    {
        return $this->imageFileName;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getDestination(): ThumbnailDestination
    {
        return $this->destination;
    }
}
