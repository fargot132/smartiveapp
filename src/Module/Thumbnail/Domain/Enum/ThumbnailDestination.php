<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum;

enum ThumbnailDestination: string
{
    case FILE_SYSTEM = 'file_system';
    case SFTP = 'sftp';
}
