<?php

session_start();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&
    ($_SESSION['role']=="admin"||$_SESSION['role']=="superuser"||$_SESSION['role']=="manager")){
    if(isset($_POST['vendorname'])&&!empty($_POST['vendorname'])){
        if(isset($_POST['newphonetype'])&&!empty($_POST['newphonetype'])){
            $newphonetype = filter_input($_POST['newphonetype']);
            include_once ("phone.php");
            $phone = new Phone();
            $resultData = $phone->createPhoneType($vendorname);
        }else{
            $resultData = "Phone type is invalid";
        }
    }else{
        session_destroy();
        header("Location: index.php");
    }
}else{
    session_destroy();
    header("Location: index.php");
}

echo json_encode($resultData);