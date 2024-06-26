<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command;

class UpdateThumbnailImageCommand
{
    public function __construct(private int $thumbnailId, private string $thumbnailPath)
    {
    }

    public function getThumbnailId(): int
    {
        return $this->thumbnailId;
    }

    public function getThumbnailPath(): string
    {
        return $this->thumbnailPath;
    }
}
