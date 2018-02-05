<?php

include("phone.php");

$phone = new Phone();

if(isset($_POST['action'])&&!empty($_POST['action'])){
    $returnData = $phone->displayPhones();
}

echo $returnData;