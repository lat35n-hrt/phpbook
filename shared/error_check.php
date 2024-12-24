<?php
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