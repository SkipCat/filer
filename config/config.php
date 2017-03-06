<?php 

$routes = [ // list of actions
	'index' 		=> 'default',
	'home' 			=> 'default',
	'login' 		=> 'user',
	'register' 		=> 'user',
	'logout'		=> 'user',
	'upload'		=> 'file',
	'delete'		=> 'file',
	'rename'		=> 'file',
	'replace'		=> 'file',
	'modify'		=> 'file',
	'move'			=> 'file',
	'create_folder' => 'folder',
	'delete_folder'	=> 'folder',
	'rename_folder' => 'folder',
	'move_folder'	=> 'folder',
];

$db = [ // db access
	'name' 		=> 'filer',
	'host' 		=> 'localhost',
	'user' 		=> 'root',
	'password' 	=> '',
];