<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command;

class UpdateThumbnailUploadedCommand
{
    public function __construct(private int $thumbnailId)
    {
    }

    public function getThumbnailId(): int
    {
        return $this->thumbnailId;
    }
}
