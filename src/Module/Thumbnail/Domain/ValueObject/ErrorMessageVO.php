<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class ErrorMessageVO extends String4096VO
{
    #[Column(type: 'string', length: self::MAX_LENGTH, nullable: true)]
    protected string $value;
}
