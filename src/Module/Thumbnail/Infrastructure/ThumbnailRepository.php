<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Infrastructure;

use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Application\Dto\ThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Application\ThumbnailInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;

class ThumbnailRepository implements ThumbnailInterface
{
    public function __construct(private ThumbnailRepositoryInterface $repository)
    {
    }
    public function getThumbnailById(int $id): ?ThumbnailDto
    {
        $thumbnail = $this->repository->get((int) $id);
        if ($thumbnail === null) {
            return null;
        }

        return new ThumbnailDto(
            $thumbnail->getId(),
            $thumbnail->getImagePath()?->value(),
            $thumbnail->getWidth()?->value(),
            $thumbnail->getHeight()?->value(),
            $thumbnail->getDestination()
        );
    }
}
