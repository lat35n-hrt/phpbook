<?php
require_once '../shared/functions.php';

$fp = fopen('bookdata.csv', 'r');
if($fp === false) {
    echo "Failed to open a file";
    exit;
}
while($row = fgetcsv($fp)){
    echo "Title: " . str2html($row[0]), "<br>";
    echo "Author:" . str2html($row[4]), "<br><br>";
}