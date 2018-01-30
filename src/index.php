<?php
include("includes/header.php");

?>
<div class="container main col-md-6">
    <div class="container logo">
        <img class="image" src="img/logo.svg">
        <p id="philLogo">PhIL</p>
    </div>
    <div class="container" id="loginArea">
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control">
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