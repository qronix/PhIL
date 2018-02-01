<?php
include("includes/header.php");
include("includes/sidebar.php");
include("user.php");

$user = new User();
?>

<div id="userlist">
    <?php $user->displayUsers();?>
</div>



<div class="container main col-md-6">
    <div class="container" id="form-message">

    </div>
    <div class="container logo">
        <img class="image" src="img/logo.svg">
        <p id="philLogo">PhIL</p>
    </div>
    <div class="container" id="loginArea">
        <form id="login-form" action="createuser.php" method="POST">
            <div class="form-group" id="username-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
            </div>
            <div class="form-group" id="password-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group" id="passwordverify-group">
                <label for="passwordverify">Verify password</label>
                <input type="password" class="form-control" name="passwordverify" id="passwordverify" required>
            </div>
            <div class="form-group" id="email-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
            </div>
            <div class="form-group" id="role-group">
                <label for="role">Role</label>
                <select id="role" class="form-control" name="role">
                    <option selected>user</option>
                    <option>manager</option>
                    <option>admin</option>
                </select>
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

    $(function(){
        var form=$('#login-form');
        var formMessage =$('#form-message');

        $(form).submit(function(event){

            $('.alert').remove();
            var formData = {
                'username' : $('input[name=username]').val(),
                'password' : $('input[name=password').val(),
                'passwordverify' : $('input[name=passwordverify]').val(),
                'email' : $('input[name=email]').val(),
                'role' : document.querySelector("#role").value
            };
            $.ajax({
                type:'POST',
                url:$(form).attr('action'),
                data: formData,
                dataType: 'json',
                encode: true
            }).done(function(data){
                console.log(data);
                if(data.errors!==undefined){
                    if(data.errors.username!==undefined){
                        $('#username-group').append("<div class='alert alert-danger'>"+data.errors.username+"</div>");
                    }
                    if(data.errors.password!==undefined){
                        $('#password-group').append("<div class='alert alert-danger'>"+data.errors.password+"</div>");
                    }
                    if(data.errors.passwordverify!==undefined){
                        $('#passwordverify-group').append("<div class='alert alert-danger'>"+data.errors.passwordverify+"</div>");
                    }
                    if(data.errors.email!==undefined){
                        $('#email-group').append("<div class='alert alert-danger'>"+data.errors.email+"</div>");
                    }
                    if(data.errors.role!==undefined){
                        $('#role-group').append("<div class='alert alert-danger'>"+data.errors.role+"</div>");
                    }
                }
                if(data.message!==undefined){
                    $(formMessage).append("<div class='alert alert-warning'>"+data.message+"</div>");
                }
            });
            $('#username').val('');
            $('#password').val('');
            $('#passwordverify').val('');
            $('#email').val('');
            $('#role').val('user');


            event.preventDefault();
            $.ajax({url:"getusers.php"}).done(function(html){
               $("#userlist").append(html);
            });
        });
    });
</script>
</body>
</html>
