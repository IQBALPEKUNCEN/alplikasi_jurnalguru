<?php
// Set the default timezone
date_default_timezone_set('Asia/Jakarta');

// Set the error reporting level
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the default character encoding
if (function_exists('mb_internal_encoding') === true) {
    mb_internal_encoding('UTF-8');
}

// Set the default locale
if (function_exists('setlocale') === true) {
    setlocale(LC_ALL, 'id_ID'); //  echo strftime( "%A, %d %B %Y %H:%M", time());
}

// Set token key
define("JWTKEY", "123456");

/* 
 * Set some flight variables
 */
$app->path('./');
$app->set('flight.base_url', '/'); // if this is in a subdirectory, you'll need to change this
$app->set('flight.case_sensitive', false); // if you want case sensitive routes, set this to true
$app->set('flight.log_errors', true); // if you want to log errors, set this to true
$app->set('flight.handle_errors', false); // if you want flight to handle errors, set this to true, otherwise Tracy will handle them
$app->set('flight.views.path', 'app/views'); // set the path to your view/template/ui files
$app->set('flight.views.extension', '.php'); // set the file extension for your view/template/ui files
$app->set('flight.content_length', true); // if flight should send a content length header

/* 
 * Some configurations for starting Yii2 engine
 */
$basePath = dirname(__DIR__, 2); // jika file ini dipindah pastikan basepath-nya disesuaikan juga
define('YII_ENABLE_ERROR_HANDLER', false);

require '../vendor/yiisoft/yii2/Yii.php';
require 'app/config/YiiModelAutoloader.php';
require 'app/config/FlightAppAutoloader.php';

$config = [
    'id' => 'flight-app',
    'basePath' => $basePath,
    'components' => [
        'db' => require '../app/config/db.php'
    ],
];

new \yii\web\Application($config);
