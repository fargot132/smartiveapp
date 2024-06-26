<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Query;

class GetThumbnailQuery
{
    public function __construct(
        private int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
