<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Infrastructure\Adapter\Glide;

use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\Filesystem\FilesystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ImageResizeOptionsDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Enum\ImageResizeMode;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageFileSystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\ImageResizeInterface;

class GlideAdapter implements ImageResizeInterface
{
    public const string GLIDE_MODE_CROP = 'crop';
    public const string GLIDE_MODE_STRETCH = 'stretch';
    public const string GLIDE_MODE_CONTAIN = 'contain';

    public function __construct(
        private GlideServerFactory $glideServerFactory,
        private string $sourceImageDirectory,
        private string $cacheDirectory
    ) {
    }

    /**
     * @throws SourceImageFileSystemException
     * @throws SourceImageNotFoundException
     */
    public function resize(string $sourceImagePath, ImageResizeOptionsDto $options): string
    {
        try {
            $glideServer = $this->glideServerFactory->make($this->sourceImageDirectory, $this->cacheDirectory);
            $filePath = $glideServer->makeImage($sourceImagePath, [
                'w' => $options->getWidth(),
                'h' => $options->getHeight(),
                'fit' => $this->convertModeToGlideMode($options)
            ]);

            return $this->cacheDirectory . '/' . $filePath;
        } catch (FileNotFoundException $exception) {
            throw new SourceImageNotFoundException($exception->getMessage());
        } catch (FilesystemException $e) {
            throw new SourceImageFileSystemException($e->getMessage());
        }
    }

    private function convertModeToGlideMode(ImageResizeOptionsDto $options): string
    {
        return match ($options->getMode()) {
            ImageResizeMode::CROP => self::GLIDE_MODE_CROP,
            ImageResizeMode::STRETCH => self::GLIDE_MODE_STRETCH,
            default => self::GLIDE_MODE_CONTAIN,
        };
    }
}
