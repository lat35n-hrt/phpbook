<?php
if(!isset($_SESSION)){
    session_start();
}
if(empty($_SESSION['login'])){
    echo "<a href='login.php'>login</a> is reguired to enter this page";
    exit;
}
echo "<!----- Logged in ----->";