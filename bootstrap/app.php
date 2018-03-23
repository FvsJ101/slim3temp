<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";


//BASE SETTINGS
$app = new \Slim\App(array(
  'settings' => array(
    'displayErrorDetails'               => true,
    'determineRouteBeforeAppMiddleware' => true,
    'mode'                              => 'development'
  )
));

//CONTAINER
require __DIR__ . "/../app/_container.php";

//MIDDLEWARE
require __DIR__ . "/../app/_middleware.php";

//ROUTES
require __DIR__ . "/../app/_routes.php";