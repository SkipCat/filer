<?php

require_once('model/db.php');

/*
function rmAllDir($strDirectory){
    $handle = opendir($strDirectory);
    while(false !== ($entry = readdir($handle))){
        if($entry != '.' && $entry != '..'){
            if(is_dir($strDirectory.'/'.$entry)){
                rmAllDir($strDirectory.'/'.$entry);
            }
            elseif(is_file($strDirectory.'/'.$entry)){
                unlink($strDirectory.'/'.$entry);
            }
        }
    }
    rmdir($strDirectory.'/'.$entry);
    closedir($handle);
}

rmAllDir($dossier);
*/