<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\EventHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\Event\ThumbnailUploadedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Infrastructure\MessageBus\CommandBus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\UpdateThumbnailUploadedCommand;

#[AsMessageHandler]
class ThumbnailUploadedEventHandler
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(ThumbnailUploadedEvent $event): void
    {
        $this->commandBus->command(new UpdateThumbnailUploadedCommand($event->getId()));
    }
}
