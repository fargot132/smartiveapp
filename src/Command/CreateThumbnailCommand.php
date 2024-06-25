<?php

namespace TomaszBartusiakRekrutacjaSmartiveapp\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomaszBartusiakRekrutacjaSmartiveapp\Dto\CreateThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\CreateThumbnailService;

#[AsCommand(
    name: 'create-thumbnail',
    description: 'Add a short description for your command',
)]
class CreateThumbnailCommand extends Command
{
    public function __construct(private CreateThumbnailService $createThumbnailService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('imagePath', InputArgument::REQUIRED, 'Source image path')
            ->addArgument('thumbnailDestination',InputArgument::REQUIRED, 'Thumbnail destination path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $imagePath = $input->getArgument('imagePath');
        $thumbnailDestination = $input->getArgument('thumbnailDestination');

        $createThumbnailDto = new CreateThumbnailDto($imagePath, 200, 200);
        $thumbnailPath = $this->createThumbnailService->create($createThumbnailDto);

        // copy thumbnail to destination
        copy($thumbnailPath, $thumbnailDestination);

        $io->success('Thumbnail created at: ' . $thumbnailPath);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
