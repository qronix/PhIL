<?php

include ("phone.php");

$phone = new Phone();

$returnData = "";

if(isset($_POST['searchterm'])&&!empty($_POST['searchterm'])){
    $searchTerm = filter_input(INPUT_POST,'searchterm');
    $returnData = $phone->searchPhone($searchTerm);
}else{
    $returnData = "<div class='alert alert-danger'>Search cannot be empty</div>";
}


if($returnData==""){
    $returnData = "<div class='alert alert-danger'>Search could not be completed.</div>";
}
echo $returnData;

