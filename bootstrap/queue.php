<?php

use Illuminate\Database\ConnectionResolver;
use Illuminate\Events\Dispatcher;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Queue\Capsule\Manager as Queue;
use Matchstick\App;

$container = App::getInstance();

// Not sure if this will screw up legacy apps not on UTC
//date_default_timezone_set('UTC');

(new EventServiceProvider($container))->register();

$container->instance('Illuminate\Contracts\Events\Dispatcher', new Dispatcher($container));

$container->bind('exception.handler', ExceptionHandler::class);

$queue = new Queue($container);

$queue->addConnection([
    'driver' => 'sync',
]);

$resolver = new ConnectionResolver();
$conn = $resolver->getDefaultConnection();

pd($conn);

$queue->addConnection($conn, 'database');

$container['queue'] = $queue->getQueueManager();