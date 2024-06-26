<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Module\ThumbnailImageCreator\Infrastructure\Adapter\Glide;

use League\Glide\Server;
use League\Glide\ServerFactory;

class GlideServerFactory
{
    public function make(string $sourceImageDirectory, string $cacheDirectory): Server
    {
        return ServerFactory::create([
            'source' => $sourceImageDirectory,
            'cache' => $cacheDirectory,
        ]);
    }
}
