<?php
$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" . $_GET['zip'];
$response = file_get_contents($url);
$response = json_decode($response, true);
echo "You entered ZIP code of: ";
echo $response["results"][0]["address1"];
echo $response["results"][0]["address2"];
echo $response["results"][0]["address3"];