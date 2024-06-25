<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp;

use TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\Dto\SftpClientConfigDto;

class SftpClientFactory
{
    public function create(SftpClientConfigDto $config): SftpClient
    {
        $sftpClient = new SftpClient();
        $sftpClient
            ->setHost($config->getHost())
            ->setPort($config->getPort())
            ->setAuthType($config->getAuthType())
            ->setUsername($config->getUsername())
            ->setPassword($config->getPassword())
            ->setKeyFile($config->getKeyFile());

        return $sftpClient;
    }
}
