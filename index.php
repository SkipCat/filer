<?php

session_start();

require('config/config.php');

if (empty($_GET['action'])) {
    $action = 'index'; // redirection to first page
}
else {
	$action = $_GET['action']; // ??
}

if (isset($routes[$action])) {
	require 'controllers/' . $routes[$action] . '_controller.php'; // includes controller linked to the action (link in config.php)
	call_user_func($action . '_action'); // calls a function without name (function in the linked controller file)
}
else {
	die('Illegal route');
}