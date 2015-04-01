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
	$table->string('info')->nullable();
	$table->integer('admin_id')->nullable();
	$table->integer('click')->default(0);
	$table->boolean('published')->default(false);
	$table->dateTime('published_at')->nullable();
	$table->string('thumb');
	$table->softDeletes();
	$table->timestamps();
});

Capsule::schema()->create('pushes', function($table) {
	$table->increments('id');
	$table->integer('msg_id')->unique();
	$table->string('title');
	$table->string('message');
	$table->integer('article_id')->nullable();
	$table->integer('received')->default(0);
	$table->timestamps();
});

Capsule::schema()->create('categories', function($table) {
	$table->increments('id');
	$table->string('text')->unique();
	$table->timestamps();
});

Capsule::schema()->create('article_category', function($table) {
	$table->integer('article_id');
	$table->integer('category_id');
	$table->primary(array('article_id', 'category_id'));
});

Capsule::schema()->create('settings', function($table) {
	$table->string('key');
	$table->string('value')->nullable();
	$table->timestamps();
});

Capsule::schema()->create('logs', function($table) {
	$table->increments('id');
	$table->string('type');
	$table->string('content');
	$table->timestamps();
});