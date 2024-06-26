<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto\CreateThumbnailDto;

interface ThumbnailImageInterface
{
    public function create(CreateThumbnailDto $thumbnailDto): string;
}
