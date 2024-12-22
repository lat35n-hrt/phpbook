<?php
require_once '../shared/functions.php'; // with a function for XSS (str2html)
if(empty($_POST['title'])){
    echo "The title field is required.";
    exit;
}
if(!preg_match('/\A[[:^cntrl:]]{1,200}\z/u', $_POST['title'])){
    echo "The title must be between 1 and 200 characters, and cannot contain control characters.";
    exit;
}
if(!preg_match('/\A\d{0,13}\z/u', $_POST['isbn'])){
    echo "The ISBN must be a numeric value with up to 13 digits.";
    exit;
}
if(!preg_match('/\A\d{0,6}\z/u', $_POST['price'])){
    echo "The price must be a numeric value with up to 6 digits.";
    exit;
}
if(empty($_POST['publish'])){
    echo "The publish date field is required.";
    exit;
}
if(!preg_match('/\A\d{4}-\d{1,2}-\d{1,2}\z/u', $_POST['publish'])){
    echo "The publish date must be in the format YYYY-MM-DD.";
    exit;
}
// Extract year, month, and day from the input 'YYYY-MM-DD'
$date = explode('-', $_POST['publish']);
// Check if the date is valid (month, day, year)
if(!checkdate($date[1], $date[2], $date[0])){
    echo "The publish date is invalid. Please enter a valid date.";
    exit;
}
if(!preg_match('/\A[[:^cntrl:]]{0,89}\z/u', $_POST['author'])){
    echo "The author name must be up to 89 characters and cannot contain control characters.";
    exit;
}
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
