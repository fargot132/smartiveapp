<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto\ThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ImageResizeOptionsDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageFileSystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\ImageResizeInterface;

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
