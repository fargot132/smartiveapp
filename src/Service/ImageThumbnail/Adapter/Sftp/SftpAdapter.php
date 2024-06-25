<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Adapter\Sftp;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\UploadThumbnailFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\ThumbnailUploadAdapterInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\Dto\SftpClientConfigDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\Enum\SftpAuthType;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\Exception\ChangeDirFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\Exception\UploadFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\SftpClient;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\SftpClientFactory;

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
}
