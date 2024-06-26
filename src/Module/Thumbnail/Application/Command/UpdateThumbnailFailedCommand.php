<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command;

class UpdateThumbnailFailedCommand
{
    public function __construct(private int $thumbnailId, private string $errorMessage)
    {
    }

    public function getThumbnailId(): int
    {
        return $this->thumbnailId;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
