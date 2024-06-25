<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Dto\CreateThumbnailDto;

interface CreateThumbnailInterface
{
    public function create(CreateThumbnailDto $createThumbnailDto): string;
}
