<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject;

use InvalidArgumentException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\ValueObject\StringVO;

abstract class String4096VO extends StringVO
{
    public const int MAX_LENGTH = 4096;

    public function __construct(string $value)
    {
        if (strlen($value) > static::MAX_LENGTH) {
            throw new InvalidArgumentException('String is too long');
        }
        parent::__construct($value);
    }
}
