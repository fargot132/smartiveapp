<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\QueryHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Query\GetThumbnailQuery;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity\Thumbnail;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;

#[AsMessageHandler]
class GetThumbnailQueryHandler
{
    public function __construct(private ThumbnailRepositoryInterface $thumbnailRepository)
    {
    }
    public function __invoke(GetThumbnailQuery $query): ?Thumbnail
    {
        return $this->thumbnailRepository->get($query->getId());
    }
}
