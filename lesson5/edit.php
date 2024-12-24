<?php
require_once '../shared/functions.php'; // with a function for XSS (str2html) and db_open()
//validation
if(empty($_GET['id'])){
    echo "Specify id";
    exit;
}
if(!preg_match('/\A\d{1,11}\z/u', $_GET['id'])){
    echo "Invalid id";
    exit;
}
$id = (int) $_GET['id'];

//retrive data from database
$dbh = db_open();
$sql = "SELECT * FROM books WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result){
    echo "Data not found";
    exit;
}
var_dump($result); //would-be removed 