<?php
use Illuminate\Database\Capsule\Manager as Capsule;
require '../bootstrap.php';
	Capsule::Schema()->drop('feedbook');
	Capsule::Schema()->table('articles',function($table){
		$table->string('content',6000)->change();
	});