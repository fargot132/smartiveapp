<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\CommandHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\UpdateThumbnailFailedCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailStatus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Event\ThumbnailUpdatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\ErrorMessageVO;

#[AsMessageHandler]
class UpdateThumbnailFailedCommandHandler
{
    public function __construct(
        private ThumbnailRepositoryInterface $thumbnailRepository,
        private MessageBusInterface $eventBus
    ) {
    }
    public function __invoke(UpdateThumbnailFailedCommand $command): void
    {
        $thumbnail = $this->thumbnailRepository->get($command->getThumbnailId());
        if ($thumbnail === null) {
            throw new \Exception('Thumbnail not found');
        }

        $thumbnail->setStatus(ThumbnailStatus::FAILED);
        $thumbnail->setErrorMessage(new ErrorMessageVO($command->getErrorMessage()));
        $this->thumbnailRepository->update($thumbnail);
        $this->eventBus->dispatch(new ThumbnailUpdatedEvent($thumbnail->getId()));
    }
}
