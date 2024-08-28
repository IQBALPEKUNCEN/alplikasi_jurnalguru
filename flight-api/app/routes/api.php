<?php

use api\controllers\AuthController;
use api\middleware\JwtMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->get('/', function () use ($app) {
    // $result = Pegawai::find()->asArray()->all();

    // return $app->json($result);
    return $app->json([
        "message" => "bismillah"
    ]);
});

$router->group('/auth', function () {
    $authController = new AuthController();
    $authController->_register();
});
