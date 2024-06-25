<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\Sftp\Enum;

enum SftpAuthType: string
{
    case PASSWORD = 'password';
    case KEY = 'key';
}
