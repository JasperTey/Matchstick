<?php

use Matchstick\Components\Config;
use Matchstick\Components\View;

if (!function_exists('view')) {
    function view($view = null, $data = [], $mergeData = [])
    {
        $factory = View::$factory;

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
}

if (!function_exists('config')) {
    function config(...$args)
    {
        return Config::$repository->get(...$args);
    }
}