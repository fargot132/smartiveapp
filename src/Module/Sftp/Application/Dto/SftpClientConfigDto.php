<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Dto;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Enum\SftpAuthType;

class SftpClientConfigDto
{
    public function __construct(
        private string $host,
        private int $port,
        private SftpAuthType $authType,
        private ?string $username,
        private ?string $password,
        private ?string $keyFile
    ) {
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getAuthType(): SftpAuthType
    {
        return $this->authType;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getKeyFile(): ?string
    {
        return $this->keyFile;
    }
}
