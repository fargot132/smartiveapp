<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Adapter\FileSystem;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\UploadThumbnailFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\ThumbnailUploadAdapterInterface;

class FileSystemAdapter implements ThumbnailUploadAdapterInterface
{
    public function __construct(private Filesystem $filesystem, private string $thumbnailImagePath)
    {
    }

    /**
     * @throws UploadThumbnailFailedException
     * @throws SourceImageNotFoundException
     */
    public function upload(string $sourceImagePath, string $destinationFileName): void
    {
        try {
            $this->filesystem->copy(
                $sourceImagePath,
                $this->thumbnailImagePath . '/' . $destinationFileName
            );
        } catch (FileNotFoundException $e) {
            throw new SourceImageNotFoundException($e->getMessage());
        } catch (IOException $e) {
            throw new UploadThumbnailFailedException($e->getMessage());
        }
    }
}
