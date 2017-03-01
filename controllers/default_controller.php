<?php

require_once('model/user.php');
require_once('model/file.php');

function index_action() {
	require('views/index.html');
}

function home_action() {
	// display_files(); // called in home.html
	require('views/home.html');
}

/*
function check_connection() {
	if (!empty($_SESSION['username'])) {
        require('views/file.php');
    }
    else {
        header('Location: ?action=index');
        exit(0);
    }
}
*/