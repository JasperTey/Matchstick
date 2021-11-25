<?php

namespace Matchstick\Components;

use Matchstick\App;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

class Filesystem
{
    public static function bootstrap()
    {
        $app = App::getInstance();
        $manager = new FilesystemManager($app);

        $app->singleton('filesystem', function () use ($manager) {
            return $manager;
        });

        $app->bind(FilesystemFactory::class, function () use ($manager) {
            return $manager;
        });
    }
}
