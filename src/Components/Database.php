<?php

namespace Matchstick\Components;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Matchstick\App;

class Database
{

    public static function bootstrap()
    {
        $app = App::getInstance();

        // Database information
        $settings = [
            'driver' => env('DB_DRIVER', 'mysql'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'collation' => env('DB_COLLATION', 'utf8_general_ci'),
            'prefix' => env('DB_PREFIX', ''),
        ];

        // Bootstrap Eloquent ORM
        $connFactory = new ConnectionFactory($app);
        $conn = $connFactory->make($settings);
        $resolver = new ConnectionResolver();
        $resolver->addConnection('default', $conn);
        $resolver->setDefaultConnection('default');

        Model::setConnectionResolver($resolver);
        Model::setEventDispatcher(new Dispatcher($app));

        //class_alias(Manager::class, 'DB');

        $app->singleton('db', function () use ($settings) {
            $capsule = new Manager();
            $capsule->addConnection($settings);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            return $capsule;
        });
    }
}
