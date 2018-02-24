<?php

session_start();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&($_SESSION['role']=="admin"||$_SESSION['role']=="superuser")){
    if(isset($_POST['vendor'])&&!empty($_POST['vendor']) && isset($_POST['newCarrier'])&&!empty($_POST['newCarrier'])){
         $newCarrier = filter_input(INPUT_POST,'newCarrier',FILTER_SANITIZE_SPECIAL_CHARS);
         $newCarrier = preg_replace('/[^a-zA-Z0-9-_\.]/','',$newCarrier);

         $vendor = filter_input(INPUT_POST,'vendor',FILTER_SANITIZE_SPECIAL_CHARS);
         $newVendor = preg_replace('/[^a-zA-Z0-9-_\.]/','',$vendor);

        include_once("phone.php");
         $phone = new Phone();
         $returnData['message'] = $phone->addCarrier($vendor,$newCarrier);
    }

}else{
    session_destroy();
    header("Location: index.php");
}
echo json_encode($returnData);