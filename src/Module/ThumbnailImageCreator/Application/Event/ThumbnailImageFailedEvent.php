<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Event;

class ThumbnailImageFailedEvent
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
