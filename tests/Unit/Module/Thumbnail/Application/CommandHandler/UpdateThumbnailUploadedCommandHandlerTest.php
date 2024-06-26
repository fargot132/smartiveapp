<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Tests\Unit\Module\Thumbnail\Application\CommandHandler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\UpdateThumbnailUploadedCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\CommandHandler\UpdateThumbnailUploadedCommandHandler;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity\Thumbnail;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailStatus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Event\ThumbnailUpdatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateThumbnailUploadedCommandHandlerTest extends TestCase
{
    private ThumbnailRepositoryInterface&MockObject $thumbnailRepository;
    private MessageBusInterface&MockObject $eventBus;
    private UpdateThumbnailUploadedCommandHandler $handler;

    protected function setUp(): void
    {
        $this->thumbnailRepository = $this->createMock(ThumbnailRepositoryInterface::class);
        $this->eventBus = $this->createMock(MessageBusInterface::class);
        $this->handler = new UpdateThumbnailUploadedCommandHandler($this->thumbnailRepository, $this->eventBus);
    }

    public function testHandleUpdatesThumbnailStatusAndDispatchesEvent(): void
    {
        $command = new UpdateThumbnailUploadedCommand(1);

        $thumbnail = new Thumbnail();
        $thumbnail->setId(1);

        $this->thumbnailRepository
            ->expects($this->once())
            ->method('get')
            ->with($command->getThumbnailId())
            ->willReturn($thumbnail);

        $this->thumbnailRepository
            ->expects($this->once())
            ->method('update')
            ->with($thumbnail)
            ->willReturnCallback(function (Thumbnail $thumbnail) {
                $this->assertEquals(ThumbnailStatus::UPLOADED, $thumbnail->getStatus());
            });

        $this->eventBus
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ThumbnailUpdatedEvent::class))
            ->willReturn(new Envelope(new \stdClass()));

        $this->handler->__invoke($command);
    }

    public function testHandleThrowsExceptionWhenThumbnailNotFound(): void
    {
        $command = new UpdateThumbnailUploadedCommand(1);

        $this->thumbnailRepository
            ->expects($this->once())
            ->method('get')
            ->with($command->getThumbnailId())
            ->willReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Thumbnail not found');

        $this->handler->__invoke($command);
    }
}
