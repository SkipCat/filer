<?php

$dbh = null; // ?

function connect_to_database() {
	global $db; // to reuse it in other functions
	$dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];
	$user = $db['user'];
	$password = $db['password'];

	try {
		$dbh = new PDO($dsn, $user, $password);
	}
	catch (PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMesssage(); // getMessage ?
	}
}

function get_database() {
	global $dbh; // to reuse it in other functions
	if ($dbh === null) {
		$dbh = connect_to_database();
	}
	return $dbh;
}

function insert_user($username, $email, $password) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "INSERT INTO `users`(`username`, `email`, `password`) VALUES (:username, :email, :password);";
	$statement = $dbh->prepare($request);
    $statement->execute([
    	'username' => $username,
        'email' => $email,
        'password' => $password,
    ]);
}

function get_session_id($username) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT id FROM users WHERE username = :username";
	$statement = $dbh->prepare($request);
	$statement->execute(['username' => $username]);
	$result = $statement->fetch();
	$session_id = $result[0];

	return $session_id;
}

function get_all_files($session_id) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT filename FROM files /*ORDER BY filename*/ WHERE id_users = :id_users";
	$statement = $dbh->prepare($request);
	$statement->execute(['id_users' => $session_id]);
	$result = $statement->fetchAll();

	return $result;
}

function check_session_id($filename) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT id_users FROM files WHERE filename = :filename";
	$statement = $dbh->prepare($request);
	$statement->execute(['filename' => $filename/*['name']*/]);
	// var_export($filename);
	$result = $statement->fetch();
	$id_files = $result[0];

	return $id_files;
}

function get_password($username) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT password FROM users WHERE username = :username";
	$statement = $dbh->prepare($request);
	$statement->execute(['username' => $username]);
	$result = $statement->fetch(); // return result in array

	return $result;
}

function insert_file($session_id, $filename, $filepath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "INSERT INTO `files`(`filename`, `filepath`, `id_users`) VALUES (:filename, :filepath, :id_users);";
	$statement = $dbh->prepare($request);
    $statement->execute(['filename' => $filename,'filepath' => $filepath, 'id_users' => $session_id]);
}

function update_file($session_id) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "UPDATE files SET filename = :newname, filepath = :newpath, id_users = :id_users WHERE filename = :filename";
    $statement = $dbh->prepare($request);
    $statement->execute(['newname' => $newname, 'newpath' => $newpath, 'filename' => $filename, 'id_users' => $session_id]);
}

function delete_file($filename) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "DELETE FROM files WHERE filename = :filename";
	$statement = $dbh->prepare($request);
	$statement->execute(['filename' => $filename]);
}