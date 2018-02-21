<?php

session_start();

$resultData = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&
    ($_SESSION['role']=="admin"||$_SESSION['role']=="superuser"||$_SESSION['role']=="manager")){
    if(isset($_POST['vendorname'])&&!empty($_POST['vendorname'])){
        if(isset($_POST['newphonetype'])&&!empty($_POST['newphonetype'])){
            if(isset($_POST['carrier'])&&!empty($_POST['carrier'])){
                $vendorname = filter_input(INPUT_POST,'vendorname',FILTER_SANITIZE_SPECIAL_CHARS);
                $newVendorName = preg_replace('/[^a-zA-Z0-9-_\.]/','',$vendorname);

                $phonetype = filter_input(INPUT_POST,'newphonetype',FILTER_SANITIZE_SPECIAL_CHARS);
                $newPhonetype = preg_replace('/[^a-zA-Z0-9-_\.]/','',$phonetype);


                $carrier = filter_input(INPUT_POST,'carrier',FILTER_SANITIZE_SPECIAL_CHARS);
                $newCarrier= preg_replace('/[^a-zA-Z0-9-_\.]/','',$carrier);


                include_once ("phone.php");
                $phone = new Phone();
                $resultData = $phone->createPhoneType($newVendorName,$newPhonetype,$newCarrier);
        }else{
                $resultData = "Invalid carrier";
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

echo json_encode($resultData);