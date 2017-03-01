<?php

require_once('model/file.php');

function upload_action() {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		if (file_check_upload($_FILES)) {
			file_upload($_FILES);
			echo "<p style='color:white;'>" . "Transfert effectué" . "</p>";
		}
		else {
			echo "<p style='color:white;'>" . "Erreur lors du transfert : " . $_FILES['userfile']['error'] . "</p>";
		}
	}
	require('views/home.html');
}

function download_action() {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		echo "toto";
		if (file_check_permission($_POST)) {
			file_download($_POST);
			echo "<p style='color:white;'>" . "Téléchargement effectué !" . "</p>";
		}
		else {
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/download.html');
	// require('views/home.html');
}

function rename_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_rename($_POST);
			echo "<p style='color:white;'>" . "Changement effectué !" . "</p>";
		}
		else {
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	// require('views/home.html');
}

function replace_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission()) {
			file_replace($_FILES);
			echo "<p style='color:white;'>" . "Votre fichier a été remplacé !" . "</p>";
		}
		else {
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	// require('views/home.html');
}

function delete_action() {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (file_check_permission($_POST)) {
			file_delete($_POST);
			echo "<p style='color:white;'>" . "Votre fichier a été supprimé !" . "</p>";
		}
		else {
			echo "<p style='color:white;'>" . "Vous n'avez pas accès à ce fichier" . "</p>";
		}
	}
	require('views/delete.html');
	// require('views/home.html');
}