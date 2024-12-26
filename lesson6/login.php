<?php
session_start();
require_once __DIR__ . '/../shared/functions.php'; // with a function for XSS (str2html) and db_open()
include_once __DIR__ . '/../shared/header.php'; // with a shared header
?>
<form method='post' action='login.php'>
    <p>
        <label for="username">User Name: </label>
        <input type='text' name='username'>
    </p>
    <p>
        <label for="password">Password: </label>
        <input type='password' name='password'>
    </p>
    <input type='submit' value='Submit'>
</form>
<?php
if(!empty($_SESSION['login'])){
    echo "Already Login<br>";
    echo "<a href=index.php>Return to the List</a>";
    exit;
}
if((empty($_POST['username'])) || (empty($_POST['password']))){
    echo "Enter username, pasword";
    exit;
}
?>

<?php

try {
    $dbh = db_open();
    $sql = "SELECT password FROM users WHERE username = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$result){
        echo "Logon Failed";
        exit;
    }
} catch(PDOException $e){
    echo "Error!!: " . str2html($e->getMessage()) . "<br>";
    //$e->getMessage() for a training purpose to know how it works
    exit;
}