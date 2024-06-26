<?php

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\Thumbnail\Presentation\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Dto\ThumbnailUploadDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Enum\ThumbnailDestination;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageFileSystemException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Exception\SourceImageNotFoundException;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\ThumbnailService;
use TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\ThumbnailUploaderInterface;

#[AsCommand(
    name: 'thumbnail:create',
    description: 'Add a short description for your command',
)]
class ThumbnailCreateCommand extends Command
{
    public function __construct(
        private ThumbnailService $createThumbnailService,
        private ThumbnailUploaderInterface $thumbnailUploader
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

        $createThumbnailDto = new ThumbnailDto($imageFileName, 200, 200);
        try {
            $thumbnailPath = $this->createThumbnailService->create($createThumbnailDto);
        } catch (SourceImageNotFoundException|SourceImageFileSystemException $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        try {
            $this->thumbnailUploader->upload(
                new ThumbnailUploadDto($thumbnailPath, $imageFileName, $destination)
            );
        } catch (\Exception $e) {
            $io->error('Failed to upload thumbnail: ' . $e->getMessage());

            return Command::FAILURE;
        }

        $io->success('Thumbnail created and uploaded successfully');

        return Command::SUCCESS;
    }
}
