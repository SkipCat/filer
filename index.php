<?php

session_start();

require('config/config.php');
require('model/log.php');

if (empty($_GET['action'])) {
    $action = 'index'; // redirection to first page
    write_log('access.log', 'Index action.');
}
else {
	$action = $_GET['action']; // ??
	write_log('access.log', $action . 'action.');
}

if (isset($routes[$action])) {
	require 'controllers/' . $routes[$action] . '_controller.php'; // includes controller linked to the action (link in config.php)
	call_user_func($action . '_action'); // calls a function without name (function in the linked controller file)
	write_log('access.log', $action . 'action.');
}
else {
	die('Illegal route');
	write_log('security.log', 'Illegal route.');
}