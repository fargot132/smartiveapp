<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\Event;

class ThumbnailCreatedEvent
{
    public function __construct(private int $thumbnailId)
    {
    }

    public function getThumbnailId(): int
    {
        return $this->thumbnailId;
    }
}
