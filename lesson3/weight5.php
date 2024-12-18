<?php
$height = (float)$_POST['height'];
if (0 < $height){
    if($height < 3){
        echo 'The appropriate weight is' . $height * $height * 22 . 'kg'; 
    }else {
        echo 'Enter value lower than 3m';
    }
}else{
    echo 'Enter value more than 0';
}


