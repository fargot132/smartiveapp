<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Dto\ImageResizeOptions;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;

interface ImageResizeInterface
{
    /**
     * @throws SourceImageNotFoundException
     */
    public function resize(string $sourceImagePath, ImageResizeOptions $options): string;
}
