<?php

include ("phone.php");

$phone = new Phone();

$returnData = "";

//if(isset($_GET['searchterm'])&&!empty($_GET['searchvalue'])){
//    $searchTerm = filter_input($_GET['searchterm']);
//    $returnData = $phone->searchPhone($searchTerm);
//}else{
//    $returnData = "<div class='alert alert-danger'>Search cannot be empty</div>";
//}

//$searchTerm = filter_input("vendor:apple");
$returnData = $phone->searchPhone("vendor:carrier:");

echo $returnData;

