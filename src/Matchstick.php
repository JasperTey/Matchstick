<?php

namespace Matchstick;

use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Matchstick\Components\Config;
use Matchstick\Components\Database;
use Matchstick\Components\Encryption;
use Matchstick\Components\Filesystem;
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
            'config_dir' => null,
            'userResolver' => null,
        ];
        $config += $defaults;

        if ($config['base_dir']) {
            $dotenv = Dotenv::createImmutable($config['base_dir']);
            $dotenv->safeLoad();
        }

        static::setConfigDir($config['config_dir']);

        $app = App::getInstance();
        Facade::setFacadeApplication($app);

        $request = Request::capture();
        $request->setUserResolver($config['userResolver']);

        $app->instance('Illuminate\Http\Request', $request);

        $app->singleton('request', function () use ($request) {
            return $request;
        });

        Database::bootstrap();
        Gate::bootstrap();
        Config::bootstrap();
        Filesystem::bootstrap();
        View::bootstrap();
        Queue::bootstrap();
        Translation::bootstrap();
        Encryption::bootstrap();

        return true;
    }
}
