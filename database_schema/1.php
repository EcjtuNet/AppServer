<?php
use Illuminate\Database\Capsule\Manager as Capsule;
require '../bootstrap.php';

Capsule::schema()->create('feedbooks',function($table){
	$table->increments('id');
	$table->string('nikename');
	$table->string('content');
	$table->timestamps();
});