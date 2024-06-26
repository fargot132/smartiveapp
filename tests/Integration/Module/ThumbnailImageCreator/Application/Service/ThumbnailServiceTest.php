<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Tests\Integration\Module\ThumbnailImageCreator\Application\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Dto\ThumbnailDto;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Enum\ImageResizeMode;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Application\Service\ThumbnailService;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Infrastructure\Adapter\Glide\GlideAdapter;
use TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Infrastructure\Adapter\Glide\GlideServerFactory;

class ThumbnailServiceTest extends KernelTestCase
{
    private ThumbnailService $thumbnailService;

    /**
     * @return array<string, array{thumbnailDto: ThumbnailDto, thumbnailFile: string}>
     */
    public function provideCreateThumbnail(): array
    {
        return [
            'test_image_1.jpg' => [
                'thumbnailDto' => new ThumbnailDto(
                    'test_image_1.jpg',
                    100,
                    100,
                    ImageResizeMode::CROP
                ),
                'thumbnailFile' => 'test_thumbnail_1.jpg',
            ],
            'test_image_2.png' => [
                'thumbnailDto' => new ThumbnailDto(
                    'test_image_2.png',
                    200,
                    200,
                    ImageResizeMode::FIT
                ),
                'thumbnailFile' => 'test_thumbnail_2.png',
            ],
        ];
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $glideServerFactory = $container->get(GlideServerFactory::class);
        $sourceImageDirectory = __DIR__ . '/TestData';
        $cacheDirectory = $container->getParameter('kernel.project_dir') . '/var/cache/test/glide';

        $this->removeDirectory($cacheDirectory);
        $glideAdapter = new GlideAdapter($glideServerFactory, $sourceImageDirectory, $cacheDirectory);
        $this->thumbnailService = new ThumbnailService($glideAdapter);
    }

    /**
     * @dataProvider provideCreateThumbnail
     */
    public function testCreateThumbnail(ThumbnailDto $dto, string $thumbnailFile): void
    {
        $thumbnailPath = $this->thumbnailService->create($dto);
        $this->assertStringContainsString('var/cache/test/glide/', $thumbnailPath);
        $this->assertFileExists($thumbnailPath);
        $this->assertFileEquals(__DIR__ . '/TestData/' . $thumbnailFile, $thumbnailPath);
    }

    /**
     * @param string $cacheDirectory
     * @return void
     */
    private function removeDirectory(string $cacheDirectory): void
    {
        if (file_exists($cacheDirectory)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($cacheDirectory, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($cacheDirectory);
        }
    }
}
