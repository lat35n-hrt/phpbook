<?php
$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=1010051";
$response = file_get_contents($url);
var_dump($response);