<?php

session_start();

require('config/config.php');

// redirection to home page or another one
if (empty($_GET['action'])) {
    $action = 'index'; 
}
else {
	$action = $_GET['action']; // searchs action
}

// redirection to another page
if (isset($routes[$action])) {
	require 'controllers/' . $routes[$action] . '_controller.php'; // includes the controller file linked to the page (link defined in config.php)
	call_user_func($action . '_action'); // calls a function without name (function in the linked controller file)
}
else {
	die('Illegal route');
}