<?php
$str = "1234567";
$rtn1 = preg_match('/\d{7}/u', $str, $match1);

$str = "abcdefg";
$rtn2 = preg_match('/\d{7}/u', $str, $match2);

$str = "111-1111";
$rtn3 = preg_match('/\d{7}/u', $str, $match3);

echo "Result1: ";
var_dump($rtn1);

echo "Result2: ";
var_dump($rtn2);

echo "Result3: ";
var_dump($rtn3);