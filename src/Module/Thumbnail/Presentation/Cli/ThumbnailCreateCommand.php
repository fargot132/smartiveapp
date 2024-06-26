<?php

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Presentation\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Infrastructure\MessageBus\CommandBus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\CreateThumbnailCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;

#[AsCommand(
    name: 'thumbnail:create',
    description: 'Add a short description for your command',
)]
class ThumbnailCreateCommand extends Command
{
    public function __construct(
        private CommandBus $commandBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('imageFileName', InputArgument::REQUIRED, 'Source image file name')
            ->addArgument('thumbnailDestination', InputArgument::REQUIRED, 'Thumbnail destination file_system|sftp');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $imageFileName = $input->getArgument('imageFileName');
        $thumbnailDestination = $input->getArgument('thumbnailDestination');

        $destination = ThumbnailDestination::tryFrom($thumbnailDestination);
        if (null === $destination) {
            $io->error('Invalid thumbnail destination: ' . $thumbnailDestination);

            return Command::FAILURE;
        }

        $id = $this->commandBus->command(new CreateThumbnailCommand($imageFileName, 150, 150, $destination));

        $io->title('Thumbnail queued for creation');
        $io->success('Thumbnail id: ' . $id);

        return Command::SUCCESS;
    }
}
