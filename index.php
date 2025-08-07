<?php

// // comment out the following two lines when deployed to production
// defined('YII_DEBUG') or define('YII_DEBUG', false);
// defined('YII_ENV') or define('YII_ENV', 'dev');

// require __DIR__ . '/vendor/autoload.php';
// require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

// $config = require __DIR__ . '/app/config/web.php';

// (new yii\web\Application($config))->run();


// Aktifkan mode debug dan mode development
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// Autoload Composer dan Yii
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

// Load konfigurasi aplikasi
$config = require __DIR__ . '/app/config/web.php';

// Jalankan aplikasi
(new yii\web\Application($config))->run();
