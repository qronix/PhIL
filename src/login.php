<?php

include("user.php");

$errormsg = "";
$username = "";
$password = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['username'])&&!empty($_POST['username'])){
        $username = filter_input(INPUT_POST,'username');
    }else{
        $errormsg = "<div class='alert alert-danger' role='alert'>";
        $errormsg .= "Username cannot be empty";
        $errormsg .= "</div>";
    }
    if(isset($_POST['password'])&&!empty($_POST['password'])){
        $password = filter_input(INPUT_POST,'password');
    }else{
        $errormsg = "<div class='alert alert-danger' role='alert'>";
        $errormsg .= "Password cannot be empty";
        $errormsg .= "</div>";
    }
    if(!empty($username) && !empty($password) && empty($errormsg)){
        $errormsg = login($username,$password);
    }

}

