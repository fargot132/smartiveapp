<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\EventHandler;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Application\ThumbnailInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Event\ThumbnailCreatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto\CreateThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Event\ThumbnailImageCreatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Event\ThumbnailImageFailedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageFileSystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Service\ThumbnailImageService;

#[AsMessageHandler(fromTransport: 'async')]
class ThumbnailCreatedEventHandler
{
    public function __construct(
        private ThumbnailImageService $createThumbnailService,
        private ThumbnailInterface $thumbnailRepository,
        private LoggerInterface $logger,
        private MessageBusInterface $eventBus
    ) {
    }

    public function __invoke(ThumbnailCreatedEvent $event): void
    {
        $thumbnail = $this->thumbnailRepository->getThumbnailById($event->getThumbnailId());

        if (!$thumbnail) {
            return;
        }

        $createThumbnailDto = new CreateThumbnailDto(
            $thumbnail->getImageFileName(),
            $thumbnail->getWidth(),
            $thumbnail->getHeight()
        );

        try {
            $thumbnailPath = $this->createThumbnailService->create($createThumbnailDto);
        } catch (SourceImageNotFoundException | SourceImageFileSystemException $e) {
            $this->logger->error(
                'Failed to create thumbnail for image ' . $createThumbnailDto->getImageFileName()
                . ' :' . $e->getMessage()
            );
            $this->eventBus->dispatch(new ThumbnailImageFailedEvent($thumbnail->getId(), $e->getMessage()));

            return;
        }

        $this->eventBus->dispatch(
            new ThumbnailImageCreatedEvent($thumbnail->getId(), $thumbnailPath)
        );
    }
}
