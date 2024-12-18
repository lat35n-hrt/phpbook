<?php
    $fp = fopen('bookdata.csv', 'r');
if($fp === false){
    echo "Failed to open a file";
    exit;
}
while($row = fgetcsv($fp)){
    echo "Title: " . htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8'), "<br>";
    echo "Author:" . htmlspecialchars($row[4], ENT_QUOTES, 'UTF-8'), "<br><br>";
}