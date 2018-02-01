<?php
session_start();
include("user.php");
include("includes/header.php");
$user = new User();
$errormsg = "";

if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    session_destroy();
    header("Location: index.php");
}
if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
    if($_SESSION['role']==="admin"){
        if(isset($_GET['userid'])&&!empty($_GET['userid'])){
            if($_GET['userid']!=$_SESSION['userid']){
                $userid = filter_input(INPUT_GET,'userid');
                $errormsg = $user->deleteUser($userid);
                header("Location: registeruser.php");
            }else{
                $errormsg= "<div class='container'><div class='alert alert-danger'>Cannot delete your own account</div></div>";
            }
        }else{
            $errormsg= "<div class='container'><div class='alert alert-danger'>Invalid user id</div></div>";
        }
    }else{
        $errormsg= "<div class='container'><div class='alert alert-danger'>Access denied</div></div>";
    }
}
?>
<div class='container'>
    <?php if($errormsg){header("Refresh: 3; url=dashboard.php");echo $errormsg;}?>
</div>
