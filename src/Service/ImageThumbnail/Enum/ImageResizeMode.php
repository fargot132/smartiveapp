<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Enum;

enum ImageResizeMode: string
{
    case CROP = 'crop';
    case FIT = 'fit';
    case STRETCH = 'stretch';
}
