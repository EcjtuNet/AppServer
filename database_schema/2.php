<?php
use Illuminate\Database\Capsule\Manager as Capsule;
require '../bootstrap.php';
	Capsule::Schema()->table('articles',function($table){
		$table->dropColumn('content');
	});

	Capsule::Schema()->table('articles',function($table){
		$table->text('content');
	});