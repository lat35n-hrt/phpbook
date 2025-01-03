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

$title = str2html($result['title']);
$isbn = str2html($result['isbn']);
$price = str2html($result['price']);
$publish= str2html($result['publish']);
$author = str2html($result['author']);
$id = str2html($result['id']);

$html_form = <<<EOD
<form action='update3.php' method='post'>
    <p>
        <label for='title'>Title: </label>
        <input type='text' name='title' value='$title'>
    </p>
    <p>
        <label for='title'>ISBN: </label>
        <input type='text' name='isbn' value='$isbn'>
    </p>
    <p>
        <label for='title'>Price: </label>
        <input type='text' name='price' value='$price'>
    </p>    
    <p>
        <label for='title'>Publish Date: </label>
        <input type='text' name='publish' value='$publish'>
    </p>    
    <p>
        <label for='title'>Author: </label>
        <input type='text' name='author' value='$author'>
    </p>
    <p class='button'>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' value='Submit'>
    </p>
</form>
EOD;
include_once __DIR__ . '/../shared/header.php'; // with a shared header
echo $html_form;
include_once __DIR__ . '/../shared/footer.php'; // with a shared footer