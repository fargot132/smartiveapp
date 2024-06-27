<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\EventHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\Event\ThumbnailImageCreatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Infrastructure\MessageBus\CommandBus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\UpdateThumbnailImageCommand;

#[AsMessageHandler]
class ThumbnailImageCreatedEventHandler
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(ThumbnailImageCreatedEvent $event): void
    {
        $this->commandBus->command(
            new UpdateThumbnailImageCommand($event->getThumbnailId(), $event->getThumbnailPath())
        );
    }
}
