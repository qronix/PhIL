<?php

session_start();

$resultData = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&isset($_SESSION['userid'])&&!empty($_SESSION['userid'])){

    include_once ("user.php");
    include_once ("includes/header.php");
    include_once ("includes/sidebar.php");
    $user = new User();
    $userId = $_SESSION['userid'];
    $userIdClean = filter_var($userId,FILTER_SANITIZE_SPECIAL_CHARS);
    $resultData = $user->loadProfile($userIdClean);

}else{
    session_destroy();
    header("Location: index.php");
}

echo $resultData;
