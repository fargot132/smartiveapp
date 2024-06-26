<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Enum\ImageResizeMode;

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
