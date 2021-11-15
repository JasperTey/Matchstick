<?php

namespace Matchstick;

use Dotenv\Dotenv;
use Illuminate\Support\Facades\Facade;
use Matchstick\Components\Config;
use Matchstick\Components\Database;
use Matchstick\Components\Encryption;
use Matchstick\Components\Gate;
use Matchstick\Components\Queue;
use Matchstick\Components\Translation;
use Matchstick\Components\View;

class Matchstick
{
    public static function setConfigDir($dir)
    {
        return Config::$dir = $dir;
    }

    public static function init($config = [])
    {
        $defaults = [
            'base_dir' => null,
            'config_dir' => null
        ];
        $config += $defaults;

        if ($config['base_dir']) {
            $dotenv = Dotenv::createImmutable($config['base_dir']);
            $dotenv->safeLoad();
        }

        static::setConfigDir($config['config_dir']);

        $app = App::getInstance();
        Facade::setFacadeApplication($app);

        Database::bootstrap();
        Gate::bootstrap();
        Config::bootstrap();
        View::bootstrap();
        Queue::bootstrap();
        Translation::bootstrap();
        Encryption::bootstrap();

        return true;
    }
}
