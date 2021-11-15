<?php

namespace Matchstick\Components;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Matchstick\App;

class Translation
{
    public static function bootstrap()
    {
        $app = App::getInstance();

        $loader = new FileLoader(new Filesystem(), './lang');
        $transEnglish = new Translator($loader, "en");

        $app->singleton('translator', function () use ($transEnglish) {
            return $transEnglish;
        });
    }
}
