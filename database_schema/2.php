<?php
use Illuminate\Database\Capsule\Manager as Capsule;
require '../bootstrap.php';
	Capsule::Schema()->table('articles',function($table){
		$table->string('content',2000)->change(60000);
	});