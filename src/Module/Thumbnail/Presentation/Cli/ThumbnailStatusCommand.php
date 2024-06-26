<?php

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Presentation\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Infrastructure\MessageBus\CommandBus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Shared\Infrastructure\MessageBus\QueryBus;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Command\CreateThumbnailCommand;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Application\Query\GetThumbnailQuery;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Entity\Thumbnail;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Domain\Enum\ThumbnailStatus;

#[AsCommand(
    name: 'thumbnail:status',
    description: 'Add a short description for your command',
)]
class ThumbnailStatusCommand extends Command
{
    public function __construct(
        private QueryBus $queryBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Thumbnail id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');

        /** @var Thumbnail|null $thumbnail */
        $thumbnail = $this->queryBus->query(new GetThumbnailQuery($id));

        if ($thumbnail === null) {
            $io->error('Thumbnail not found');

            return Command::FAILURE;
        }

        switch ($thumbnail->getStatus()) {
            case ThumbnailStatus::CREATED:
                $io->warning('Thumbnail status: CREATED');
                $io->warning('Thumbnail path: ' . $thumbnail->getThumbnailPath()?->value());
                break;
            case ThumbnailStatus::FAILED:
                $io->error('Thumbnail status: FAILED');
                $io->error('Error message: ' . $thumbnail->getErrorMessage()?->value());
                break;
            case ThumbnailStatus::QUEUED:
                $io->warning('Thumbnail status: QUEUED');
                break;
            case ThumbnailStatus::UPLOADED:
                $io->success('Thumbnail status: UPLOADED');
                break;
        }

        return Command::SUCCESS;
    }
}
