<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\UploadThumbnailFailedException;

interface ThumbnailUploadAdapterInterface
{
    /**
     * @throws UploadThumbnailFailedException
     * @throws SourceImageNotFoundException
     */
    public function upload(string $sourceImagePath, string $destinationFileName): void;
}
