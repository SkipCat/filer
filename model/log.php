<?php

function give_me_date() {
    $date = date('d-m-Y'); // day-month-year
    $hour = date('H:i'); // hour:i ??
    return $date . ' ' . $hour;
}

function write_log($file, $text) {
    $date = give_me_date();
    $file_log = fopen('logs/' . $file, 'a'); // opens the file
    $log_info = $date . ' -> ' . $text . "\r\n";

    fwrite($file_log, $log_info); // writes in the current opened file
    fclose($file_log); // closes the current opened file
}