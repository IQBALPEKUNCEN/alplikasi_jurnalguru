<?php

namespace api\middleware\base;

use Flight;
use flight\Engine;

class Middleware
{
    protected Engine $app;

    public function __construct()
    {
        $this->app = Flight::get('_app');
    }
}
