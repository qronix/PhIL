<?php
include("includes/header.php");
include("user.php");

$errormsg = "";
$username = "";
$password = "";
$user = new User();

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['username'])&&!empty($_POST['username'])){
        $username = filter_input(INPUT_POST,'username');
    }else{
        $errormsg = "Username cannot be empty";
    }
    if(isset($_POST['password'])&&!empty($_POST['password'])){
        $password = filter_input(INPUT_POST,'password');
    }else{
        $errormsg .= "\nPassword cannot be empty";

    }
    if(!empty($username) && !empty($password) && empty($errormsg)){
        $errormsg = $user->login($username,$password);
    }

}

?>
<div class="container main col-md-6">
    <?php if(!empty($errormsg)){

        $alert = "<div class='alert alert-danger'>";
        $alert .= $errormsg;
        $alert .= "</div>";
        echo $alert;
    }?>
    <div class="container logo">
        <img class="image" src="img/logo.svg">
        <p id="philLogo">PhIL</p>
    </div>
    <div class="container" id="loginArea">
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn">Submit</button>
            <a href="forgot.php" id="forgotLink">Forgot password?</a>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".main").fadeIn(2000);
    });

</script>
  </body>
</html>