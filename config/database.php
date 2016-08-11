<?php
return array(
    'driver' => env('DB_CONNECTION','mysql'),
    'host' => env('DB_HOST','localhost'),
    'database' => env('DB_DATABASE','homestead'),
    'username' => env('DB_USERNAME','homestead'),
    'password' => env('DB_PASSWORD','secret'),
    'charset' => 'utf8',
    'collation'  => 'utf8_unicode_ci',
    'prefix' => ''
);