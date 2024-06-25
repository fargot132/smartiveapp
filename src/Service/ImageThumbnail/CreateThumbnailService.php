<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail;


use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\Filesystem\FilesystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Dto\CreateThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Dto\ImageResizeOptions;

class CreateThumbnailService implements CreateThumbnailInterface
{
    public function __construct(private ImageResizeInterface $imageServer)
    {
    }

    public function create(CreateThumbnailDto $createThumbnailDto): string
    {
        return $this->imageServer->resize(
            $createThumbnailDto->getSourceImagePath(),
            new ImageResizeOptions(
                $createThumbnailDto->getWidth(),
                $createThumbnailDto->getHeight(),
                $createThumbnailDto->getMode()
            )
        );
    }
}
