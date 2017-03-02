<?php

function give_me_date() {
    $date = date("d-m-Y");
    $hour = date("H:i");
    return $date . " " . $hour;
}

function write_log($file, $text) {
    $date = give_me_date();
    $file_log = fopen('logs/' . $file, 'a');
    $log_info = $date . $text;

    fwrite($file_log, $log_info);
    fclose($file_log);
}