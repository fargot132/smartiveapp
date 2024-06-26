<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\ValueObject;

use JsonSerializable;
use Stringable;

class StringVO implements Stringable, JsonSerializable
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function equals(StringVO $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function empty(): bool
    {
        return empty($this->value());
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
