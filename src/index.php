<?php
include("includes/header.php");
if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
    header("Location: dashboard.php");
}
?>
<div class="container main col-md-6">
    <div class="container" id="form-message">

    </div>
    <div class="container logo">
        <img class="image" src="vendor/icons/Best_Buy_Logo.svg">
        <p id="philLogo">PhIL</p>
    </div>
    <div class="container" id="loginArea">
        <form id="login-form" action="login.php" method="POST">
            <div class="form-group" id="username-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
            </div>
            <div class="form-group" id="password-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" class="btn">Submit</button>
<!--            <a href="forgot.php" id="forgotLink">Forgot password?</a>-->
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".main").fadeIn(2000);
    });

    $(function(){
        var form=$('#login-form');
        var formMessage =$('#form-message');

        $(form).submit(function(event){

        $('.alert').remove();
           var formData = {
               'username' : $('input[name=username]').val(),
               'password' : $('input[name=password').val()
           };

            $.ajax({
                type:'POST',
                url:$(form).attr('action'),
                data: formData,
                dataType: 'json',
                encode: true,
                success: function(data){
                    console.log(data);
                    if(data.errors.login==="login"){
                        window.location.href = 'dashboard.php';
                    }
                }
        }).done(function(data){
                if(data.errors){
                    console.log(data.errors);
                    if(data.errors.username){
                        $('#username-group').append("<div class='alert alert-danger'>"+data.errors.username+"</div>");
                    }
                    if(data.errors.password){
                        $('#password-group').append("<div class='alert alert-danger'>"+data.errors.password+"</div>");
                    }
                    if(data.errors.login&&data.errors.login!=="login"){
                        $(formMessage).append("<div class='alert alert-danger'>"+data.errors.login+"</div>");
                    }
                }
            });
            $('#username').val('');
            $('#password').val('');

            event.preventDefault();
        });

    });
</script>
  </body>
</html>