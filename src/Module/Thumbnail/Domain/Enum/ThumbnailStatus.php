<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum;

enum ThumbnailStatus: string
{
    case CREATED = 'created';
    case FAILED = 'failed';
    case QUEUED = 'queued';
    case UPLOADED = 'uploaded';
}
