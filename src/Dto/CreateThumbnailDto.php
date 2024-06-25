<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Enum\ImageResizeMode;

class CreateThumbnailDto
{
    public function __construct(
        private string $sourceImagePath,
        private int $width,
        private int $height,
        private ImageResizeMode $mode = ImageResizeMode::FIT
    ) {
    }

    public function getSourceImagePath(): string
    {
        return $this->sourceImagePath;
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
