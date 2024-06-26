<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;

class ThumbnailUploadDto
{
    public function __construct(
        private string $sourceImagePath,
        private string $destinationFileName,
        private ThumbnailDestination $destination
    ) {
    }

    public function getSourceImagePath(): string
    {
        return $this->sourceImagePath;
    }

    public function getDestinationFileName(): string
    {
        return $this->destinationFileName;
    }

    public function getDestination(): ThumbnailDestination
    {
        return $this->destination;
    }
}
