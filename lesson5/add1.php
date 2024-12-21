<?php
require_once '../shared/functions.php'; // with a function for XSS (str2html)
try {
    $dsn = "mysql:host=localhost;dbname=sample_db";
    $user = "phpuser";
    $password = "dummy";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    $dbh = new PDO($dsn, $user, $password, $options);

    $sql = 'INSERT INTO books (id, title, isbn, price, publish, author)
            VALUES (NULL, :title, :isbn, :price, :publish, :author)';
    $stmt = $dbh->prepare($sql);
    //$price = (int) $_POST['price'];
    $stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
    $stmt->bindParam(":price", $_POST['price'], PDO::PARAM_INT);
    $stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);

    $stmt->execute();
    echo "Added Data <br>";
    echo "<a href='list.php'> Return to the list</a>";
}
catch(PDOException $e){
    echo "Error!!: " . str2html($e->getMessage()) . "<br>";
    //$e->getMessage() for a training purpose to know how it works
    exit;
}
