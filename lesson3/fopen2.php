<?php
$fp = fopen('bookdata.csv', 'r');
if($fp === false) {
    echo "Failed to open a file";
    exit;
}
var_dump($fp);
// comment out
/*
multiple comments
*/