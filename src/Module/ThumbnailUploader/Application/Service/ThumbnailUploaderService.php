<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Dto\ThumbnailUploadDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Exception\UploadThumbnailFailedException;

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
