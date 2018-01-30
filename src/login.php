<?php
include("user.php");

$username = "";
$password = "";
$user = new User();
$data = array(); //return data for AJAX request
$errors = array(); //Error array to pass to AJAX data

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['username'])&&!empty($_POST['username'])){
        $username = filter_input(INPUT_POST,'username');
    }else{
        $errors['username'] = "Username cannot be empty";
    }
    if(isset($_POST['password'])&&!empty($_POST['password'])){
        $password = filter_input(INPUT_POST,'password');
    }else{
        $errors['password'] = "Password cannot be empty";

    }
    if(!empty($username) && !empty($password)){
        $data['message'] = "Got data";
    }
    if(!empty($username) && !empty($password) && empty($errormsg)){
        $errors['login'] = $user->login($username,$password);
    }
    if(!sizeof($errors)==0){
        $data['errors'] = $errors;
    }

    echo json_encode($data);
}

?>