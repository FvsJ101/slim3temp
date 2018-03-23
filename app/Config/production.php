<?php
return array(
  'app' => array(
    'url'  => 'http://localhost',
    'hash' => array(
      'algo' => PASSWORD_BCRYPT,
      'cost' => 10
    )
  ),
  
  'db' => array(
    'driver'    => '',
    'host'      => 'localhost',
    'database'  => '',
    'username'  => '',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => '',
      //'port'      => 33066
  ),
  
  'auth' => array(
    'session'  => 'user_id',
    'remember' => 'user_r'
  ),
  
  'mail' => array(
    'smtp_auth'       => true,
    'smtp_secure'     => 'tls',
    'host'            => '',
    'username'        => '',
    'password'        => '',
    'port'            => 587,
    'html'            => true,
    'sendfrom_email'  => '',
    'sendfrom_person' => ''
  ),
  
  'twig' => array(
    'debug' => false,
  ),
  
  'csrf' => array(
    'key' => 'csrf_token'
  ),
  
  'mailchimp' => array(
    'api_key'     => '',
    'web_listing' => ''
  )
);
