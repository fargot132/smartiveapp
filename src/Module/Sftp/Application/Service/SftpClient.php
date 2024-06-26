<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Service;

use InvalidArgumentException;
use phpseclib3\Crypt\Common\AsymmetricKey;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Exception\NoKeyLoadedException;
use phpseclib3\Exception\UnableToConnectException;
use phpseclib3\Net\SFTP;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Enum\SftpAuthType;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\ChangeDirFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\CreateDirFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\DownloadFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\ListDirFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\LoginFailedException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Exception\UploadFailedException;
use UnexpectedValueException;

class SftpClient
{
    private ?string $host = null;

    private int $port = 22;

    private SftpAuthType $authType = SftpAuthType::PASSWORD;

    private ?string $username = null;

    private ?string $password = null;

    private ?AsymmetricKey $key = null;

    private ?SFTP $sftp = null;

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function setAuthType(SftpAuthType $authType): self
    {
        $this->authType = $authType;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @throws NoKeyLoadedException
     */
    public function setKeyFile(?string $keyFile): self
    {
        if (empty($keyFile)) {
            $this->key = null;

            return $this;
        }

        $this->key = PublicKeyLoader::load(file_get_contents($keyFile));

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     * @throws UnableToConnectException|LoginFailedException
     */
    public function connect(): void
    {
        if ($this->host === null) {
            throw new InvalidArgumentException('Host is required');
        }

        if ($this->username === null) {
            throw new InvalidArgumentException('Username is required');
        }

        if ($this->authType === SftpAuthType::PASSWORD) {
            if ($this->password === null) {
                throw new InvalidArgumentException('Password is required');
            }
            $this->sftp = new SFTP($this->host, $this->port);

            $this->connectPassword($this->username, $this->password);
        }

        if ($this->authType === SftpAuthType::KEY) {
            if ($this->key === null) {
                throw new InvalidArgumentException('Key is required');
            }
            $this->sftp = new SFTP($this->host, $this->port);

            $this->connectKey($this->username, $this->key);
        }
    }

    /**
     * @throws LoginFailedException
     */
    private function connectPassword(string $username, string $password): void
    {
        if ($this->sftp->login($username, $password) === false) {
            throw new LoginFailedException('Failed to connect to SFTP server');
        }
    }

    /**
     * @throws LoginFailedException
     */
    private function connectKey(string $username, AsymmetricKey $key): void
    {
        if ($this->sftp->login($username, $key) === false) {
            throw new LoginFailedException('Failed to connect to SFTP server');
        }
    }

    /**
     * @throws UnexpectedValueException
     * @throws UploadFailedException
     */
    public function upload(string $remoteFile, string $data): void
    {
       if ($this->sftp->put($remoteFile, $data) === false) {
            throw new UploadFailedException('Failed to upload file ' . $remoteFile);
        }
    }

    /**
     * @throws UnexpectedValueException|DownloadFailedException
     */
    public function download(string $remoteFile): string
    {
        $result = $this->sftp->get($remoteFile);
        if ($result === false) {
            throw new DownloadFailedException('Failed to download file ' . $remoteFile);
        }

        return $result;
    }

    public function close(): void
    {
        $this->sftp->disconnect();
    }

    /**
     * @throws ListDirFailedException
     */
    public function listDir(string $dir = '.'): array
    {
        $result = $this->sftp->nlist($dir);
        if ($result === false) {
            throw new ListDirFailedException('Failed to list directory ' . $dir);
        }

        return $result;
    }

    /**
     * @throws UnexpectedValueException
     * @throws ChangeDirFailedException
     */
    public function changeDir(string $dir): void
    {
        if ($this->sftp->chdir($dir) === false) {
            throw new ChangeDirFailedException('Failed to change directory ' . $dir);
        }
    }

    /**
     * @throws CreateDirFailedException
     */
    public function createDir($dir): void
    {
        if ($this->sftp->mkdir($dir) === false) {
            throw new CreateDirFailedException('Failed to create directory ' . $dir);
        }
    }
}
