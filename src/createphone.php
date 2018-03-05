<?php

session_start();

$errors = array();
$data = array();
include("phone.php");


$phone = new Phone();
$phoneData = array();
$multiImeis = array();
$cleanImeis = array();


if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&($_SESSION['role']==="admin"
        ||$_SESSION['role']==="manager"||$_SESSION['role']==="superuser")){
    if($_SERVER['REQUEST_METHOD']==="POST"){
        if(isset($_POST['vendor'])&&!empty($_POST['vendor'])){
            $phoneData['vendor'] = filter_input(INPUT_POST,'vendor');

        }else{
            $errors['vendor'] = "Vendor cannot be empty";
        }
        if(isset($_POST['carrier'])&&!empty($_POST['carrier'])){
            $phoneData['carrier'] = filter_input(INPUT_POST,'carrier');

        }else{
            $errors['carrier'] = "Carrier cannot be empty";
        }
        if(isset($_POST['phone'])&&!empty($_POST['phone'])){
            $phoneData['phone'] = filter_input(INPUT_POST,'phone');

        }else{
            $errors['phone'] = "Phone cannot be empty";
        }
        if(isset($_POST['imei'])&&!empty($_POST['imei'])){

            $testImei = filter_input(INPUT_POST,'imei');

            $multiImeis = explode(',',$testImei);

            foreach ($multiImeis as $imei =>$value){
                $value = preg_replace('/[^0-9]/','',$value);
            }
            foreach ($multiImeis as $imei =>$value){
                if(strlen($value)!==6){
                    unset($multiImeis[$imei]);
                }
            }
            foreach ($multiImeis as $imei => $value){
                if(is_numeric($value)){
                    array_push($cleanImeis,$value);
                }else{
                    $errors['imei'] = "Not a valid imei or imei batch";
                    break;
                }
            }
//            if(is_numeric($newImei)){
//                $phoneData['imei'] = $newImei;
//            }else{
//                $errors['imei'] = "Not a valid imei";
//            }
        }else{
            $errors['imei'] = "Imei cannot be empty";
        }
        if(isset($_SESSION['username'])&&!empty($_SESSION['username'])){
            $phoneData['employee'] = $_SESSION['username'];

        }else{
            $errors['employee'] = "Invalid employee";
        }
        $phoneData['designation'] = "inventory";
    }else{
        $errors['request'] = "Invalid request";
    }
}else{
    $errors['session'] = "Invalid session";
}
if(sizeof($errors) === 0){
    $display="<div class='modal phoneBulkMessages' role='dialog'>";
    $display.="<div class='modal-dialog' role='document'>";
    $display.="<div class='modal-content'>";
    $display.="<div class='modal-header'>";
    $display.="<h5 class='modal-title'>Create phone results</h5>";
    $display.="<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    $display.="<span aria-hidden='true'>&times;</span>";
    $display.="</button>";
    $display.="</div>";
    $display.="<div class='modal-body'>";
    foreach ($cleanImeis as $imei=>$value){
        $phoneData['imei']=$value;
        $message = $phone->createPhone($phoneData);
        $display.="<div class='container row'>";
        $display.= "<p>".$message."</p>";
//        $data['message'] = $phone->createPhone($phoneData);
        if(strpos($message,"Error:") !==false){
            break;
        }
        $display.="</div>";

    }
    $display.="</div>";
    $display.="</div>";
    $display.="</div>";
    $display.="</div>";
//    foreach ($cleanImeis as $imei=>$value){
//            $phoneData['imei']=$value;
//            $data['message'] = $phone->createPhone($phoneData);
//            if(strpos($data['message'],"Error:") !==false){
//                break;
//            }
//    }
    $data['message']=$display;
}
else if(sizeof($errors)!==0){
    $data['errors'] = $errors;
}

echo json_encode($data);




