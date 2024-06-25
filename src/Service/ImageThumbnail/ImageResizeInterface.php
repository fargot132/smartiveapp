<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ImageResizeOptionsDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageFileSystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;

interface ImageResizeInterface
{
    /**
     * @throws SourceImageFileSystemException
     * @throws SourceImageNotFoundException
     */
    public function resize(string $sourceImagePath, ImageResizeOptionsDto $options): string;
}
