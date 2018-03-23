<?php

use Illuminate\Database\Capsule\Manager AS Capsule;

$config = $container['config'];

$capsule = New Capsule();

$capsule->addConnection($config->get('db'));

$capsule->setAsGlobal();

$capsule->bootEloquent();

