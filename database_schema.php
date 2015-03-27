<?php
use Illuminate\Database\Capsule\Manager as Capsule;
require __DIR__.'/bootstrap.php';

Capsule::schema()->create('admins', function($table) {
	$table->increments('id');
	$table->string('username')->unique();
	$table->string('password');
	$table->timestamps();
});

Capsule::schema()->create('articles', function($table) {
	$table->increments('id');
	$table->string('title');
	$table->string('content');
	$table->integer('admin_id')->nullable();
	$table->integer('click')->default(0);
	$table->boolean('publish')->default(false);
	$table->dateTime('published_at')->nullable();
	$table->timestamps();
});

Capsule::schema()->create('pushes', function($table) {
	$table->increments('id');
	$table->integer('msg_id')->unique();
	$table->string('title');
	$table->string('message');
	$table->integer('article_id')->nullable();
	$table->timestamps();
});