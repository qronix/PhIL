<?php

include ("phone.php");

$phone = new Phone();
$returnData = "";


    if(isset($_POST['vendor'])&&!empty($_POST['vendor'])){
        $vendor = filter_input(INPUT_POST,'vendor');
        $returnData = $phone->getCarriers($vendor);
    }
    if((isset($_POST['carrier'])&&!empty($_POST['carrier']))&&
        (isset($_POST['vendor']))&&!empty($_POST['vendor'])){
        $vendor = filter_input(INPUT_POST,'vendor');
        $carrier = filter_input(INPUT_POST,'carrier');
        $returnData = $phone->getPhones($vendor,$carrier);
    }

echo $returnData;