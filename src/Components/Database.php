<?php

namespace Vio\Matchstick\Components;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Vio\Matchstick\App;

class Database
{

    public static function bootstrap()
    {
        $app = App::getInstance();

        // Database information
        $settings = [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'collation' => 'utf8_general_ci',
            'prefix' => getenv('DB_PREFIX') ?: '',
        ];

        // Bootstrap Eloquent ORM
        $connFactory = new ConnectionFactory($app);
        $conn = $connFactory->make($settings);
        $resolver = new ConnectionResolver();
        $resolver->addConnection('default', $conn);
        $resolver->setDefaultConnection('default');

        Model::setConnectionResolver($resolver);
        Model::setEventDispatcher(new Dispatcher($app));

        class_alias(DB::class, 'DB');

        $app->singleton('db', function () use ($settings) {
            $capsule = new Manager();
            $capsule->addConnection($settings);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            return $capsule;
        });
    }
}
