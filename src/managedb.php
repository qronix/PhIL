<?php

session_start();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin"){
    include ("includes/header.php");
    include ("includes/sidebar.php");
    include ("vendorpanel.php");
}else{
    session_destroy();
    header("Location: index.php");
}