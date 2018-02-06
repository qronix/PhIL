<?php

session_start();

$errors = array();
$data = array();
include("phone.php");


$phone = new Phone();
$phoneData = array();



if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
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
            if(is_numeric($testImei)){
                $phoneData['imei'] = $testImei;
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
        if(isset($_POST['manager'])&&!empty($_POST['manager'])){
            $phoneData['manager'] = filter_input(INPUT_POST,'manager');

        }else{
            $errors['manager'] = "Manager cannot be empty";
        }
        if(isset($_POST['managerPassword'])&&!empty($_POST['managerPassword'])){
            $phoneData['managerPassword'] = $_POST['managerPassword'];
        }else{
            $errors['managerPassword'] = "Manager password cannot be empty";
        }
        if(isset($_POST['designation'])&&!empty($_POST['designation'])){
            if($_POST['designation'] === "pickup"|| $_POST['designation']==="brightstar"
                ||$_POST['designation']==="walkin"){
                $phoneData['designation'] = filter_input(INPUT_POST,'designation');
            }else{
                $errors['designation'] = "Designation is not valid";
            }
        }else{
            $errors['designation'] = "Designation cannot be empty";
        }
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

//print_r($data);
echo json_encode($data);




