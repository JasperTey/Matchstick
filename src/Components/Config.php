<?php

namespace Matchstick\Components;

use Illuminate\Config\Repository;
use Matchstick\App;
use Matchstick\Components\Config as ComponentsConfig;

class Config
{
    public static $dir = null;
    public static $repository = null;

    public static function bootstrap()
    {
        $app = App::getInstance();

        /**
         * Discover config files inside the base config dir
         */

        $tree = [];

        if (is_dir(static::$dir)) {
            $pattern = static::$dir . "/*.php";
            foreach (glob($pattern) as $file) {
                $parts = pathinfo($file);
                $name = $parts['filename'];
                $tree[$name] = require $file;
            }
        }

        $repo = new Repository($tree);
        static::$repository = $repo;

        class_alias(Illuminate\Support\Facades\Config::class, 'Config');

        // not sure about this yet
        $app->singleton('config', function () use ($repo) {
            return $repo;
        });
    }
}
