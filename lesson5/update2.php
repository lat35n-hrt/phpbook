<?php
require_once __DIR__ . '/../shared/functions.php'; // with a function for XSS (str2html) and db_open()
include_once __DIR__ . '/../shared/error_check.php'; // with validations for error check

//validation
if(empty($_POST['id'])){
    echo "Specify id";
    exit;
}
if(!preg_match('/\A\d{1,11}\z/u', $_POST['id'])){
    echo "Invalid id";
    exit;
}




//retrive data from database
try {
$dbh = db_open();
$sql = "UPDATE books SET title = :title, isbn = :isbn, price = :price, publish = :publish, author = :author WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
$stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
$stmt->bindParam(":price", $_POST['price'], PDO::PARAM_INT);
$stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
$stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);
$stmt->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
$stmt->execute();
echo "Updated Data <br>";
echo "<a href='list6.php'> Return to the list</a>";
}
catch(PDOException $e){
echo "Error!!: " . str2html($e->getMessage()) . "<br>";
//$e->getMessage() for a training purpose to know how it works
exit;
}