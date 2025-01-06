<?php
if(!isset($_SESSION)){
    session_start();
}
if(empty($_SESSION['login'])){
    echo "<a href='login.php'>login</a> is reguired to enter this page";
    exit;
}
echo "<!----- Logged in ----->";

//Select the role from user table.
$dbh = db_open();
$stmt = $dbh->prepare('SELECT role FROM users where username = :username');
$stmt->bindValue(':username', $_SESSION['login']);
$stmt->execute();
$row = $stmt->fetch();
$_SESSION['role'] = $row['role'];