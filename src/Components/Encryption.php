<?php

namespace Matchstick\Components;

use Illuminate\Encryption\Encrypter;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Matchstick\App;

class Encryption
{
    public static function bootstrap()
    {
        $app = App::getInstance();

        $key = config('ENCRYPTION_KEY', Str::random(16));
        $encrypter = new Encrypter($key);

        $app->singleton('encrypter', function () use ($encrypter) {
            return $encrypter;
        });
    }
}
