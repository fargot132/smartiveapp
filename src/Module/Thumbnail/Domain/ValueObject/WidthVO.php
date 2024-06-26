<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\ValueObject\PositiveIntegerVO;

#[Embeddable]
class WidthVO extends PositiveIntegerVO
{
    #[Column(type: 'integer')]
    protected int $value;
}
