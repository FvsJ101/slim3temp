<?php

use App\Middleware\ValidationErrorsMiddleware AS ValidationErrors;
use App\Middleware\FlashMessageMiddleware AS FlashMessage;
use App\Middleware\CsrfViewMiddleware AS Csrf;

use App\Middleware\BreadCrumbs AS BreadCrumbs;
use App\Middleware\UserAuthMiddleware AS UserAuthMiddleware;
use App\Middleware\OldInputMiddleware AS OldInPut;

//////////MIDDLEWARE SECTION/////////////////
//VALIDATION OF ERRORS
$app->add(new ValidationErrors($container));

//FLASH MESSAGE
$app->add(new FlashMessage($container));

//CUSTOM MIDDLEWARE FOR THE CSRF
$app->add(new Csrf($container));

//TURN ON THE CSRF
$app->add($container->csrf);

//CUSTOM MIDDLEWARE FOR THE USER AUTHENTICATED
$app->add(new UserAuthMiddleware($container));

//BREADCRUMBS
$app->add(new BreadCrumbs($container));

//FLASH MESSAGE
$app->add(new FlashMessage($container));

//PASSES THE OLD FROM DATA BACK TO THE FORM FOR SIGNUP / REGISTER PAGE
$app->add(new OldInPut($container));