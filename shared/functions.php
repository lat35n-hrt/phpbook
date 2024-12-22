<?php
/**
 * Sanitize input for HTML output
 * 
 * @param string $arg_input The input string to sanitize
 * @return string The sanitized string
 */
function str2html(string $arg_input) :string {
    return htmlspecialchars($arg_input, ENT_QUOTES, 'UTF-8');
}

function db_open(){
    $dsn = "mysql:host=localhost;dbname=sample_db";
    $user = "phpuser";
    $password = "dummy";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    $dbh = new PDO($dsn, $user, $password, $options);
    return $dbh;
}