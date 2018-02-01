<?php
if(!isset($_SESSION)){
    session_start();
}

include("user.php");

$user = new User();
$data = array();
$errors = array();
$password = "";
$username = "";
$passwordverify = "";
$email = "";
$role = "";
$havepassword = false;
$havepassverify = false;


if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_SESSION['role'])&&$_SESSION['role']==='admin'){

        if(isset($_POST['username'])&&!empty($_POST['username'])){
            $username = filter_input(INPUT_POST,'username');
        }else{
            $errors['username'] = "Username cannot be empty";
        }
        if(isset($_POST['password'])&&!empty($_POST['password'])){
            $password = $_POST['password'];
            $havepassword = true;
        }else{
            $errors['password'] = "Password cannot be empty";
        }
        if(isset($_POST['passwordverify'])&&!empty($_POST['passwordverify'])){
            $passwordverify = $_POST['passwordverify'];
            $havepassverify = true;
        }else{
            $errors['passwordverify'] = "Password verification cannot be blank";
        }
        if($havepassword && $havepassverify){
            if($password!=$passwordverify){
                $errors['passwordverify'] = "Passwords do not match";
            }
        }
        if(isset($_POST['role'])&&!empty($_POST['role'])){
            $role = filter_input(INPUT_POST,'role');
        }else{
            $errors['role'] = "Role cannot be empty";
        }
        if(isset($_POST['email'])&&!empty($_POST['email'])){
            if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                $email = filter_input(INPUT_POST,'email');
            }else{
                $errors['email'] = "Email is not valid";
            }
        }else{
            $errors['email'] = "Email cannot be empty";
        }
        if(sizeof($errors)===0){
            $data['message'] = $user->createUser($username,$password,$passwordverify,$email,$role);
        }
    }else{
        $errors['message'] = "You do not have permission to create a user";
    }
    if(!sizeof($errors)==0){
        $data['errors']=$errors;
    }

    echo json_encode($data);
}


