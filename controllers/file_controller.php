<?php

require_once('model/file.php');

function upload_action() {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		/*
		if (preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name_file)) {
		    exit("Nom de fichier non valide");
		}
		*/
		if (file_check_upload($_FILES)) {
			file_upload($_FILES);
			header('Location: ?action=home');
		}
		else {
			echo "<p style='color:white;'>" . "Erreur lors du transfert : " . $_FILES['userfile']['error'] . "</p>";
		}
	}
	require('views/home.html');
}

function rename_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_rename($_POST);
			header('Location: ?action=home');
		}
		else {
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/home.html');
}

function replace_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_replace($_POST);
			header('Location: ?action=home');
		}
		else {
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/home.html');
}

function delete_action() {
	if (file_check_permission()) {
		file_delete();
		header('Location: ?action=home');
	}
	else {
		echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
	}
	require('views/home.html');
}