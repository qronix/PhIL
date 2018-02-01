<?php
session_start();
if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    header("Location: index.php");
}
include("includes/header.php");
include ("includes/sidebar.php");
include("user.php");

if(!isset($_SESSION)){
    session_start();
}

$error = "";
$user = new User();
$userdata = array();
$message = "";
//$_SESSION['role'] = "admin";
$userid = "";

if(isset($_GET['userid'])&&!empty($_GET['userid'])){
    if(isset($_SESSION['role'])&&$_SESSION['role']==="admin"){
        if($_GET['userid']==$_SESSION['userid']){
            $error = "<div class='alert alert-danger'>Cannot edit active account</div>";
        }
        $userid = filter_input(INPUT_GET,'userid');
        $_SESSION['edituserid'] = $userid;
        $userdata = $user->loadUser($userid);
    }else{
        $error = "<div class='alert alert-danger'>Access denied</div>";
    }
}else{
    $error = "<div class='alert alert-danger'>User id not specified</div>";
}

if(isset($_SESSION['role'])&&$_SESSION['role']==="admin"){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $userid = $_SESSION['edituserid'];
        $username = "";
        $role = "";
        $email = "";
        $activeaccount = "";
        if(isset($_POST['username'])&&!empty($_POST['username'])){
            $username= filter_input(INPUT_POST,'username');
        }else{
            $error = "Username cannot be empty";
        }
        if(isset($_POST['email'])&&!empty($_POST['email'])){
            $emailPre= filter_input(INPUT_POST,'email');
            if(filter_var($emailPre,FILTER_VALIDATE_EMAIL)){
                $email = $emailPre;
            }else{
                $error = "Email is not valid";
            }
        }else{
            $error = "Email cannot be empty";
        }
        if(isset($_POST['activeaccount'])&&!empty($_POST['activeaccount'])){
            $activeaccount= filter_input(INPUT_POST,'activeaccount');
        }else{
            $error = "Active account cannot be empty";
        }
        if(isset($_POST['role'])&&!empty($_POST['role'])){
            $role = filter_input(INPUT_POST,'role');
        }else{
            $error = "Role cannot be empty";
        }
        if($error==""){
            echo "Doing it";
            $message = $user->updateUser($userid,$username,$role,$email,$activeaccount);
            //$user->loadUser($userid);
            header("Location: edituser.php?userid=".$userid);
        }
    }
}
?>

<div class="container editUserFormArea col-md-6">

        <div class='container' id='form-message'>
            <?if($error!=""){echo "<div class='alert alert-danger'>".$error."</div>";}?>
        </div>
    <div class='container' id='form-message'>
        <?if($message!=""){echo "<div class='alert alert-success'>".$message."</div>";}?>
    </div>
    <div class="container formHeader">
        <h2>Edit <?php if(!empty($userdata)){echo $userdata['username'];}?></h2>
    </div>
        <div class='container' id='loginArea'>
                <form id='login-form' action='' method='POST'>
                        <div class='form-group' id='username-group'>
                                <label for='username'>Username</label>
                                <input type='text' class='form-control' name='username' id='username' value=<?php if(!empty($userdata)){echo $userdata['username'];}?> required>
                        </div>
                        <div class='form-group' id='email-group'>
                                <label for='email'>Email</label>
                                <input type='email' class='form-control' name='email' id='email' value=<?php if(!empty($userdata)){echo $userdata['email'];}?> required>
                        </div>
                        <div class='form-group' id='activeaccount-group'>
                                <label for='activeaccount'>Active account</label>
                                <input type='text' class='form-control' name='activeaccount' id='activeaccount' value=<?php if(!empty($userdata)){echo $userdata['activeaccount'];}?> required>
                        </div>
                        <div class='form-group' id='role-group'>
                                <label for='role'>Role</label>
                                <select id='role' class='form-control' name='role'>
                                        <option selected><?php if(!empty($userdata)){echo $userdata['role'];}?></option>
                                        <option>manager</option>
                                        <option>admin</option>
                                        <option>user</option>
                                </select>
                        </div>
                        <button type='submit' class='btn'>Submit</button>
                </form>
        </div>
</div>

</body>
</html>





