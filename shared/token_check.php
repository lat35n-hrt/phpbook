<?php
if(!isset($_SESSION)){
    session_start();
}
if(empty($_POST['token'])){
    echo "Error occurred";
    exit;
}
if (!(hash_equals($_SESSION['token'], $_POST['token']))){
    echo "Error occurred (2)";
    exit;
}