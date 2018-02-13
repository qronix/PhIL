<?php

session_start();

include ("user.php");
$user = new User();
$returnMsg = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&& $_SESSION['role']=="admin"){
    if(isset($_POST['userid'])&&!empty($_POST['userid'])){
        if(is_numeric($_POST['userid'])){
            $userid = filter_input(INPUT_POST,"userid");
            $returnMsg = $user->resetPass($userid);
        }else{
            session_destroy();
            header("Location: index.php");
        }
    }
}else{
    session_destroy();
    header("Location: index.php");
}

echo $returnMsg;