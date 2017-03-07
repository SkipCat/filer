<?php

require_once('model/user.php');
require_once('model/file.php');
require_once('model/log.php');
require_once('model/folder.php');

function index_action() {
	require('views/index.html');
}

function home_action() {
	// display_folders(); // called in home.html
	// display_files(); // called in home.html
	if (!empty($_SESSION['username'])) {
        require('views/home.html');
    }
    else {
        header('Location: ?action=index');
        exit(0);
    }
}