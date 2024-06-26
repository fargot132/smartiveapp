<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\CommandHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\UpdateThumbnailImageCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailStatus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Event\ThumbnailUpdatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\ThumbnailPathVO;

#[AsMessageHandler]
class UpdateThumbnailImageCommandHandler
{
    public function __construct(
        private ThumbnailRepositoryInterface $thumbnailRepository,
        private MessageBusInterface $eventBus
    )
    {
    }
    public function __invoke(UpdateThumbnailImageCommand $command)
    {
        $thumbnail = $this->thumbnailRepository->get($command->getThumbnailId());
        if ($thumbnail === null) {
            throw new \Exception('Thumbnail not found');
        }

        $thumbnail->setThumbnailPath(new ThumbnailPathVO($command->getThumbnailPath()));
        $thumbnail->setStatus(ThumbnailStatus::CREATED);
        $this->thumbnailRepository->update($thumbnail);
        $this->eventBus->dispatch(new ThumbnailUpdatedEvent($thumbnail->getId()));
    }
}
