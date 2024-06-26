<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\CommandHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\UpdateThumbnailUploadedCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailStatus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Event\ThumbnailUpdatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;

#[AsMessageHandler]
class UpdateThumbnailUploadedCommandHandler
{
    public function __construct(
        private ThumbnailRepositoryInterface $thumbnailRepository,
        private MessageBusInterface $eventBus
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(UpdateThumbnailUploadedCommand $command): void
    {
        $thumbnail = $this->thumbnailRepository->get($command->getThumbnailId());
        if ($thumbnail === null) {
            throw new \Exception('Thumbnail not found');
        }

        $thumbnail->setStatus(ThumbnailStatus::UPLOADED);
        $this->thumbnailRepository->update($thumbnail);
        $this->eventBus->dispatch(new ThumbnailUpdatedEvent($thumbnail->getId()));
    }
}
