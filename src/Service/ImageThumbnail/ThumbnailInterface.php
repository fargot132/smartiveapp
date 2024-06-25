<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ThumbnailDto;

interface ThumbnailInterface
{
    public function create(ThumbnailDto $thumbnailDto): string;
}
