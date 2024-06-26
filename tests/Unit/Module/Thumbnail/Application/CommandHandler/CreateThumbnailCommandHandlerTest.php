<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Tests\Unit\Module\Thumbnail\Application\CommandHandler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\CreateThumbnailCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\CommandHandler\CreateThumbnailCommandHandler;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity\Thumbnail;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Event\ThumbnailCreatedEvent;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\ThumbnailRepositoryInterface;

class CreateThumbnailCommandHandlerTest extends TestCase
{
    private ThumbnailRepositoryInterface&MockObject $thumbnailRepository;

    private MessageBusInterface&MockObject $eventBus;

    private CreateThumbnailCommandHandler $handler;

    protected function setUp(): void
    {
        $this->thumbnailRepository = $this->createMock(ThumbnailRepositoryInterface::class);
        $this->eventBus = $this->createMock(MessageBusInterface::class);
        $this->handler = new CreateThumbnailCommandHandler($this->thumbnailRepository, $this->eventBus);
    }

    public function testHandleCreatesThumbnailAndDispatchesEvent(): void
    {
        $command = new CreateThumbnailCommand('imagePath', 200, 200, ThumbnailDestination::FILE_SYSTEM);

        $this->thumbnailRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Thumbnail::class))
            ->willReturnCallback(function (Thumbnail $thumbnail) {
                $thumbnail->setId(123);
                $this->assertEquals('imagePath', $thumbnail->getImagePath()->value());
                $this->assertEquals(200, $thumbnail->getWidth()->value());
                $this->assertEquals(200, $thumbnail->getHeight()->value());
                $this->assertEquals(ThumbnailDestination::FILE_SYSTEM, $thumbnail->getDestination());
            });

        $this->eventBus
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ThumbnailCreatedEvent::class))
            ->willReturn(new Envelope(new \stdClass()));

        $thumbnailId = $this->handler->__invoke($command);

        $this->assertIsInt($thumbnailId);
    }
}
