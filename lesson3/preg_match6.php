<?php
$str = "12345678";
$rtn1 = preg_match('/\A\d{7}\z/u', $str);

$str = "1234567a";
$rtn2 = preg_match('/\A\d{7}\z/u', $str);

$str = "111-1234567";
$rtn3 = preg_match('/\A\d{7}\z/u', $str);

$str = "1234567";
$rtn4 = preg_match('/\A\d{7}\z/u', $str);

echo "Result1: ";
var_dump($rtn1);

echo "Result2: ";
var_dump($rtn2);

echo "Result3: ";
var_dump($rtn3);

echo "Result4: ";
var_dump($rtn4);