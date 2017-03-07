<?php

require_once('model/db.php');
require_once('model/user.php'); 

function prewiew_files($filepath) {
	/*$filetype = mime_content_type($filepath);
	if ($filetype == ) {

	}
	else {
		return 'application/octet-stream';
	}*/
}

function display_files() {
	$files = get_all_files($_SESSION['id']);

	echo '<ul>';
	foreach ($files as $i) {
		echo '<li>';
			echo '<div class="list-files">';
				echo '<p>' . $i['filename'] . '</p>';

				echo '<div class="container-rename-field">';
					echo '<form method="POST" action="?action=rename">' . '<input type="hidden" name="input-filename" value="'.$i['filename'].'">' . '<input type="hidden" name="input-filepath" value="'.$i['filepath'].'">' . '<input type="text" name="filename" placeholder="Nouveau nom">' . '<input type="submit" value="Renommer">' . '</form>';
				echo '</div>';
				echo '<div class="container-replace-field">';
					echo '<form method="POST" action="?action=replace" enctype="multipart/form-data">' . '<input type="hidden" name="MAX_FILE_SIZE" value="50000000">' . '<input type="hidden" name="input-filename" value="'.$i['filename'].'">' . '<input type="hidden" name="input-filepath" value="'.$i['filepath'].'">' . '<input type="file" name="filename">' . '<input type="submit" value="Remplacer">' . '</form>';
				echo '</div>';
				echo '<div class="container-modify-field">';
					echo '<form method="POST" action="?action=modify" name="form-modify">'. '<input type="hidden" name="input-filename" value="'.$i['filename'].'" class="input-hidden">' . '<input type="hidden" name="input-filepath" value="'.$i['filepath'].'" class="input-hidden">' . '<textarea name="content-modification" placeholder="Ajouter du texte" value="'.file_get_contents($i['filepath'])
.'">'.file_get_contents($i['filepath']).'</textarea>' . '<input type="submit" value="Modifier">' . '</form>';
				echo '</div>';
				echo '<div class="container-move-field">';
					echo '<form method="POST" action="?action=move">' . '<input type="hidden" name="input-filename" value="'.$i['filename'].'">' . '<input type="hidden" name="input-filepath" value="'.$i['filepath'].'">' . '<input type="text" name="new-folder" placeholder="Nom du dossier">' . '<input type="submit" value="Déplacer">' . '</form>';
				echo '</div>';
				echo '<div class="container-delete-field">';
					echo '<form method="POST" action="?action=delete">' . '<input type="hidden" name="input-filename" value="'.$i['filename'].'">' . '<input type="hidden" name="input-filepath" value="'.$i['filepath'].'">' . '<p>Supprimer ?</p>' . '<input type="submit" value="Oui">' . '</form>';
				echo '</div>';

				echo '<div class="file-actions">';
					echo '<a>' . '<img src="assets/img/icon_rename.png" class="icon-rename" alt="icon-to-rename">' . '</a>';
					echo '<a>' . '<img src="assets/img/icon_replace.png" class="icon-replace" alt="icon-to-replace>' . '</a>';
					if ($i['extension'] === 'text/plain') {
						echo '<a>' . '<img src="assets/img/icon_modify.png" class="icon-modify" alt="icon-to-modify>' . '</a>';
					}
					echo '<a>' . '<img src="assets/img/icon_folder.png" class="icon-move" alt="icon-to-move>' . '</a>';
					echo '<a href="'.$i['filepath'].'" download="'.$i['filename'].'">' . '<img src="assets/img/icon_download.png" alt="icon-to-download>' . '</a>';
					echo '<a>' . '<img src="assets/img/icon_delete.png" class="icon-delete" alt="icon-to-delete>' . '</a>';
				echo '</div>';
			echo '</div>';
		echo '</li>';
	}
	echo '</ul>';
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

function file_check_upload($data) {
	if ($data['userfile']['error'] > 0) { // if error value > 0 (0 = no error) then show it
		return false;
	}
	return true;
}

function file_upload($data) {
	// get file informations
	$filename = $data['userfile']['name'];
	$extension = $data['userfile']['type'];
	$filepath = 'uploads/' . $_SESSION['username'] . '/' . $filename;
	$newname = $_POST['file-rename'];
	$newpath = 'uploads/' . $_SESSION['username'] . '/' . $newname;

	// check if file renamed
	if (!empty($newname)) {
		insert_file($_SESSION['id'], $newname, $extension, $newpath);
    	move_uploaded_file($data['userfile']['tmp_name'], $newpath);
	}
	else {
		insert_file($_SESSION['id'], $filename, $extension, $filepath);
    	move_uploaded_file($data['userfile']['tmp_name'], $filepath);
	}
}

function file_rename($data) {
	// get file informations
	$filename = $data['input-filename'];
	$filepath = $data['input-filepath'];
	$id_folder = get_files_id_folders($filename);
	$newname = $data['filename'];

	// check if file belongs to a directory
	if ($id_folder === NULL) {
		$newpath = 'uploads/' . $_SESSION['username'] . '/' . $newname; // path by default
	}
	else {
		$folderpath = get_folderpath($id_folder);
		$newpath = $folderpath . '/' . $newname;
	}

	update_file($filename, $newname, $newpath); // rename in db
	rename($filepath, $newpath); // rename in local
}

function file_replace($data) {
	// get actual file informations
	$filename = $data['input-filename'];
	$filepath = $data['input-filepath'];
	$id_folder = get_files_id_folders($filename);
	$newname = $_FILES['filename']['name'];

	// check if file belongs to a directory
	if ($id_folder === NULL) {
		$newpath = 'uploads/' . $_SESSION['username'] . '/' . $newname; // path by default
	}
	else {
		$folderpath = get_folderpath($id_folder);
		$newpath = $folderpath . '/' . $newname;
	}

	update_file($filename, $newname, $newpath); // replace file in db
	unlink($filepath); // delete oldfile in local
	move_uploaded_file($_FILES['filename']['tmp_name'], $newpath); // add newfile in local
}

function file_delete($data) {
	// get file informations
	$filename = $data['input-filename'];
	$filepath = $data['input-filepath'];

	delete_file($filename); // delete file in db
	unlink($filepath); // delete file in local
}

function file_modify($data) {
	// get file informations
	$filename = $data['input-filename'];
	$filepath = $data['input-filepath'];
	$new_content = $data['content-modification'];

	// file_get_content()
	
	// modify file in local
	$file_to_modify = fopen($filepath, 'w'); // opens the file in single writing
    fwrite($file_to_modify, "\r\n" . $new_content); // add content from input text
    fclose($file_to_modify); // closes current opened file

    // modify file in db
    $newname = $data['input-filename'];
	update_file($filename, $newname, $filepath);
}

function file_move($data) {
	// get file informations
	$filename = $data['input-filename'];
	$filepath = $data['input-filepath'];
	$id_folder = get_files_id_folders($filename);

	// get new folder informations
	$new_folder = $data['new-folder'];
	$folder = get_one_folder($new_folder);
	
	foreach ($folder as $value) {
		$folderpath = $value['folderpath'];
		$folder_id = $value['id'];
	}

	$newpath = $folderpath . '/' . $filename;
	move_file($folder_id, $filename, $newpath); // 'move' file in db (modify path)
	rename($filepath, $newpath); // move file in local
}