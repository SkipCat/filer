<?php

function give_me_date() {
    $date = date('d-m-Y'); // day-month-year
    $hour = date('H:i'); // hour:i ??
    return $date . ' ' . $hour;
}

function write_log_user($file, $text) {
    $date = give_me_date();
    $file_log = fopen('logs/' . $file, 'a'); // opens the file ('a' -> single writing, file created if doesn't exist)
    $log_info = $date . ' -> ' . $_SESSION['username'] .  ' => ' . $text . "\r\n";

    fwrite($file_log, $log_info); // writes in the current opened file
    fclose($file_log); // closes the current opened file
}

function write_log($file, $text) {
	$date = give_me_date();
    $file_log = fopen('logs/' . $file, 'a'); 
    $log_info = $date . ' -> ' . $text . "\r\n";

    fwrite($file_log, $log_info);
    fclose($file_log);	
}