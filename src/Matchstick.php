<?php

namespace Matchstick;

use Illuminate\Support\Facades\Facade;
use Matchstick\Components\Config;
use Matchstick\Components\Database;
use Matchstick\Components\Gate;
use Matchstick\Components\Queue;
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
            'config_dir' => null
        ];
        $config += $defaults;

        static::setConfigDir($config['config_dir']);

        $app = App::getInstance();
        Facade::setFacadeApplication($app);

        Database::bootstrap();
        Gate::bootstrap();
        Config::bootstrap();
        View::bootstrap();
        Queue::bootstrap();

        return true;
    }
}
