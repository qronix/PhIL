<?php

session_start();

$resultData = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&isset($_SESSION['userid'])&&!empty($_SESSION['userid'])){

    include_once ("user.php");
    $user = new User();
    $userId = filter_input(INPUT_SESSION,'userid',FILTER_SANITIZE_SPECIAL_CHARS);
    $resultData = $user->loadProfile($userId);

}else{
    session_destroy();
    header("Location: index.php");
}

echo json_encode($resultData);