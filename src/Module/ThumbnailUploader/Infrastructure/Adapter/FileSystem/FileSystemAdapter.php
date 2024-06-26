<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter\FileSystem;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Exception\UploadThumbnailFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service\ThumbnailUploadAdapterInterface;

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
