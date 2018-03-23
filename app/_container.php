<?php

use Slim\Flash\Messages AS Flash;
use App\Mail\Mailer AS Mailer;
use App\Validation\Validator AS Validator;
use Noodlehaus\Config AS Config;

use Slim\Csrf\Guard AS Guard;
use RandomLib\Factory AS RandomLib;

//CONTAINER
$container = $app->getContainer();

//CONFIG
$container['config'] = function ($container) {
    
    $config = new Config(__DIR__ . '/../app/Config/' . $container->get('settings')['mode'] . '.php');
    
    return $config;
};

//ATTACH TWIG VIEWS
$container['view'] = function ($container) {
    
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', array(
      'cache' => false
    ));
    
    $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));
    
    return $view;
};

//DATABASE SETUP
require __DIR__ . "/../app/DB/database.php";

$container['db'] = function ($container) use ($capsule) {
    
    return $capsule;
};

//MAILER
$container['mailer'] = function ($container) {
    
    $config = $container->get('config');
    
    $mailer = new PHPMailer;
    
    $mailer->Host = $config->get('mail.host');
    $mailer->SMTPAuth = $config->get('mail.smtp_auth');
    $mailer->SMTPSecure = $config->get('mail.smtp_secure');
    $mailer->Port = $config->get('mail.port');
    $mailer->Username = $config->get('mail.username');
    $mailer->Password = $config->get('mail.password');
    
    $mailer->isHTML($config->get('mail.html'));
    $mailer->SetFrom($config->get('mail.sendfrom_email'), $config->get('mail.sendfrom_person'));
    
    return new Mailer($container->view, $mailer);
};

//SLIM CSRF PROTECTION
$container['csrf'] = function ($container) {
    
    return new Guard();
};

//VALIDATOR
$container['validator'] = function ($container) {
    
    return new Validator($container);
};

//FLASH MESSAGE SECTION
$container['flash'] = function ($container) {
    
    return new Flash();
};

//RANDOMLIB HASH GENERATOR
$container['randomlib'] = function ($container) {
    
    $factory = new RandomLib();
    
    return $factory->getMediumStrengthGenerator();
};

//ATTACHE HOME CONTROLLER
$container['HomeController'] = function ($container) {
    
    return new App\Controllers\HomeController($container);
};

//ATTACHE CONTACT CONTROLLER
$container['ContactController'] = function ($container) {
    
    return new App\Controllers\ContactController($container);
};

