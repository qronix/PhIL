<?php

session_start();

$errors = array();
$data = array();
include("phone.php");


$phone = new Phone();
$phoneData = array();



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
            $newImei = preg_replace('/[^a-zA-Z0-9-_\.]/','',$testImei);

            if(is_numeric($newImei)){
                $phoneData['imei'] = $newImei;
            }else{
                $errors['imei'] = "Not a valid imei";
            }
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
    $data['message'] = $phone->createPhone($phoneData);
}
else if(sizeof($errors)!==0){
    $data['errors'] = $errors;
}
;
echo json_encode($data);




