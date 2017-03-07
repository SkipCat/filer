<?php

require_once('model/file.php');
require_once('model/log.php');
require_once('model/folder.php');


function create_folder_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['folder-name'])) {
			folder_create();
			write_log('access.log', 'Folder ' . $_POST['folder-name'] . ' created.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'No name to create folder.');
			echo "<p style='color:white;font-family:Calibri'>" . "Choisissez un nom." . "</p>";
		}
	}
	require('views/home.html');
}

function rename_folder_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['input-foldername'])) {
			if (folder_check_permission()) {
				folder_rename($_POST);
				write_log('access.log', 'Folder' . $_POST['input-foldername'] . ' renamed.');
				header('Location: ?action=home');
				exit(0);
			}
			else {
				write_log('security.log', 'Error folder access for rename action.');
				echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce dossier" . "</p>";
			}
		}
		else {
			write_log('security.log', 'No name to rename folder.');
			echo "<p style='color:white;font-family:Calibri'>" . "Choisissez un nom." . "</p>";
		}
	}
	require('views/home.html');
}

function move_folder_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['input-foldername'])) {
			if (folder_check_permission()) {
				folder_move($_POST);
				write_log('access.log', 'Folder' . $_POST['input-foldername'] . ' moved.');
				header('Location: ?action=home');
				exit(0);
			}
			else {
				write_log('security.log', 'Error folder access for move action.');
				echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce dossier" . "</p>";
			}
		}
		else {
			write_log('security.log', 'No name to move folder for user' . $_SESSION['username']);
			echo "<p style='color:white;font-family:Calibri'>" . "Choisissez un nom." . "</p>";
		}
	}
	require('views/home.html');
}

function delete_folder_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (folder_check_permission()) {
			folder_delete($_POST);
			write_log('access.log', 'Folder' . $_POST['input-foldername'] . ' deleted.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error folder access for delete action.');
			echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce dossier" . "</p>";
		}
	}
	require('views/home.html');
}