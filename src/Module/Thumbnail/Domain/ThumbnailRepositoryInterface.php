<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity\Thumbnail;

interface ThumbnailRepositoryInterface
{
    public function save(Thumbnail $thumbnail): void;
    public function get(int $id): ?Thumbnail;
    public function update(Thumbnail $thumbnail): void;
}
