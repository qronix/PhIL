<?php
session_start();
//
//if(!isset($_SESSION)){
//    session_start();
//}

if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    header("Location: index.php");

}

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
    include("includes/header.php");
    include("includes/sidebar.php");
}