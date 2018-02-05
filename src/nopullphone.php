<?php

include("phone.php");

$phone = new Phone();

$returnData = "";

if(isset($_GET['phoneid'])&&!empty($_GET['phoneid'])){
    $phoneid = filter_input(INPUT_GET,'phoneid');
    $returnData = $phone->noPullPhone($phoneid);
}else{
    $returnData = "<div class='alert alert-warning'>Invalid phone id</div>";
}

header("Location: phonelist.php");
