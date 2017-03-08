<?php 

require_once('model/db.php'); 

function user_check_register($data) {
	if (empty($data['username'])
		OR empty($data['email'])
		OR empty($data['password'])
		OR empty($data['confirm-password'])
		OR $data['password'] !== $data['confirm-password']) {
			return false;
	}
	return true;
}

function user_register($data) {
	insert_user($data['username'], $data['email'], $data['password']);
	$_SESSION['id'] = get_session_id($data['username']);
	$_SESSION['username'] = $data['username'];
	mkdir('uploads/' . $_SESSION['username']);
}

function user_check_login($data) {
	if (empty($data['username']) OR empty($data['password'])) {
		return false;
	}
	else {
		$result = get_password($data['username']);

		if ($data['password'] !== $result[0]) {
			return false;
		}
	}
	return true;
}

function user_login($data) {
	$_SESSION['id'] = get_session_id($data['username']);
	$_SESSION['username'] = $data['username'];
}