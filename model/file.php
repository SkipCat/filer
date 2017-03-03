<?php

require_once('model/db.php');
require_once('model/user.php'); 

function file_check_upload($data) {
	if ($data['userfile']['error'] > 0) { // if error value > 0 (0 = no error) then show it
		return false;
	}
	return true;
}

function file_check_permission() {
	$result = get_all_files($_SESSION['id']);
	$_SESSION['id'] = get_session_id($_SESSION['username']);

	foreach ($result as $i) {
		$id_files = check_session_id($i['filename']);

		if ($_SESSION['id'] !== $id_files) {
			return false;
		}
		return true;
	}
}

function display_files() {
	$result = get_all_files($_SESSION['id']);

	foreach ($result as $i) {
		echo '<li>';
			echo '<div class="list-files">';
				echo '<p>' . $i['filename'] . '</p>';

				echo '<div class="container-rename-field">';
					echo '<form method="POST" action="?action=rename">' . '<input type="hidden" name="input-filename" value="'.$i['filename'].'">' . '<input type="text" name="filename" placeholder="Nouveau nom">' . '<input type="submit" value="Rename">' . '</form>';
				echo '</div>';

				echo '<div class="container-replace-field">';
					echo '<form method="POST" action="?action=replace" enctype="multipart/form-data">' . '<input type="hidden" name="MAX_FILE_SIZE" value="50000000">' . '<input type="hidden" name="input-filename" value="'.$i['filename'].'">' . '<input type="file" name="filename">' . '<input type="submit" value="Replace">' . '</form>';
				echo '</div>';

				echo '<div class="container-modify-field">';
					echo '<form method="POST" action="?action=modify" name="form-modify">'. '<input type="hidden" name="input-filename" value="'.$i['filename'].'" class="input-hidden">' . '<textarea name="content" placeholder="Ajouter du texte"></textarea>' . '<input type="submit" value="Modifier">' . '</form>';
				echo '</div>';

				echo '<div class="file-actions">';
					echo '<a>' . '<img src="assets/img/icon_rename.png" class="icon-rename">' . '</a>';
					echo '<a>' . '<img src="assets/img/icon_replace.png" class="icon-replace">' . '</a>';
					echo '<a>' . '<img src="assets/img/icon_modify.png" class="icon-modify">' . '</a>';
					echo '<a href="'.$i['filepath'].'" download="'.$i['filename'].'">' . '<img src="assets/img/icon_download.png">' . '</a>';
					echo '<a href="?action=delete">' . '<img src="assets/img/icon_delete.png">' . '</a>';
				echo '</div>';
			echo '</div>';
		echo '</li>';
	}
}

function file_upload($data) {
	$filename = $data['userfile']['name'];
	$filepath = 'uploads/' . $_SESSION['username'] . '/' . $filename;
	$newname = $_POST['file-rename'];
	$newpath = 'uploads/' . $_SESSION['username'] . '/' . $newname;

	if (!empty($newname)) {
		insert_file($_SESSION['id'], $newname, $newpath);
    	move_uploaded_file($data['userfile']['tmp_name'], $filepath);
	}
	else {
		insert_file($_SESSION['id'], $filename, $filepath);
    	move_uploaded_file($data['userfile']['tmp_name'], $filepath);
	}
}

function file_rename($data) {
	$filename = $data['input-filename'];
	$filepath = 'uploads/' . $_SESSION['username'] . '/' . $filename;
	$newname = $data['filename'];
	$newpath = 'uploads/' . $_SESSION['username'] . '/' . $newname;

	update_file($_SESSION['id'], $filename, $newname, $newpath);
	rename($filepath, $newpath);
}

function file_replace($data) {
	$filename = $data['input-filename'];
	$newname = $_FILES['filename']['name'];
	$newpath = 'uploads/' . $_SESSION['username'] . '/' . $newname;

	update_file($_SESSION['id'], $filename, $newname, $newpath);
	unlink('uploads/' . $_SESSION['username'] . '/' . $filename);
	move_uploaded_file($_FILES['filename']['tmp_name'], $newpath);
}

function file_delete($data) {
	$result = get_all_files($_SESSION['id']);
	foreach ($result as $i) {
		$filename = $i['filename'];
	}
	delete_file($filename);
	unlink('uploads/' . $_SESSION['username'] . '/' . $filename);
}

function file_modify($file, $data) {
	/*
    $file_to_modify = fopen('logs/' . $file, 'r+'); // opens the file in reading and writing
    //$log_info = $date . ' -> ' . $text . "\r\n";
    fwrite($file_to_modify, $text['modification']); // by POST textarea
    fgets ($file_to_modify, 255);
    fclose($file_to_modify); // closes the current opened file
    */
	$filename = $data['input-filename'];
	$filepath = 'uploads/' . $_SESSION['username'] . '/' . $filename;
	$new_content = $data['content'];

	$file = file_get_contents($filepath, $use_include_path = false, $context = null, $offset = 0, $maxlen); // filename/include_path/context/offset/maxlen
	file_put_contents($file, $new_content, FILE_APPEND | LOCK_EX); // writes content in file behind existing content with FILE_APPEND flag
}