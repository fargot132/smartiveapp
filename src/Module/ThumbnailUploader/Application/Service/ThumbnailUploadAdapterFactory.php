<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter\FileSystem\FileSystemAdapter;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter\Sftp\SftpAdapter;

class ThumbnailUploadAdapterFactory
{
    public function __construct(
        private FileSystemAdapter $fileSystemAdapter,
        private SftpAdapter $sftpAdapter,
    ) {
    }

    public function create(ThumbnailDestination $destination): ThumbnailUploadAdapterInterface
    {
        return match ($destination) {
            ThumbnailDestination::FILE_SYSTEM => $this->fileSystemAdapter,
            ThumbnailDestination::SFTP => $this->sftpAdapter,
        };
    }
}
