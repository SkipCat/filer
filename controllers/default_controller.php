<?php

require('model/folder.php');
require('model/file.php');

function index_action() {
	require('views/index.html');
}

function home_action() {
	if (!empty($_SESSION['username'])) {
        require('views/home.html');
    }
    else {
        header('Location: ?action=index');
        exit(0);
    }
}