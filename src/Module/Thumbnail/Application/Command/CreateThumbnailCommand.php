<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;

class CreateThumbnailCommand
{
    public function __construct(
        private string $imagePath,
        private int $width,
        private int $height,
        private ThumbnailDestination $destination
    ) {
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
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
