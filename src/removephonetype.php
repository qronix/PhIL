<?php

session_start();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&
    ($_SESSION['role']=="admin"||$_SESSION['role']=="superuser"||$_SESSION['role']=="manager")){
    if(isset($_POST['vendorname'])&&!empty($_POST['vendorname'])){
        if(isset($_POST['phonetype'])&&!empty($_POST['phonetype'])){
            if(isset($_POST['carrier'])&&!empty($_POST['carrier'])){
                $vendorname = filter_input(INPUT_POST,'vendorname',FILTER_SANITIZE_SPECIAL_CHARS);
                $phonetype = filter_input(INPUT_POST,'phonetype',FILTER_SANITIZE_SPECIAL_CHARS);
                $carrier = filter_input(INPUT_POST,'carrier',FILTER_SANITIZE_SPECIAL_CHARS);
//            $resultData = $newphonetype;
                include_once ("phone.php");
                $phone = new Phone();
                $resultData = $phone->removePhoneType($vendorname,$phonetype,$carrier);
            }else{
                $resultData = "Invalid carrier.";
            }
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

//$resultData = $_POST['phonetype'];
echo json_encode($resultData);