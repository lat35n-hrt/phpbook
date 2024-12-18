<?php
require_once 'functions.php';

$height = (float)$_POST['height'];
$weight = (float)$_POST['weight'];

//Validation
if (!(0 < $height) && ($height < 3)){
    echo 'Enter valid value';
    exit;
}
if (($weight < 30) || (300 < $weight)){
    echo "Enter valid value";
    exit;
}

$goal_weight = $height * $height * 22;

$difference = abs($goal_weight - $weight);

echo 'Weight' . str2html($weight) . 'Kg<br>';
echo 'Goal Weight' . str2html($goal_weight) . 'Kg<br>';
echo str2html($difference) . 'Kg to the appropriate weight. <br>';