<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Application;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Application\Dto\ThumbnailDto;

interface ThumbnailInterface
{
    public function getThumbnailById(int $id): ?ThumbnailDto;
}
