<?php
use Illuminate\Database\Capsule\Manager as Capsule;
require '../bootstrap.php';
	Capsule::Schema()->rename('feedbook', 'feedbooks');