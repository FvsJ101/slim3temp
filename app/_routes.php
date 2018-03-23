<?php

//INDEX HOME
$app->get('/', 'HomeController:index')->setName('home');

//CONTACT
$app->get('/contact', 'ContactController:getContact')->setName('contact');
$app->post('/contact', 'ContactController:postContact');