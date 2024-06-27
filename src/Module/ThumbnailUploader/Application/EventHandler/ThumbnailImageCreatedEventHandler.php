<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\EventHandler;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Application\ThumbnailInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Event\ThumbnailImageCreatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Dto\ThumbnailUploadDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Event\ThumbnailUploadedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Event\ThumbnailUploadFailedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailUploader\Application\Service\ThumbnailUploaderInterface;

#[AsMessageHandler]
class ThumbnailImageCreatedEventHandler
{
    public function __construct(
        private ThumbnailUploaderInterface $thumbnailUploader,
        private ThumbnailInterface $thumbnailRepository,
        private LoggerInterface $logger,
        private MessageBusInterface $eventBus
    ) {
    }

    public function __invoke(ThumbnailImageCreatedEvent $event): void
    {
        $thumbnail = $this->thumbnailRepository->getThumbnailById($event->getThumbnailId());
        if (!$thumbnail) {
            return;
        }

        try {
            $this->thumbnailUploader->upload(
                new ThumbnailUploadDto(
                    $event->getThumbnailPath(),
                    $thumbnail->getImageFileName(),
                    $thumbnail->getDestination()
                )
            );
        } catch (\Exception $e) {
            $this->logger->error(
                'Failed to upload thumbnail file ' . $event->getThumbnailPath()
                . ' :' . $e->getMessage()
            );
            $this->eventBus->dispatch(new ThumbnailUploadFailedEvent($thumbnail->getId(), $e->getMessage()));

            return;
        }

        $this->eventBus->dispatch(new ThumbnailUploadedEvent($thumbnail->getId()));
    }
}
