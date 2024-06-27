<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter\ThumbnailUploadAdapterCollection;

class ThumbnailUploadAdapterFactory
{
    public function __construct(
        private ThumbnailUploadAdapterCollection $thumbnailUploadAdapterCollection,
    ) {
    }

    public function create(ThumbnailDestination $destination): ThumbnailUploadAdapterInterface
    {
        return $this->thumbnailUploadAdapterCollection->getAdapter($destination->value);
    }
}
