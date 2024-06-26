<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Event;

class ThumbnailUploadFailedEvent
{
    public function __construct(private int $id, private string $errorMessage)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
