<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Dto\ThumbnailUploadDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Exception\UploadThumbnailFailedException;

interface ThumbnailUploaderInterface
{
    /**
     * @throws UploadThumbnailFailedException
     * @throws SourceImageNotFoundException
     */
    public function upload(ThumbnailUploadDto $dto): void;
}
