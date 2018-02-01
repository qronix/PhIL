<?php
session_start();
if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    header("Location: index.php");
}
include("includes/header.php");
include("includes/sidebar.php");
include("phone.php");


if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']!="admin"){
    header("Location: dashboard.php");
}

$phone = new Phone();
?>

<div class="container editusercontainer col-sm-10">
    <div class="row">
        <div class="container" id="form-message">

        </div>
    </div>
    <div class="row">
        <h2>Add new phone</h2>
    </div>
    <div class="row">
        <div class="container" id="editPhoneArea">
            <form id="edit-form" action="createphone.php" method="POST">
                <div class="form-group editinput" id="username-group">
                    <label for="vendor">Vendor</label>
                    <input type="text" class="form-control" name="vendor" id="vendor" required>
                </div>
                <div class="form-group editinput" id="password-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="form-group editinput" id="passwordverify-group">
                    <label for="passwordverify">Verify password</label>
                    <input type="password" class="form-control" name="passwordverify" id="passwordverify" required>
                </div>
                <div class="form-group editinput" id="email-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                </div>
                <div class="form-group editinput" id="role-group">
                    <label for="role">Role</label>
                    <select id="role" class="form-control" name="role">
                        <option selected>user</option>
                        <option>manager</option>
                        <option>admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" id="editUserBtn" class="btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="userlist">
    <?php
    if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin") {
        ?>
        <script type="text/javascript">
            function clearUsers(){
                var userrows = document.querySelectorAll(".phonerow");
                userrows.forEach(function(user){
                    user.parentNode.removeChild(user);
                });
            }
            //clearUsers();
        </script>
        <?php
        $phone->displayPhones();
    }?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".main").fadeIn(2000);
    });

    $(function(){
        var form=$('#edit-form');
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
            $(".userrow").remove();
            $.ajax({url:"getphones.php"}).done(function(html){
                $("#userlist").append(html);
            });
            $("#form-message").fadeTo(2000, 500).slideUp(500, function(){
                $("#form-message").slideUp(500);
            });
        });
    });
</script>
</body>
</html>
