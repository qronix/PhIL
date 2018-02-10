<?php

session_start();

include("phone.php");

$phone = new Phone();
$returnData = array();
$errors = array();
$phoneData = array();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
    if(isset($_SESSION['phoneeditid'])&&!empty($_SESSION['phoneeditid'])){
        $phoneid = $_SESSION['phoneeditid'];
        $phoneData['phoneid'] = $phoneid;
    }else{
        $errors['phoneid'] = "<div class='alert alert-danger'>Invalid phone ID</div>";
    }if(isset($_POST['manager'])&&!empty($_POST['manager'])){
        if($_POST['manager'] !== $_SESSION['username']){
            $manager = filter_input(INPUT_POST,'manager');
            $phoneData['manager'] = $manager;
        }else{
            $errors['manager'] = "<div class='alert alert-warning'>Manager cannot be current user</div>";
        }
    }else{
        $errors['manager'] = "<div class='alert alert-danger'>Manager cannot be empty</div>";
    }if(isset($_POST['managerpassword'])&&!empty($_POST['managerpassword'])){
        $phoneData['managerpassword'] = $_POST['managerpassword'];
    }else{
        $errors['phoneid'] = "<div class='alert alert-danger'>Manager password cannot be empty</div>";
    }if(isset($_POST['designation'])&&!empty($_POST['designation'])){
        $designation = filter_input(INPUT_POST,'designation');
        $phoneData['designation'] = $_POST['designation'];
    }else{
        $errors['designation'] = "<div class='alert alert-danger'>Designation is not valid</div>";
    }
    if(sizeof($errors)==0){
        $returnData['message']= "<div class='alert alert-warning'>".$phone->updatePhone($phoneData)."</div>";
//        $returnData['message']="TESTING";//$phone->updatePhone($phoneData);
    }
    if(sizeof($errors)!=0){
        $returnData['errors'] = $errors;
    }
}else{
//    $returnData = "<div class='alert alert-danger'>Invalid Session</div>";
    header("Location: index.php");
}

echo json_encode($returnData);