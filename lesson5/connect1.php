<?php
$dsn = "mysql:host=localhost;dbname=sample_db";
$user = "phpuser";
$password = "dummy";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
];
$dbh = new PDO($dsn, $user, $password, $options);
var_dump($dbh);