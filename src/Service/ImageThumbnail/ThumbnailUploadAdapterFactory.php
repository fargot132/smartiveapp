<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Adapter\FileSystem\FileSystemAdapter;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Adapter\Sftp\SftpAdapter;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Enum\ThumbnailDestination;

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
