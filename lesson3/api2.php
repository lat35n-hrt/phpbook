<?php
$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" . $_GET['zip'];
$response = file_get_contents($url);
var_dump($response);