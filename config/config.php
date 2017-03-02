<?php 

$routes = [ // list of actions
	'index' 	=> 'default',
	'home' 		=> 'default',
	'login' 	=> 'user',
	'register' 	=> 'user',
	'logout'	=> 'user',
	'upload'	=> 'file',
	'delete'	=> 'file',
	'rename'	=> 'file',
	'replace'	=> 'file',
];

$db = [ // db access
	'name' => 'filer',
	'host' => 'localhost',
	'user' => 'root',
	'password' => '',
];