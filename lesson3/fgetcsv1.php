<?php
    $fp = fopen('bookdata.csv', 'r');
if($fp === false){
    echo "Failed to open a file";
    exit;
}
$row = fgetcsv($fp);
var_dump($row);