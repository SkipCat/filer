<?php

require_once('model/db.php');
require_once('model/user.php'); 

function file_check_upload($data) {
	if ($data['userfile']['error'] > 0) { // if error value > 0 (0 = no error) then show it
		return false;
	}
	return true;
}

function get_file_by_files($data) {
	$filename = $data['userfile']['name'];
	$filepath = './uploads/' . $data['userfile']['name'];
	$newname = $data['newfile']['name'];
	$newpath = './uploads/' . $data['newfile']['name'];
}

function get_file_by_post($data) {
	$filename = $data['filename'];
	$filepath = './uploads/' . $filename;
	$newname = $data['new-filename'];
	$newpath = './uploads/' . $newname;
}

function get_filename() {

}

function file_check_permission($data) {
	$_SESSION['id'] = get_session_id($_SESSION['username']);
	$id_files = check_session_id($data['filename']);

	if ($_SESSION['id'] !== $id_files) {
		return false;
	}
	return true;
}

function display_files() {
	$result = get_all_files($_SESSION['id']);
	$icon_delete = '<a href="?action=delete"><img src="assets/img/icon_delete.png"></a>';
	$icon_rename = '<a href="?action=rename"><img src="assets/img/icon_rename.png"></a>';
	$icon_replace = '<a href="?action=replace"><img src="assets/img/icon_replace.png"></a>';
	$icon_download = '<a href="?action=download"><img src="assets/img/icon_download.png"></a><';
	$div_actions = '<div class="file-actions">' . $icon_rename . $icon_replace . $icon_download . $icon_delete . '</div>';

	echo '<ol>';
	for ($i = 0; $i < count($result); $i ++) {
		echo '<li>';
		echo '<div class="list-files">' . $result[$i]['filename'] . $div_actions . '</div>';
		echo '</li>';
	}
	echo '</ol>';
}

function file_upload($data) {
	$filename = $data['userfile']['name'];
	$filepath = './uploads/' . $filename;

	insert_file($_SESSION['id'], $filename, $filepath);
    move_uploaded_file($data['userfile']['tmp_name'], $filepath);
}

function file_download($data) {
	// $filename = get_filename();
	$filename = $data['filename'];
	$file_url = './uploads/' . $filename;
	header('Content-Type: application/octet-stream');
	header('Content-Transfer-Encoding: binary');
	header('Content-disposition: attachment; filename=' . basename($file_url) . '');
	//header('Content-Disposition: attachment; filename=' . $file_url); // file saved by the browser
	readfile($file_url);
	echo $file_url;
	echo "toto";
}

function file_rename($data) {
	get_file_by_post($data);
	update_file($_SESSION['id']);
	rename($filepath, $newpath);
}

function file_replace($data) {
	get_file_by_files($data);
	update_file($_SESSION['id']);
	unlink('./uploads/' . $filename);
	move_uploaded_file($_FILES['newfile']['tmp_name'], $newpath);
}

function file_delete($data) {
	//$filename = get_filename();
	$filename = $data['filename'];
	delete_file($filename);
	unlink('./uploads/' . $filename);
}