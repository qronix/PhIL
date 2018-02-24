<?php

session_start();

$resultData = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&($_SESSION['role']=="admin"||$_SESSION['role']=="superuser")){
    if(isset($_POST['phoneid'])&&!empty($_POST['phoneid'])){
        $rawPhoneid = filter_input(INPUT_POST,'phoneid');
        $cleanPhoneid = preg_replace('/[^a-zA-Z0-9-_\.]/','',$rawPhoneid);
        include_once ("phone.php");
        $phone = new Phone();
        $resultData = $phone->deletePhone($cleanPhoneid);
    }else{
        session_destroy();
        header("Location: index.php");
    }
}else{
    session_destroy();
    header("Location: index.php");
}

echo json_encode($resultData);