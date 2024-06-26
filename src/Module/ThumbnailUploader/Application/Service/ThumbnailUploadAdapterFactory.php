<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter\FileSystem\FileSystemAdapter;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter\Sftp\SftpAdapter;
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
