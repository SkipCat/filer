<?php

/*
$dbh = null;

function connect_to_db() {
	global $db_config;
	$dsn = 'mysql:host=' . $db_config['host'] . ';dbname=' . $db_config['name'];
	$user = $db_config['user'];
	$password = $db_config['password'];

	try {
		$dbh = new PDO($dsn, $user, $password);
	}
	catch (PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMesssage();
	}
}
function get_dbh() {
	global $dbh;
	if ($dbh === null) {
		$dbh = connect_to_db();
	}
	return $dbh;
}
*/

// USERS

function insert_user($username, $email, $password) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	//$dbh = get_dbh();

	$request = "INSERT INTO `users`(`username`, `email`, `password`) VALUES (:username, :email, :password);";
	$statement = $dbh->prepare($request);
    $statement->execute([
    	'username' => $username,
        'email' => $email,
        'password' => $password,
    ]);
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


// FILES

function get_all_files($session_id) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT * FROM files WHERE id_users = :id_users";
	$statement = $dbh->prepare($request);
	$statement->execute(['id_users' => $session_id]);
	$result = $statement->fetchAll();

	return $result;
}

function get_one_file($filename) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT * FROM files WHERE filename = :filename";
	$statement = $dbh->prepare($request);
	$statement->execute(['filename' => $filename]);
	$result = $statement->fetchAll();

	return $result;
}

function get_files_id_folders($filename) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT id_folders FROM files WHERE filename = :filename";
	$statement = $dbh->prepare($request);
	$statement->execute(['filename' => $filename]);
	$result = $statement->fetch();
	$id_folder = $result[0];

	return $id_folder;
}

function check_session_id($filename) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT id_users FROM files WHERE filename = :filename";
	$statement = $dbh->prepare($request);
	$statement->execute(['filename' => $filename]);
	$result = $statement->fetch();
	$result = $result[0];

	return $result;
}

function insert_file($session_id, $filename, $extension, $filepath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "INSERT INTO `files`(`filename`, `extension`, `filepath`, `id_users`, `id_folders`) VALUES (:filename, :extension, :filepath, :id_users, :id_folders);";
	$statement = $dbh->prepare($request);
    $statement->execute(['filename' => $filename, 'extension' => $extension, 'filepath' => $filepath, 'id_users' => $session_id, 'id_folders' => NULL]);
}

function update_file($filename, $newname, $newpath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	//$dbh = get_dbh();

	$request = "UPDATE files SET filename = :newname, filepath = :newpath WHERE filename = :filename";
    $statement = $dbh->prepare($request);
    $statement->execute(['newname' => $newname, 'newpath' => $newpath, 'filename' => $filename]);
}

function move_file($id_folders, $filename, $newpath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "UPDATE files SET id_folders = :id_folders, filepath = :newpath WHERE filename = :filename";
    $statement = $dbh->prepare($request);
    $statement->execute(['id_folders' => $id_folders, 'newpath' => $newpath, 'filename' => $filename]);
}

function delete_file($filename) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "DELETE FROM files WHERE filename = :filename";
	$statement = $dbh->prepare($request);
	$statement->execute(['filename' => $filename]);
}


// FOLDERS

function get_all_folders($session_id) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT * FROM folders WHERE id_users = :id_users";
	$statement = $dbh->prepare($request);
	$statement->execute(['id_users' => $session_id]);
	$result = $statement->fetchAll();

	return $result;
}

function get_one_folder($foldername) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT * FROM folders WHERE foldername = :foldername";
	$statement = $dbh->prepare($request);
	$statement->execute(['foldername' => $foldername]);
	$result = $statement->fetchAll();

	return $result;
}

function check_files_inside_folder($foldername) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT * FROM files INNER JOIN folders ON 'files.id_folders' = 'folders.id' WHERE foldername = :foldername";
	$statement = $dbh->prepare($request);
	$statement->execute(['foldername' => $foldername]);
	$result = $statement->fetchAll();
	var_dump($result);
	return $result;
}

/*
function check_folders_inside_folder($foldername) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT * FROM folders INNER JOIN folders ON files.id_folders = folders.id WHERE foldername = :foldername";
	$statement = $dbh->prepare($request);
	$statement->execute(['foldername' => $foldername]);
	$result = $statement->fetchAll();

	return $result;
}
*/

function get_folderpath_by_name($foldername) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT folderpath FROM folders WHERE foldername = :foldername";
	$statement = $dbh->prepare($request);
	$statement->execute(['foldername' => $foldername]);
	$result = $statement->fetch();
	$folderpath = $result[0];

	return $folderpath;
}

function get_folderpath($id_folders) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT folderpath FROM folders WHERE id = :id";
	$statement = $dbh->prepare($request);
	$statement->execute(['id' => $id_folders]);
	$result = $statement->fetch();
	$folderpath = $result[0];

	return $folderpath;
}

function get_foldername($id) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT foldername FROM folders WHERE id = :id";
	$statement = $dbh->prepare($request);
	$statement->execute(['id' => $id]);
	$result = $statement->fetch();
	$foldername = $result[0];

	return $foldername;
}

function get_folders_id_folders($foldername) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT id_folders FROM folders WHERE foldername = :foldername";
	$statement = $dbh->prepare($request);
	$statement->execute(['foldername' => $foldername]);
	$result = $statement->fetch();
	$id_folder = $result[0];

	return $id_folder;
}

function check_session_id_folder($foldername) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "SELECT id_users FROM folders WHERE foldername = :foldername";
	$statement = $dbh->prepare($request);
	$statement->execute(['foldername' => $foldername]);
	$result = $statement->fetch();
	$id_folder = $result[0];

	return $id_folder;
}

function insert_folder($session_id, $foldername, $folderpath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "INSERT INTO `folders`(`id_users`, `foldername`, `folderpath`, `id_folders`) VALUES (:id_users, :foldername, :folderpath, :id_folders);";
	$statement = $dbh->prepare($request);
    $statement->execute(['id_users' => $session_id, 'foldername' => $foldername, 'folderpath' => $folderpath, 'id_folders' => NULL]);
}

function update_folderpath($foldername, $newpath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "UPDATE folders SET folderpath = :newpath WHERE foldername = :foldername";
    $statement = $dbh->prepare($request);
    $statement->execute(['foldername' => $foldername, 'newpath' => $newpath]);
}

function update_folder($foldername, $newname) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "UPDATE folders SET foldername = :newname WHERE foldername = :foldername";
    $statement = $dbh->prepare($request);
    $statement->execute(['newname' => $newname, 'foldername' => $foldername]);
}

function move_folder($id_folders, $foldername, $newpath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "UPDATE folders SET id_folders = :id_folders, folderpath = :newpath WHERE foldername = :foldername";
    $statement = $dbh->prepare($request);
    $statement->execute(['newpath' => $newpath, 'foldername' => $foldername, 'id_folders' => $id_folders]);
}

function delete_folder($folderpath) {
	$dbh = new PDO('mysql:host=localhost;dbname=filer', 'root', '');
	// $dbh = get_database();

	$request = "DELETE FROM folders WHERE folderpath = :folderpath";
	$statement = $dbh->prepare($request);
	$statement->execute(['folderpath' => $folderpath]);
}