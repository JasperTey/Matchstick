<?php

namespace Matchstick\Components;

use Matchstick\App;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Events\Dispatcher;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Queue\Capsule\Manager as QueueManager;
use Illuminate\Support\Facades\DB;

class Queue
{
    public static function bootstrap()
    {
        $container = App::getInstance();

        (new EventServiceProvider($container))->register();

        $container->instance('Illuminate\Contracts\Events\Dispatcher', new Dispatcher($container));

        $container->bind('exception.handler', ExceptionHandler::class);

        $queue = new QueueManager($container);

        $queue->addConnection([
            'driver' => 'sync',
        ]);

        $conn = DB::connection();
        $config = $conn->getConfig();
        
        $queue->addConnection([
            'driver'    => 'database',
            'table'     => 'jobs', // Required for database connection
            'connection' => 'default',
            'host'      => data_get($config, 'host', null),
            'queue' => 'default',
        ], 'database');

        $container['queue'] = $queue->getQueueManager();
    }
}
