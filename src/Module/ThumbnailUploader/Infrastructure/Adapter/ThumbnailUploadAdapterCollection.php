<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Infrastructure\Adapter;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service\ThumbnailUploadAdapterInterface;

class ThumbnailUploadAdapterCollection
{
    private iterable $adapters;
    public function __construct(
        #[AutowireIterator(tag: 'thumbnail.upload.adapter', defaultIndexMethod: 'getServiceIndex')]
        iterable $adapters
    ) {
        $this->adapters = $adapters;
    }

    public function getAdapters(): iterable
    {
        return $this->adapters;
    }

    public function getAdapter(string $index): ?ThumbnailUploadAdapterInterface
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter::getServiceIndex() === $index) {
                return $adapter;
            }
        }

        return null;
    }
}
