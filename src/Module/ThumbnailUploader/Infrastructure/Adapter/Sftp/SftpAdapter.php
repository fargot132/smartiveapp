<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter\Sftp;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Dto\SftpClientConfigDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Enum\SftpAuthType;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\ChangeDirFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\UploadFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Service\SftpClient;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Service\SftpClientFactory;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Exception\UploadThumbnailFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service\ThumbnailUploadAdapterInterface;

class SftpAdapter implements ThumbnailUploadAdapterInterface
{
    public function __construct(
        private SftpClientFactory $sftpClientFactory,
        private string $host,
        private int $port,
        private string $authType,
        private string $username,
        private string $password,
        private string $keyFile,
        private string $uploadDirectory
    ) {
    }

    /**
     * @throws UploadThumbnailFailedException
     */
    public function upload(string $sourceImagePath, string $destinationFileName): void
    {
        $sftpClient = $this->sftpClientFactory->create($this->createSftpClientConfigDto());
        try {
            $sftpClient->connect();
        } catch (\Exception $e) {
            throw new UploadThumbnailFailedException($e->getMessage());
        }

        try {
            $sftpClient->changeDir($this->uploadDirectory);
        } catch (ChangeDirFailedException $e) {
            $this->createDestinationDirectory($sftpClient);
        }

        $imageContent = file_get_contents($sourceImagePath);
        if ($imageContent === false) {
            throw new UploadThumbnailFailedException(
                'Failed to read image content from source file' . $sourceImagePath
            );
        }

        try {
            $sftpClient->upload($destinationFileName, $imageContent);
        } catch (UploadFailedException $e) {
            throw new UploadThumbnailFailedException($e->getMessage());
        }

        $sftpClient->close();
    }

    /**
     * @throws UploadThumbnailFailedException
     */
    private function createDestinationDirectory(SftpClient $sftpClient): void
    {
        try {
            $sftpClient->createDir($this->uploadDirectory);
            $sftpClient->changeDir($this->uploadDirectory);
        } catch (\Exception $e) {
            throw new UploadThumbnailFailedException($e->getMessage());
        }
    }

    private function createSftpClientConfigDto(): SftpClientConfigDto
    {
        return new SftpClientConfigDto(
            $this->host,
            $this->port,
            SftpAuthType::from($this->authType),
            $this->username,
            $this->password,
            $this->keyFile
        );
    }

    public static function getServiceIndex(): string
    {
        return ThumbnailDestination::SFTP->value;
    }
}
