<?php
/*
 * This is the file called bootstrap who's job is to make sure that all the
 * required services, plugins, connections, etc. are loaded and ready to go
 * for every request made to the application.
 */
// $ds = DIRECTORY_SEPARATOR;
require '../vendor/autoload.php';

/* 
 * It is better practice to not use static methods for everything. It makes your
 * app much more difficult to unit test easily.
 * This is important as it connects any static calls to the same $app object 
 */
$app = Flight::app();

// agar bisa diakses disemua class tanpa passing parameter via constructor (DI)
Flight::set('_app', $app);

/*
 * Load the config file
 * P.S. When you require a php file and that file returns an array, the array
 * will be returned by the require statement where you can assign it to a var.
 */
require 'app/config/config.php';

/*
 * Load the services file.
 * A "service" is basically something special that you want to use in your app.
 * For instance, need a database connection? You can set up a database service.
 * Need caching? You can setup a Redis service
 * Need to send email? You can setup a mailgun/sendgrid/whatever service to send emails.
 * Need to send SMS? You can setup a Twilio service.
 */
require 'app/config/services.php';

// Whip out the ol' router and we'll pass that to the routes file
$router = $app->router();

// agar bisa diakses disemua class tanpa passing parameter via constructor (DI)
Flight::set('_router', $router);

/*
 * Load the routes file. the $router variable above is passed into the api.php
 * file below so that you can define routes in that file.
 */
require 'app/routes/api.php';

// return untuk dilakukan start pada index.php di folder public
return $app;
