<?php

require_once('model/user.php');
require_once('model/log.php');

function register_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (user_check_register($_POST)) {
			user_register($_POST);
			write_log_user('access.log', 'User registered.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error register.');
			//echo "<p style='color:white;font-family:Calibri'>" . "Syntaxe invalide ou mauvaise confrimation de mot de passe." . "</p>";
		}
	}
	require('views/register.html');
}

function login_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (user_check_login($_POST)) {
			user_login($_POST);
			write_log_user('access.log', 'User logged.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error login.');
			//echo "<p style='color:white;font-family:Calibri'>" . "Identifiant ou mot de passe invalide." . "</p>";
		}
	}
	require('views/login.html');
}

function logout_action() {
	write_log_user('access.log', 'User logout.');
	session_destroy();
	header('Location: ?action=index');
	exit(0);
}