<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Sftp\Application\Dto;

class FileDto
{
    public function __construct(private string $name, private string $content)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
