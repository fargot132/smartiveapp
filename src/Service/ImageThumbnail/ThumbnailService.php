<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ImageResizeOptionsDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageFileSystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;

class ThumbnailService implements ThumbnailInterface
{
    public function __construct(private ImageResizeInterface $imageServer)
    {
    }

    /**
     * @throws SourceImageNotFoundException
     * @throws SourceImageFileSystemException
     */
    public function create(ThumbnailDto $thumbnailDto): string
    {
        return $this->imageServer->resize(
            $thumbnailDto->getImageFileName(),
            new ImageResizeOptionsDto(
                $thumbnailDto->getWidth(),
                $thumbnailDto->getHeight(),
                $thumbnailDto->getMode()
            )
        );
    }
}
