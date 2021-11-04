<?php

namespace Vio\Matchstick;

use Illuminate\Support\Facades\Facade;
use Vio\Matchstick\Components\Config;
use Vio\Matchstick\Components\Database;
use Vio\Matchstick\Components\Gate;
use Vio\Matchstick\Components\Queue;
use Vio\Matchstick\Components\View;

class Matchstick
{
    public static function setConfigDir($dir)
    {
        return Config::$dir = $dir;
    }

    public static function init()
    {
        $app = App::getInstance();
        Facade::setFacadeApplication($app);

        Database::bootstrap();
        Gate::bootstrap();
        Config::bootstrap();
        View::bootstrap();
        Queue::bootstrap();

        return true;
    }

    public static function strike()
    {
        return static::init();
    }
}