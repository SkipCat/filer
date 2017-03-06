<?php

require_once('model/file.php');
require_once('model/log.php');
require_once('model/folder.php');


function create_folder_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['folder-name'])){
			folder_create();
			write_log('access.log', 'Folder created.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error folder access for create action.');
			echo "<p style='color:white;font-family:Calibri'>" . "Choisissez un nom." . "</p>";
		}
	}
	require('views/home.html');
}

function rename_folder_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (folder_check_permission()) {
			folder_rename($_POST);
			write_log('access.log', 'Folder renamed.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error folder access for rename action.');
			echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce dossier" . "</p>";
		}
	}
	require('views/home.html');
}

function move_folder_action() {
	if (folder_check_permission()) {
		folder_move($_POST);
		write_log('access.log', 'Folder moved.');
		header('Location: ?action=home');
		exit(0);
	}
	else {
		write_log('security.log', 'Error folder access for move action.');
		echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce dossier" . "</p>";
	}
	require('views/home.html');
}

function delete_folder_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (folder_check_permission()) {
			folder_delete($_POST);
			write_log('access.log', 'Folder deleted.');
			//header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error folder access for delete action.');
			echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce dossier" . "</p>";
		}
	}
	require('views/home.html');
}