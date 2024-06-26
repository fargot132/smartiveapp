<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\CommandHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\CreateThumbnailCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity\Thumbnail;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailStatus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Event\ThumbnailCreatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\HeightVO;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\ImagePathVO;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ValueObject\WidthVO;

#[AsMessageHandler]
class CreateThumbnailCommandHandler
{
    public function __construct(
        private ThumbnailRepositoryInterface $thumbnailRepository,
        private MessageBusInterface $eventBus
    ) {
    }

    public function __invoke(CreateThumbnailCommand $command): int
    {
        $thumbnail = new Thumbnail();
        $thumbnail
            ->setImagePath(new ImagePathVO($command->getImagePath()))
            ->setWidth(new WidthVO($command->getWidth()))
            ->setHeight(new HeightVO($command->getHeight()))
            ->setDestination($command->getDestination())
            ->setStatus(ThumbnailStatus::QUEUED);

        $this->thumbnailRepository->save($thumbnail);
        $this->eventBus->dispatch(new ThumbnailCreatedEvent($thumbnail->getId()));

        return $thumbnail->getId();
    }
}
