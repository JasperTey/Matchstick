<?php

namespace Vio\Matchstick\Components;

use Illuminate\Auth\Access\Gate as AccessGate;
use lithium\security\Auth;
use Vio\Matchstick\App;

class Gate
{
    public static $dir = null;
    public static $repository = null;

    public static function bootstrap()
    {
        $app = App::getInstance();

        $app->singleton('Illuminate\Contracts\Auth\Access\Gate', function ($app) {
            return new AccessGate(
                $app,
                // User Resolver
                function () {
                    $user = Auth::check('user');
                    return $user;
                }
            );
        });
    }
}
