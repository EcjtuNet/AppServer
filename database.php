<?php

/*
 *Boot EloquentORM
 *
*/
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$conn = $config['connection'];

$capsule->addConnection([
    'driver'    => $conn,
    'host'      => $config['connections'][$conn]['host'],
    'database'  => $config['connection']=='sqlite' ? 
    	__DIR__.$config['connections'][$conn]['database'] : $config['connections'][$conn]['database'],
    'username'  => $config['connections'][$conn]['username'],
    'password'  => $config['connections'][$conn]['password'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();