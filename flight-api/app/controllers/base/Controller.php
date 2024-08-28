<?php

namespace api\controllers\base;

use Flight;
use flight\Engine;
use flight\net\Router;

class Controller
{
    protected Router $route;
    protected Engine $app;

    public function __construct()
    {
        $this->route = Flight::get('_router');
        $this->app = Flight::get('_app');
    }
}
