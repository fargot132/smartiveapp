<?php

declare(strict_types=1);

namespace TomaszBartusiakRekrutacjaSmartiveapp\Service\ImageThumbnail\Glide;

use League\Glide\Server;
use League\Glide\ServerFactory;

class GlideServerFactory
{
    public const string SOURCE = 'var/uploads';
    public const string CACHE = 'var/cache/glide';
    public function make(): Server
    {
        return ServerFactory::create([
            'source' => self::SOURCE,
            'cache' => self::CACHE,
        ]);
    }
}
