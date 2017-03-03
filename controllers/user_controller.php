<?php

require_once('model/user.php');
require_once('model/log.php');

function register_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (user_check_register($_POST)) {
			user_register($_POST);
			write_log('access.log', 'User registered.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error register.');
		}
	}
	require('views/register.html');
}

function login_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (user_check_login($_POST)) {
			user_login($_POST);
			write_log('access.log', 'User logged.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error login.');
		}
	}
	require('views/login.html');
}

function logout_action() {
	session_destroy();
	write_log('access.log', 'User logout.');
	header('Location: ?action=index');
	exit(0);
}