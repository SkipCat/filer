<?php

require_once('model/file.php');
require_once('model/log.php');

function upload_action() {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		if (!empty($_FILES['userfile']['name'])) {
			if (file_check_upload($_FILES)) {
				file_upload($_FILES);
				write_log_user('access.log', 'File ' . $_FILES['userfile']['name'] . ' uploaded.');
				header('Location: ?action=home');
				exit(0);
			}
			else {
				write_log_user('security.log', 'Error upload transfert.');
				echo "<p style='color:white;font-family:Calibri'>" . "Erreur" . $_FILES['userfile']['error'] . "lors du transfert : Vous n'avez pas sélectionné de fichier, ou celui-ci est trop lourd." . "</p>";
			}
		}
		else {
			write_log_user('security.log', 'No file to upload.');
			echo "<p style='color:white;font-family:Calibri'>" . "Choisissez un fichier." . "</p>";
		}
	}
	require('views/home.html');
}

function rename_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$error = '';
		if (!empty($_POST['filename'])) {
			if (file_check_permission()) {
				file_rename($_POST);
				write_log_user('access.log', 'File ' . $_POST['input-filename'] . ' renamed.');
				header('Location: ?action=home');
				exit(0);
			}
			else {
				write_log_user('security.log', 'Error file access for rename action.');
				echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
			}
		}
		else {
			write_log_user('security.log', 'No name to rename file.');
			$error = 'Choisissez un nom.';
			echo "<p style='color:white;font-family:Calibri'>" . "Choisissez un nom." . "</p>";
		}
	}
	require('views/home.html');
}

function replace_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_FILES['filename']['name'])) {
			if (file_check_permission()) {
				file_replace($_POST);
				write_log_user('access.log', 'File ' . $_POST['input-filename'] . ' replaced.');
				header('Location: ?action=home');
				exit(0);
			}
			else {
				write_log_user('security.log', 'Error file access for replace action.');
				echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
			}
		}
		else {
			write_log_user('security.log', 'No file to replace file.');
			echo "<p style='color:white;font-family:Calibri'>" . "Choisissez un fichier." . "</p>";
		}
	}
	require('views/home.html');
}

function delete_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_delete($_POST);
			write_log_user('access.log', 'File ' . $_POST['input-filename'] . ' deleted.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log_user('security.log', 'Error file access for delete action.');
			echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/home.html');
}

function modify_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['content-modification'])) {
			if (file_check_permission()) {
				file_modify($_POST);
				write_log_user('access.log', 'File ' . $_POST['input-filename'] . ' modified.');
				header('Location: ?action=home');
				exit(0);
			}
			else {
				write_log_user('security.log', 'Error file access for modify action.');
				echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
			}
		}
		else {
			write_log_user('security.log', 'No content to modify file.');
			echo "<p style='color:white;font-family:Calibri'>" . "Entrez du texte." . "</p>";
		}
	}
	require('views/home.html');
}

function move_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_move($_POST);
			write_log_user('access.log', 'File ' . $_POST['input-filename'] . ' moved.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log_user('security.log', 'Error file access for move action.');
			echo "<p style='color:white;font-family:Calibri'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/home.html');
}