<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Enum;

enum ImageResizeMode: string
{
    case CROP = 'crop';
    case FIT = 'fit';
    case STRETCH = 'stretch';
}
