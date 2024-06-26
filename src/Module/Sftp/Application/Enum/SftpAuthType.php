<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Enum;

enum SftpAuthType: string
{
    case PASSWORD = 'password';
    case KEY = 'key';
}
