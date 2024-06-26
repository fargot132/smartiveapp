<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Service;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto\ImageResizeOptionsDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto\ThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageFileSystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageNotFoundException;

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
