<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\EventHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Domain\Event\ThumbnailUploadFailedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Infrastructure\MessageBus\CommandBus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\UpdateThumbnailFailedCommand;

#[AsMessageHandler]
class ThumbnailUploadFailedHandler
{
    public function __construct(private CommandBus $commandBus)
    {
    }
    public function __invoke(ThumbnailUploadFailedEvent $event): void
    {
        $this->commandBus->command(
            new UpdateThumbnailFailedCommand($event->getId(), $event->getErrorMessage())
        );
    }
}
