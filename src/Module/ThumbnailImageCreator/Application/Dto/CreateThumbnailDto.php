<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Enum\ImageResizeMode;

class CreateThumbnailDto
{
    public function __construct(
        private string $imageFileName,
        private int $width,
        private int $height,
        private ImageResizeMode $mode = ImageResizeMode::FIT
    ) {
    }

    public function getImageFileName(): string
    {
        return $this->imageFileName;
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
