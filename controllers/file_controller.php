<?php

require_once('model/file.php');
require_once('model/log.php');

function upload_action() {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		/*
		if (preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name_file)) {
		    exit("Nom de fichier non valide");
		}
		*/
		if (file_check_upload($_FILES)) {
			file_upload($_FILES);
			write_log('access.log', 'File uploaded.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error upload transfert.');
			echo "<p style='color:white;'>" . "Erreur lors du transfert : " . $_FILES['userfile']['error'] . "</p>";
		}
	}
	require('views/home.html');
}

function rename_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_rename($_POST);
			write_log('access.log', 'File renamed.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error file access for rename action.');
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/home.html');
}

function replace_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_replace($_POST);
			write_log('access.log', 'File replaced.');
			header('Location: ?action=home');
			exit(0);
		}
		else {
			write_log('security.log', 'Error file access for replace action.');
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/home.html');
}

function delete_action() {
	if (file_check_permission()) {
		file_delete($_POST);
		write_log('access.log', 'File deleted.');
		header('Location: ?action=home');
		exit(0);
	}
	else {
		write_log('security.log', 'Error file access for delete action.');
		echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
	}
	require('views/home.html');
}

function move_action() {
	
}