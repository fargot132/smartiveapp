<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto\ThumbnailDto;

interface ThumbnailInterface
{
    public function create(ThumbnailDto $thumbnailDto): string;
}
