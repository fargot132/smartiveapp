<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Enum\ImageResizeMode;

class ImageResizeOptions
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
