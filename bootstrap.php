<?php
date_default_timezone_set('Asia/Shanghai');
require __DIR__.'/vendor/autoload.php';


/*
 *Syfony Config
 *
*/
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;

$config = Yaml::parse(file_get_contents(__DIR__.'/config.yml'));


//Eloquent ORM
require __DIR__.'/database.php';


$app = new \Slim\Slim(array(
	'debug' => $config['debug'],
	'development' => $config['development'],
	'cookies.path' => __DIR__.'/storage/cookies',
	'cookies.domain' => $config['domain'],
	'templates.path' => __DIR__.'/templates',
	'cookies.encrypt' => true,
	'cookies.secret_key' => $config['secret_key'],
));