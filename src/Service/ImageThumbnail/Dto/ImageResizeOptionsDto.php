<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Enum\ImageResizeMode;

class ImageResizeOptionsDto
{
    public function __construct(
        private int $width,
        private int $height,
        private ImageResizeMode $mode
    ) {
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getMode(): ImageResizeMode
    {
        return $this->mode;
    }
}
