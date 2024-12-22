<?php
require_once '../shared/functions.php'; // with a function for XSS (str2html)
try {
    // Establish a database connection using db_open() from /shared/functions.php
    $dbh = db_open();
    $sql = 'SELECT title, author FROM books';
    $statement = $dbh->query($sql);

    while ($row = $statement->fetch()){
        echo "Book Title: ", str2html($row[0]), "<br>";
        echo "Book Title: ", str2html($row[1]), "<br><br>";
    }
    //var_dump($dbh);
}
catch(PDOException $e){
    echo "Error!!: " . str2html($e->getMessage()) . "<br>";
    //$e->getMessage() for a training purpose to know how it works
    exit;
}
