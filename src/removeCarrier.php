<?php
session_start();

$returnData = array();
$carrier = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin"){
    if(isset($_POST['vendor'])&&!empty($_POST['vendor'])
    &&isset($_POST['carrier'])&&!empty($_POST['carrier'])){
        $vendor = filter_input(INPUT_POST,'vendor');
        $carrier = filter_input(INPUT_POST,'carrier');
    include("phone.php");
    $phone = new Phone();
    $returnData['message'] = $phone -> removeCarrier($vendor,$carrier);
    }else{
        $returnData['message'] = "Invalid request";
    }
}else{
    session_destroy();
    header("Location: index.php");
}

echo json_encode($returnData);