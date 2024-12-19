<?php
require_once '../shared/functions.php'; // with a function for XSS (str2html)
try {
    $dsn = "mysql:host=localhost;dbname=sample_db";
    $user = "phpuser";
    $password = "j*YNfHAm8VdbMzHM";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    $dbh = new PDO($dsn, $user, $password, $options);
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
