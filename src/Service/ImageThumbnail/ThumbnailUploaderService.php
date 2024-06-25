<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ThumbnailUploadDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\UploadThumbnailFailedException;

class ThumbnailUploaderService implements ThumbnailUploaderInterface
{
    public function __construct(
        private ThumbnailUploadAdapterFactory $thumbnailUploadAdapterFactory
    ) {
    }

    /**
     * @throws UploadThumbnailFailedException
     * @throws SourceImageNotFoundException
     */
    public function upload(ThumbnailUploadDto $dto): void
    {
        $adapter = $this->thumbnailUploadAdapterFactory->create($dto->getDestination());
        $adapter->upload($dto->getSourceImagePath(), $dto->getDestinationFileName());
    }
}
