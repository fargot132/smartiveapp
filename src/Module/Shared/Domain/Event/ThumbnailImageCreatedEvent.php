<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\Event;

class ThumbnailImageCreatedEvent
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
