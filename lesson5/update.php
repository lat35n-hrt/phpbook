<?php
require_once '../shared/functions.php'; // with a function for XSS (str2html) and db_open()
//validation
if(empty($_POST['id'])){
    echo "Specify id";
    exit;
}
if(!preg_match('/\A\d{1,11}\z/u', $_POST['id'])){
    echo "Invalid id";
    exit;
}

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
echo "<a href='list5.php'> Return to the list</a>";
}
catch(PDOException $e){
echo "Error!!: " . str2html($e->getMessage()) . "<br>";
//$e->getMessage() for a training purpose to know how it works
exit;
}