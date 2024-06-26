<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Exception\UploadThumbnailFailedException;

interface ThumbnailUploadAdapterInterface
{
    /**
     * @throws UploadThumbnailFailedException
     * @throws SourceImageNotFoundException
     */
    public function upload(string $sourceImagePath, string $destinationFileName): void;
    public static function getServiceIndex(): string;
}
