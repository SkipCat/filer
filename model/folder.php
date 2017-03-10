<?php

require_once('model/db.php');

function display_folders() {
    $folders = get_all_folders($_SESSION['id']);
    
    echo '<ul>';
    foreach ($folders as $i) {
        echo '<li>';
            echo '<div class="list-folders">';
                echo '<div class="show-folder">';
                    echo '<div class="folder">' . '<img src="assets/img/folder.png" class="img-folder" alt="folder-icon">' . '<p>' . $i['foldername'] . '</p>' . '</div>';
                    echo '<ul>';
                    	$inside_folder = scandir($i['folderpath']);
                    	foreach ($inside_folder as $value) {
                    		if (filetype($i['folderpath'] . '/' . $value) == 'dir' && $value != '.' && $value != '..') {
                    			$folder = get_foldername($value);
                    			echo '<li>' . '<div class="folder">' . '<img src="assets/img/folder.png" class="img-folder" alt="folder-icon">' . '<p>' . $folder . '</p>' . '</div>' . '</li>';
                    		}
                    		else if ($value != '.' && $value != '..') {
                    			echo '<li>' . $value . '</li>';
                    		}
                    	}
                    echo '</ul>' . '<br>';

                echo '</div>';

                echo '<div class="folder-rename-field">';
                    echo '<form method="POST" action="?action=rename_folder">' . '<input type="hidden" name="input-foldername" value="'.$i['foldername'].'">' . '<input type="hidden" name="input-folderpath" value="'.$i['folderpath'].'">' . '<input type="text" name="folder-rename" placeholder="Nouveau nom">' . '<input type="submit" value="Renommer">' . '</form>';
                echo '</div>';
                echo '<div class="folder-move-field">';
                    echo '<form method="POST" action="?action=move_folder">' . '<input type="hidden" name="input-foldername" value="'.$i['foldername'].'">' . '<input type="hidden" name="input-folderpath" value="'.$i['folderpath'].'">';
                    	echo '<select name="new-folder">';
							foreach ($folders as $folder) {
								echo '<option value="'.$folder['foldername'].'">' . $folder['foldername'] . '</option>';
							}
						echo  '</select>';
					echo '<input type="submit" value="Déplacer">' . '</form>';
                echo '</div>';
                echo '<div class="folder-delete-field">';
                    echo '<form method="POST" action="?action=delete_folder">' . '<input type="hidden" name="input-folderpath" value="'.$i['folderpath'].'">' . '<p>Supprimer ?</p>' . '<input type="submit" value="Oui">' . '</form>';
                echo '</div>';

                echo '<div class="folder-actions">';
                    echo '<a>' . '<img src="assets/img/icon_rename.png" class="icon-rename-folder" alt="icon-to-rename">' . '</a>';
                    echo '<a>' . '<img src="assets/img/icon_folder.png" class="icon-move-folder" alt="icon-to-move">' . '</a>';
                    echo '<a>' . '<img src="assets/img/icon_delete.png" class="icon-delete-folder" alt="icon-to-delete">' . '</a>';
                echo '</div>';
            echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
}

function folder_check_permission() {
    $result = get_all_folders($_SESSION['id']);
    $_SESSION['id'] = get_session_id($_SESSION['username']);

    foreach ($result as $i) {
        $id_folder = check_session_id_folder($i['foldername']);

        if ($_SESSION['id'] !== $id_folder) {
            return false;
        }
        return true;
    }
}

function folder_create() {
    $foldername = $_POST['folder-name'];
    $folderpath = 'uploads/' . $_SESSION['username'] . '/' . $foldername;

    // create folder in db
    insert_folder($_SESSION['id'], $foldername, $folderpath);
    $folder = get_one_folder($foldername);
    
    foreach ($folder as $value) {
        $folder_id = $value['id'];
    }

    $newpath = 'uploads/' . $_SESSION['username'] . '/' . $folder_id;
    update_folderpath($foldername, $newpath);
    mkdir($newpath); // create folder in local (with id as foldername)
}

function folder_rename($data) {
    $foldername = $data['input-foldername'];
    $newname = $data['folder-rename'];
    update_folder($foldername, $newname); // folder rename in db
}

function directory_delete($dirpath) {
	if (is_dir($dirpath)) {
		$objects = scandir($dirpath);
		foreach ($objects as $object) {
			if ($object != '.' && $object != '..') {
				if (filetype($dirpath . '/' . $object) == 'dir') { // or is_dir()
					directory_delete($dirpath . '/' . $object); // recursivity
				}
				else {
					delete_file($object);
					unlink($dirpath . '/' . $object);
				}
			}
		}
		reset($objects); // set internal pointer of array 'objects' to its first element
		rmdir($dirpath); // delete folder in local
		delete_folder($dirpath); // delete folder in db
	}
}
function folder_delete($data) {
    $folderpath = $data['input-folderpath'];
    directory_delete($folderpath);
}

function folder_move($data) {
    // get folder informations
    $foldername = $data['input-foldername'];
    $folderpath = $data['input-folderpath'];

    // get folder container informations
    $new_folder = $data['new-folder'];
    $directory = get_one_folder($new_folder);

    foreach ($directory as $value) {
        $dirpath = $value['folderpath'];
        $dir_id = $value['id'];
    }

    // move folder
    $newpath = $dirpath . '/' . basename($folderpath);
    move_folder($dir_id, $foldername, $newpath); // 'move' folder in db (modify path)
    rename($folderpath, $newpath); // move folder in local

    // move files and folders inside
}