<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Enum;

enum ThumbnailDestination: string
{
    case FILE_SYSTEM = 'file_system';
    case SFTP = 'sftp';
}
