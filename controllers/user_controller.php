<?php

require_once('model/user.php');

function register_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (user_check_register($_POST)) {
			user_register($_POST);
			header('Location: ?action=home');
			exit(0); // voir doc
		}
		else {

		}
	}
	require('views/register.html');
}

function login_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (user_check_login($_POST)) {
			user_login($_POST);
			header('Location: ?action=home');
			exit(0); // voir doc
		}
		else {
			
		}
	}
	require('views/login.html');
}

function logout_action() {
	session_destroy();
	header('Location: ?action=index');
}